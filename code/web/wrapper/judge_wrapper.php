#!/usr/bin/php
<?php

if (!defined("ROOT"))
{
    define("ROOT", dirname(dirname(__FILE__)));
    define("CONF_ROOT",     ROOT . "/conf");
    define("MODULE_ROOT",   ROOT . "/module");
    define("LIB_ROOT",      ROOT . "/lib");
    define("TPL_ROOT",      ROOT . "/tpl");
    define("CACHE_ROOT",    ROOT . "/cache");
}

require_once(CONF_ROOT . "/land.cfg.php");
require_once(CONF_ROOT . "/wrapper.cfg.php");
require_once(LIB_ROOT . "/logger.lib.php");
require_once(LIB_ROOT . "/misc.lib.php");
require_once(LIB_ROOT . "/db.lib.php");

$temp_dir = "/tmp/should_not_exist_dir";

if (false == logger::log_open(wrapper_conf::LOG_PATH))
{
    exit(1);
}

try
{
    //必须由第一个命令行参数指定source_id
    if ($argc < 2)
    {
        FM_LOG_WARNING("not enough arguments: arg count = %d", $argc);
        throw new Exception("");
    }

    $src_id = (int) $argv[1];
    FM_LOG_TRACE("src_id: %d", $src_id);

    //取出该代码
    $conn = db_connect();
    fail_test($conn, false);

    $sql = "SELECT * FROM `sources` WHERE `source_id`=$src_id";
    $source = db_fetch_line($conn, $sql);
    if (false === $source)
    {
        FM_LOG_WARNING("not existed source id: %d", $src_id);
        throw new Exception("");
    }

    //取出代码对应的题目
    $problem_id = (int)$source['problem_id'];
    $sql = "SELECT * FROM `problems` WHERE `problem_id`=$problem_id";
    $problem = db_fetch_line($conn, $sql);
    if (false === $source)
    {
        FM_LOG_WARNING("not existed problem id: %d", $problem_id);
        throw new Exception("");
    }
    //judge过程比较耗时,暂时关闭连接
    db_close($conn);

    //如果该source的结果不是OJ_WAIT, 那么就是rejudge的情况了
    $is_rejudge = ($source['result'] == land_conf::OJ_WAIT) ? false : true;

    //准备给judge的参数
    $temp_dir = wrapper_conf::TEMP_PATH . "/" . $src_id;
    $data_dir = wrapper_conf::DATA_PATH . "/" . $problem_id;
    $lang     = $source['lang'];
    $src_file = $temp_dir . "/" . $src_id . "." . wrapper_conf::$extension[$lang];
    $cmd = wrapper_conf::JUDGE_PATH;
    $cmd .= append_arg('u', $src_id);
    //$cmd .= append_arg('l', $lang);
    $cmd .= append_arg('s', $src_file);
    $cmd .= append_arg('n', $problem_id);
    $cmd .= append_arg('D', $data_dir);
    $cmd .= append_arg('d', $temp_dir);
    $cmd .= append_arg('t', $problem['time_limit']);
    $cmd .= append_arg('m', $problem['memory_limit']);
    if ($problem['spj'] == 1)
    {
        $cmd .= append_arg('S', null);
    }
    FM_LOG_TRACE("cmd: %s", $cmd);

    //准备临时目录
    system("rm -rf " . escapeshellcmd($temp_dir)); //先清了
    mkdir($temp_dir, 0755, true); //重新建
    if (!is_dir($temp_dir) || !is_writeable($temp_dir))
    {
        FM_LOG_WARNING("$temp_dir is not writeable");
        throw new Exception("");
    }

    //写入代码
    $nWrite = file_put_contents($src_file, $source['source_code']);
    if ($nWrite != strlen($source['source_code']))
    {
        FM_LOG_WARNING("write to $src_file failed");
        throw new Exception("");
    }

    //执行judge
    $status = -1;
    $output = system($cmd, $status);
    FM_LOG_TRACE("exit status: %d; output: %s", $status, $output);

    //解析结果
    $result = 0; $memory_usage = 0; $time_usage = 0;
    if ($status != 0)
    {
        //非正常退出,属于System Error
        $result = land_conf::OJ_SE;
    }
    else
    {
        //取出judge的正常输出
        sscanf($output, "%d%d%d", $result, $memory_usage, $time_usage);
    }

    //judge时间
    $judge_time = date("Y-m-d H:i:s");

    //读取CE或者RE可能会有的信息
    $extra_info = "";
    if ($result == land_conf::OJ_CE || $result == land_conf::OJ_SE)
    {
        $stderr_compiler = $temp_dir . '/' . 'stderr_compiler.txt';
        $extra_info = file_get_contents($stderr_compiler);
    }
    else 
    {
        $stderr_executive = $temp_dir . '/' . 'stderr_executive.txt';
        $extra_info = file_get_contents($stderr_executive);
    }
    //把具体的目录名称过滤, 不暴露给用户
    $extra_info = str_replace($temp_dir . '/', '', $extra_info);
    $extra_info = str_replace($data_dir, '', $extra_info);

    //将judge结果更新到数据库
        //TODO  problem_at_contenst 和 user_at_contest 表

        //TODO  admin提交的情况
        
        //TODO  rejudge的情况

    //以下是普通情况(非比赛、非admin、非rejudge)
    $conn = db_connect();
    fail_test($conn);

    $res = db_query($conn, 'START TRANSACTION');
    fail_test($res, false);

    $in_trans = true;
    do
    {
        //更新sources表
        $extra_info = db_escape($conn, $extra_info);
        $sql = <<<eot
UPDATE `sources` SET
    `judge_time`   = '$judge_time',
    `memory_usage` = $memory_usage,
    `time_usage`   = $time_usage,   
    `result`       = $result,
    `extra_info`   = '$extra_info' 
  WHERE `source_id`=$src_id
eot;
        $res = db_query($conn, $sql);
        if (false === $res || 0 == $conn->affected_rows)
        {
            FM_LOG_WARNING("update sources failed");
            break;
        }

        //更新users表
        $user_id = $source['user_id'];
        $user = db_fetch_line($conn, 'SELECT `submit`, `solved`, `solved_list` FROM `users` WHERE `user_id`=' . $user_id);
        if (false == $user || 0 == $conn->affected_rows)
        {
            FM_LOG_WARNING("get user info failed");
            break;
        }

        $need_update  = true;
        $submit       = $user['submit'];
        $solved       = $user['solved'];
        $arr_solved   = explode("|", $user['solved_list']);
        $has_accepted = in_solved_list($problem_id, $user['solved_list']);
        if (false === $is_rejudge)
        {
            //如果不是rejudge
            $submit++; //多提交了一次
            if (!$has_accepted && $result == land_conf::OJ_AC)
            {
                //如果是第一次ac这题
                $solved++; //多ac了一题
                $arr_solved[] = $problem_id; //把题号加到过题list里
            }
        }
        else
        {
            //如果是rejudge
            if (!$has_accepted && $source['result'] != land_conf::OJ_AC && $result == land_conf::OJ_AC)
            {
                //如果未曾AC过此题，且之前不是AC, 而这次AC了
                $solved++;
                $arr_solved[] = $problem_id;
            }
            else if ($source['result'] == land_conf::OJ_AC && $result != land_conf::OJ_AC)
            {
                $need_update = false;
                //如果之前是AC, 而这次没AC
                /*
                 * 把这题从 过题list 里删掉
                 * 如果提交了两次a(真的AC),b(假的AC), rejudge b以后会把此id去掉，就忽
                 * 略了a的结果。如果要计算进a的结果，那么会需要从之前的list里再去翻一
                 * 遍，效率很低。因此Felix在设计上允许存在此误差，以提高效率。
                $solved--; //过题数减一
                for ($i = 0; $i < count($arr_solved); $i++)
                    if ($arr_solved[$i] == $solved)
                        unset($arr_solved[$i]);
                 */
            }
            else
            {
                $need_update = false;
            }
        }
        if ($need_update)
        {
            $solved_list = implode('|', array_unique($arr_solved));
            $sql = <<<eot
UPDATE `users` SET
    `submit`=$submit,
    `solved`=$solved,
    `solved_list`='$solved_list'
WHERE `user_id`=$user_id
eot;
            $res = db_query($conn, $sql);
            if (false == $res || 0 == $conn->affected_rows)
            {
                FM_LOG_WARNING("update users failed");
                break;
            }
        }

        //更新problems表
        $need_update = true;
        $sql = 'UPDATE `problems` SET ';
        if (false == $is_rejudge)
        {
            //不是rejudge
            $sql .= '`submitted`=`submitted`+1 ';
            if ($result == land_conf::OJ_AC)
            {
                $sql .= ', `accepted`=`accepted`+1 ';
            }
        }
        else
        {
            //如果是rejudge
            if ($source['result'] == land_conf::OJ_AC && $result != land_conf::OJ_AC)
            {
                //如果之前是AC, 而这次没AC
                $sql .= '`accepted`=`accepted`-1 ';
            }
            else if ($source['result'] != land_conf::OJ_AC && $result == land_conf::OJ_AC)
            {
                //如果之前没AC, 这次AC
                $sql .= '`accepted`=`accepted`+1 ';
            }
            else
            {
                //如果前后都AC或者前后都没AC, 那就不要更新数据库了
                $need_update = false;
            }
        }
        $sql .= ' WHERE `problem_id`=' . $problem_id;

        if ($need_update)
        {
            $res = db_query($conn, $sql);
            if (false == $res || 0 == $conn->affected_rows)
            {
                FM_LOG_WARNING("update problem info failed");
                break;
            }
        }

        $in_trans = false;
    }
    while (0);

    if ($in_trans)
    {
        db_query($conn, 'ROLLBACK');
        throw new Exception('');
    }
    else
    {
        $res = db_query($conn, 'COMMIT');
        if (false == $res)
        {
            FM_LOG_WARNING('fuck, commit failed');
            db_query($conn, 'ROLLBACK');
            throw new Exception("");
        }
    }

    db_close($conn);
    system("rm -rf " . escapeshellcmd($temp_dir));
    exit(0);

}
catch (Exception $e)
{
    FM_LOG_WARNING("Exception: %s", $e->getMessage());
    if (is_dir($temp_dir))
    {
        system("rm -rf " . escapeshellcmd($temp_dir));
    }
    db_close_all();
    exit(1);
}

function append_arg($k, $v = null)
{
    $str = " -" . $k;
    if (!is_null($v))
    {
        $str .= " " . escapeshellcmd($v);
    }
    return $str;
}

?>
