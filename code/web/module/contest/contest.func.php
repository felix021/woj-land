<?php

function get_contest_by_id($contest_id)
{
    $conn = db_connect();
    fail_test($conn, false);
    $sql = "SELECT * FROM `contests` WHERE `contest_id`=$contest_id";
    $contest    = db_fetch_line($conn, $sql);
    db_close($conn);
    if ($contest == false)
    {
        FM_LOG_WARNING("request a not-exist contest");
        throw new Exception("This contest does not exist in Land. Maybe it's still on noah's ark?");
    }
    return $contest;
}

function seq_to_char($seq)
{
    return chr(ord('A') + $seq - 1);
}

function char_to_seq($char)
{
    $c = strtoupper($char{0});
    return (ord($c) - ord('A') + 1);
}

//echo seq_to_char(3), char_to_seq('B');
?>
