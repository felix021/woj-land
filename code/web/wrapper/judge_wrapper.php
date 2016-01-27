#!/usr/bin/php
<?php

error_reporting(E_ALL);

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
require_once(CONF_ROOT . "/score.cfg.php");
require_once(LIB_ROOT . "/logger.lib.php");
require_once(LIB_ROOT . "/misc.lib.php");
require_once(LIB_ROOT . "/db.lib.php");
require_once(MODULE_ROOT . "/problem/problem.func.php");
require_once(MODULE_ROOT . "/problem/problem_contest_info.class.php");
require_once(MODULE_ROOT . "/contest/contest.func.php");

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
    logger::log_add_info("src_id:" . $src_id);
    $admin_submit = $src_id < 0 ? true : false;
    $src_id = abs($src_id);
    $tbl_sources  = $admin_submit ? 'admin_sources' : 'sources';

    FM_LOG_TRACE("src_id: %d, admin: %s", $src_id, $admin_submit ? "Yes" : "No");

    //取出该代码
    $conn = db_connect();
    fail_test($conn, false);

    $sql = "SELECT * FROM `{$tbl_sources}` WHERE `source_id`=$src_id";
    $source = db_fetch_line($conn, $sql);
    if (false === $source)
    {
        FM_LOG_WARNING("not existed source id: %d", $src_id);
        throw new Exception("");
    }
    $submit_time = strtotime($source['submit_time']);

    //取出代码对应的题目
    $problem_id = (int)$source['problem_id'];
    $sql = "SELECT * FROM `problems` WHERE `problem_id`=$problem_id";
    $problem = db_fetch_line($conn, $sql);
    if (false === $source)
    {
        FM_LOG_WARNING("not existed problem id: %d", $problem_id);
        throw new Exception("");
    }

    $in_contest = false;
    $contest_id = (int)$problem['contest_id'];
    if (!$admin_submit && $contest_id > 0)
    {
        $sql = 'SELECT * FROM `contests` WHERE `contest_id`=' . $contest_id;
        $contest = db_fetch_line($conn, $sql);
        if (false === $source)
        {
            FM_LOG_WARNING("not existed problem id: %d", $problem_id);
            throw new Exception("");
        }
        $status = contest_status($contest['start_time'], $contest['end_time']);
        if ($status == land_conf::CONTEST_RUNNING)
            $in_contest = true;
    }

    FM_LOG_TRACE("in_contest: %s", $in_contest ? "YES" : "NO");

    //judge过程比较耗时,暂时关闭连接
    db_close($conn);

    //如果该source的结果不是OJ_WAIT, 那么就是rejudge的情况了
    $is_rejudge = ($source['result'] == land_conf::OJ_WAIT) ? false : true;

    //准备给judge的参数
    $temp_dir = wrapper_conf::TEMP_PATH . "/" . $src_id;
    $data_dir = wrapper_conf::DATA_PATH . "/" . $problem_id;
    $lang     = $source['lang'];
    $src_file = '';
    if ($lang != land_conf::LANG_JAVA)
    {
        $src_file = $temp_dir . "/" . $src_id . "." . wrapper_conf::$extension[$lang];
    }
    else
    {
        $src_file = $temp_dir . "/Main." . wrapper_conf::$extension[$lang];
    }
    $cmd = wrapper_conf::JUDGE_PATH_ROOT . wrapper_conf::$judge_path;
    $cmd .= append_arg('u', $src_id);
    $cmd .= append_arg('l', $lang);
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
    /*
    else 
    {
        //用户程序的stderr信息不能暴露给用户
        $stderr_executive = $temp_dir . '/' . 'stderr_executive.txt';
        $extra_info = file_get_contents($stderr_executive);
    }
     */
    //把具体的目录名称过滤, 不暴露给用户
    $extra_info = str_replace($temp_dir . '/', '', $extra_info);
    $extra_info = str_replace($data_dir, '', $extra_info);

    //-----------------------分割线-----------------------------------
    //将judge结果更新到数据库

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
UPDATE `{$tbl_sources}` SET
    `judge_time`   = '$judge_time',
    `memory_usage` = $memory_usage,
    `time_usage`   = $time_usage,   
    `result`       = $result,
    `extra_info`   = '$extra_info' 
  WHERE `source_id`=$src_id
eot;
        $res = db_query($conn, $sql);
        if (false === $res)
        {
            FM_LOG_WARNING("update sources failed");
            break;
        }
        FM_LOG_TRACE('%s updated', $tbl_sources);

        if ($admin_submit)
        {
            $in_trans = false;
            //如果是admin的提交，就不用更新其他信息了
            break;
        }

        //更新users表
        $user_id = $source['user_id'];
        $user = db_fetch_line($conn, 'SELECT `submit`, `solved`, `solved_list` FROM `users` WHERE `user_id`=' . $user_id);
        if (false == $user)
        {
            FM_LOG_WARNING("get user info failed");
            break;
        }

        $need_update  = true;
        $solved       = $user['solved'];
        $arr_solved   = explode("|", $user['solved_list']);
        $has_accepted = in_solved_list($problem_id, $user['solved_list']);
        FM_LOG_DEBUG("solved: %s, has_acc: %s", print_r($arr_solved, true), $has_accepted?'Yes':'No');
        if (false === $is_rejudge)
        {
            //如果不是rejudge
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

        $update_score = '';
        FM_LOG_TRACE("before difficulty");
        if (!$has_accepted && $result == land_conf::OJ_AC) {
            if ($problem['difficulty'] == score_conf::EASY) {
                $update_score = ' , `easy`=`easy`+1 ';
            }
            else if ($problem['difficulty'] == score_conf::MEDIUM) {
                $update_score = ' , `medium`=`medium`+1 ';
            }
            else if ($problem['difficulty'] == score_conf::DIFFICULT) {
                $update_score = ' , `difficult`=`difficult`+1 ';
            }
            else {
                FM_LOG_WARNING("difficulty: BAD case!");
                break;
            }
            $need_update = true;
            FM_LOG_TRACE("do update diffifulty");
        }
        FM_LOG_TRACE("after diffifulty");

        if ($need_update)
        {
            $arr_solved  = array_filter($arr_solved, create_function('$a', 'return $a > 0;'));
            $arr_solved  = array_unique($arr_solved);
            //$arr_solved  = sort($arr_solved);
            $solved_list = implode('|', $arr_solved);
            FM_LOG_DEBUG("solved_list: %s", $solved_list);
            $sql = <<<eot
UPDATE `users` SET
    `solved`=$solved,
    `solved_list`='$solved_list'
    $update_score
WHERE `user_id`=$user_id
eot;
            $res = db_query($conn, $sql);
            if (false == $res)
            {
                FM_LOG_WARNING("update users failed");
                break;
            }
        }
        FM_LOG_TRACE('users updated');

        //更新problems表
        $need_update = true;
        $sql = 'UPDATE `problems` SET ';
        if (false == $is_rejudge)
        {
            //不是rejudge
            if ($result == land_conf::OJ_AC)
            {
                $sql .= ' `accepted`=`accepted`+1 ';
            }
            else
            {
                $need_update  = false;
            }
        }
        else
        {
            //如果是rejudge
            if ($source['result'] == land_conf::OJ_AC && $result != land_conf::OJ_AC)
            {
                //如果之前是AC, 而这次没AC
                $sql .= ' `accepted`=`accepted`-1 ';
            }
            else if ($source['result'] != land_conf::OJ_AC && $result == land_conf::OJ_AC)
            {
                //如果之前没AC, 这次AC
                $sql .= ' `accepted`=`accepted`+1 ';
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
            if (false == $res)
            {
                FM_LOG_WARNING("update problem info failed");
                break;
            }
        }
        FM_LOG_TRACE('problems updated');

        //不是管理员的提交，且比赛正在进行，则需要更新
        // problem_at_contest 和 user_at_contest 两个表
        if (!$admin_submit && $in_contest)
        {
            FM_LOG_TRACE("update contest related tables");
            //更新problem_at_contest
            function get_field_by_result($result)
            {
                $field = '';
                switch ($result)
                {
                case land_conf::OJ_AC:  $field = 'AC'; break;
                case land_conf::OJ_PE:  $field = 'PE'; break;
                case land_conf::OJ_CE:  $field = 'CE'; break;
                case land_conf::OJ_WA:  $field = 'WA'; break;
                case land_conf::OJ_RE_SEGV:
                case land_conf::OJ_RE_FPE: 
                case land_conf::OJ_RE_BUS: 
                case land_conf::OJ_RE_ABRT: 
                case land_conf::OJ_RE_UNKNOWN: 
                case land_conf::OJ_RE_JAVA: 
                                        $field = 'RE'; break;
                case land_conf::OJ_TLE: $field = 'TLE'; break;
                case land_conf::OJ_MLE: $field = 'MLE'; break;
                case land_conf::OJ_OLE: $field = 'OLE'; break;
                default: /* ignore */ break;
                }
                return $field;
            }
            $field1 = get_field_by_result($result);
            $field2 = $is_rejudge ? get_field_by_result($source['result']) : '';
            //如果是需要更新的field，并且rejudge的结果跟之前不同, 需要更新
            if (!empty($field1) && $result != $source['result'])
            {
                $c_f2 = empty($field2) ? '' : ", `$field2`=`$field2`-1";
                $sql = <<<EOT
UPDATE `problem_at_contest` SET `$field1`=`$field1`+1 $c_f2
    WHERE `contest_id`=$contest_id AND `problem_id`=$problem_id
EOT;
                $res = db_query($conn, $sql);
                if (false == $res)
                {
                    FM_LOG_WARNING("update problem_at_contenst failed");
                    break;
                }
            }
            FM_LOG_TRACE('problem_at_contest updated');

            //更新user_at_contest
            $sql = <<<eot
SELECT * FROM `user_at_contest` 
    WHERE `user_id`=$user_id AND `contest_id`=$contest_id
eot;
            $user_contest_info = db_fetch_line($conn, $sql);
            if (false == $user_contest_info)
            {
                FM_LOG_WARNING('select from user_at_contest failed');
                break;
            }

            //获取user在这场比赛中的提交信息
            $info_json = json_decode($user_contest_info['info_json']);
            if (null === $info_json || !is_array($info_json))
            {
                $info_json = array();
            }

            $seq = $problem['contest_seq'];
            $idx = pgi_get_idx_by_seq($info_json, $seq);
            $pinfo = &$info_json[$idx];

            FM_LOG_DEBUG('next update');

            $sql = 'UPDATE `user_at_contest` SET ';
            if ($result == land_conf::OJ_AC)
            {
                if ($is_rejudge) //如果是rejudge, 那么AC以后的记录全部都去掉
                {
                    $pinfo->wrongs = array_filter($pinfo->wrongs, 
                        create_function('$a', "return \$a < $src_id;")
                    );
                }

                $start_time = strtotime($contest['start_time']);
                FM_LOG_DEBUG('submit_time: %d, start_time: %d', $submit_time, $start_time);
                $ac_time = $submit_time - $start_time;
                if ($pinfo->ac_time == 0 || $pinfo->ac_time > $ac_time) //后面的AC不能覆盖前面的AC时间
                    $pinfo->ac_time = $ac_time;
                $accepts = 0;
                $penalty = 0;
                foreach ($info_json as $pif)
                {
                    if ($pif->ac_time > 0)
                    {
                        $accepts++;
                        $penalty += $pif->ac_time //AC题的时间
                                 +  count($pif->wrongs) * land_conf::PENALTY_FACTOR; //WA的罚时
                    }
                }
                $sql .= "`accepts`=$accepts, `penalty`=$penalty, ";
            }
            else
            {
                //如果没有AC, 那么就算进罚时
                if (!$pinfo->ac_time > 0)
                {
                    $pinfo->wrongs[] = $src_id;
                }
            }
            $info_json->$seq = $pinfo;
            $info_str = db_escape($conn, json_encode($info_json));
            $sql .= " `info_json`='$info_str' WHERE `user_id`=$user_id AND `contest_id`=$contest_id";
            $res = db_query($conn, $sql);
            if (false === $res)
            {
                FM_LOG_WARNING('update user_at_contest failed');
                break;
            }
            FM_LOG_TRACE('user_at_contest updated');
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
    //system("rm -rf " . escapeshellcmd($temp_dir));
    @system("rm -rf " . escapeshellcmd($temp_dir) . "/a.out");
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
