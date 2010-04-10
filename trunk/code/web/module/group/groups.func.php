<?php


function load_all_groups()
{
    $conn = db_connect();
    fail_test($conn, false);

    $groups = db_fetch_lines($conn, 'SELECT * FROM `groups`', -1);
    fail_test($groups, false);

    db_close($conn);

    return $groups;
}

?>
