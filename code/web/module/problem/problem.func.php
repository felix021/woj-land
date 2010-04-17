<?php

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
?>
