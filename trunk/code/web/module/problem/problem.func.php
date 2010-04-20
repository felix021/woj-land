<?php

require_once(MODULE_ROOT . '/contest/contest.func.php');

function get_problem_by_id($problem_id)
{
    $conn = db_connect();
    fail_test($conn, false);
    $sql = "SELECT * FROM `problems` WHERE `problem_id`=$problem_id";
    $problem    = db_fetch_line($conn, $sql);
    db_close($conn);
    if ($problem == false)
    {
        FM_LOG_WARNING("request a not-exist problem");
        throw new Exception("This problem does not exist in Land. Maybe it's still on noah's ark?");
    }
    return $problem;
}

function check_visibility($problem, $contest)
{
    if ($problem['contest_id'] == 0)
        return true;

    $status = contest_status($contest['start_time'], $contest['end_time']);
    switch ($status)
    {
        case land_conf::CONTEST_PENDING:
            if (!is_admin())
            {
                FM_LOG_WARNING('unauthorized access to problem of pending contest');
                return false;
            }
            return true;

        case land_conf::CONTEST_RUNNING:
            if ($contest['private'] && !is_admin() && !has_private_privilege())
            {
                FM_LOG_WARNING('unauthorized access to problem of running private contest');
                return false;
            }
            return true;

        case land_conf::CONTEST_FINISHED:
            return true;

        default:
            FM_LOG_WARNING('Problem or Contest data error');
            throw new Exception('Problem or Contest data error.');
            break;
    }
    return false;
}

function add_problem_at_contest($conn, $pid, $cid)
{
    $pid = (int)$pid;
    $cid = (int)$cid;
    if ($pid <= 0) return;
    if ($cid <= 0) return;

    $sql = <<<eot
INSERT INTO `problem_at_contest`
(`problem_id`, `contest_id`) VALUES ($pid, $cid);
eot;

    $res = db_query($conn, $sql);
    fail_test($res, false);

    return;
}

function remove_problem_at_contest($conn, $pid, $cid)
{
    $pid = (int)$pid;
    $cid = (int)$cid;
    if ($pid <= 0) return;
    if ($cid <= 0) return;

    $sql = <<<eot
DELETE FROM `problem_at_contest` WHERE `problem_id`=$pid AND `contest_id`=$cid;
eot;

    $res = db_query($conn, $sql);
    //fail_test($res, false);

    return;
}

function filter_contest_problem($problems)
{
    $arr_cid = array();
    foreach ($problems as $problem)
    {
        if ($problem['contest_id'] > 0)
        {
            $arr_cid[] = $problem['contest_id'];
        }
    }

    if (count($arr_cid) == 0)
        return $problems;

    $cids = join(', ', $arr_cid);
    $sql = <<<eot
SELECT `contest_id`, `start_time`, `end_time`
    FROM `contests`
    WHERE `contest_id` IN ($cids);
eot;

    $conn = db_connect();
    fail_test($conn, false);

    $lines = db_fetch_lines($conn, $sql, -1);
    fail_test($lines, false);
    
    db_close($conn);

    $contests = array();
    foreach ($lines as $line)
    {
        $contests[$line['contest_id']] = contest_status($line['start_time'], $line['end_time']);
    }

    $arr_pro = array();
    foreach ($problems as $problem)
    {
        $cid = $problem['contest_id'];
        //非比赛，或者比赛已经结束
        if ($cid <= 0 || $contests[$cid] != land_conf::CONTEST_PENDING)
        {
            $arr_pro[] = $problem;
        }
    }
    return $arr_pro;
}
?>
