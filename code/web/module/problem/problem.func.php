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

?>
