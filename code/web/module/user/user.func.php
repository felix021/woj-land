<?php

function get_user_by_user_id(&$conn, $user_id)
{
    $sql = 'SELECT * FROM `users` WHERE `user_id`=' . (int)$user_id;

    $conn = db_connect();
    fail_test($conn, false);

    $user = db_fetch_line($conn, $sql);

    return $user;
}

function get_user_by_username(&$conn, $username)
{

    $conn = db_connect();
    fail_test($conn, false);

    $sql = "SELECT * FROM `users` WHERE `username`='" . db_escape($conn, $username) . "'";

    $user = db_fetch_line($conn, $sql);

    return $user;
}

?>
