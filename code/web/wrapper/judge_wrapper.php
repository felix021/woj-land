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
        $cmd .= append_arg('-S', null);
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
    if ($nWrite != $source['length'])
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
    //把具体的目录名称过滤,不暴露给用户
    $extra_info = str_replace($temp_dir, '', $extra_info);
    $extra_info = str_replace($data_dir, '', $extra_info);

    //将judge结果更新到数据库
        //TODO  problem_at_contenst 和 user_at_contest 表

        //TODO  admin提交的情况
        
        //TODO  rejudge的情况

    //以下是普通情况(非比赛、非adimn、非rejudge)
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

        $submit       = $user['submit'] + 1;
        $solved       = $user['solved'];
        $solved_list  = $user['solved_list'];
        $has_accpeted = preg_match('/\b'.$problem_id.'\b/', $solved_list);
        if ($result == land_conf::OJ_AC && !$has_accpeted)
        {
            $solved++;
            $solved_list .= "|" . $problem_id;
        }
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

        //更新problems表
        $set_ac = $result == land_conf::OJ_AC ? '`, accepted`=`accepted`+1' : '';
        $sql = <<<eot
UPDATE `problems` SET
`submitted`=`submitted`+1
$set_ac
eot;
        $res = db_query($conn, $sql);
        if (false == $res || 0 == $conn->affected_rows)
        {
            FM_LOG_WARNING("update problem info failed");
            break;
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
