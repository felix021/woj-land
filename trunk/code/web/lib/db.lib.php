<?php

function db_connect()
{
    require_once(CONF_ROOT . "/db.cfg.php");
    $conn = new mysqli(db_conf::DBHOST,
        db_conf::DBUSER, db_conf::DBPASS, db_conf::DBNAME);
    if (false === $conn)
    {
        FM_LOG_WARNING2("mysql connect err: %s", mysqli_connect_error());
        return false;
    }
    db_query($conn, "SET NAMES utf8");
    return $conn;
}

function db_query(&$conn, $sql)
{
    FM_LOG_DEBUG("%s\n--SQL--", $sql);
    $result = $conn->query($sql);
    if (false === $result)
    {
        FM_LOG_WARNING2("query failed, %d: %s", $conn->errno, $conn->error);
        return false;
    }
    return $result;
}

function db_close(&$conn)
{
    $conn->close();
    unset($conn);
}

function db_count(&$conn, $sql)
{
    $result = db_query($conn, $sql);
    fail_test($result, false);
    $row = $result->fetch_array();
    $result->free();
    fail_test($row, false);
    return $row[0];
}

function db_insert(&$conn, $sql)
{
    $result = db_query($conn, $sql);
    fail_test($result, false);
    return $conn->insert_id;
}

function db_fetch_lines($conn, $sql, $count = 1)
{
    $result = db_query($conn, $sql);
    fail_test($result, false);
    $lines = array();
    $i = 0;
    while ($i < $count && ($row = $result->fetch_assoc()))
    {
        $lines[$i++] = $row;
    }
    $result->free();
    return $lines;
}

function db_fetch_line($conn, $sql)
{
    $lines = db_fetch_lines($conn, $sql, 1);
    return isset($lines[0]) ? $lines[0] : false;
}

function db_escape($conn, $str)
{
    return $conn->real_escape_string($str);
}
?>
