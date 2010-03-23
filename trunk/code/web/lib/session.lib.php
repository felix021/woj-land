<?php

final class session
{
    const ANONYMOUS_ID      = 2;

    public static $is_login = false;
    public static $user_id  = self::ANONYMOUS_ID;
    public static $user_info = array();

    public static function init()
    {
        if (isset($_SESSION['is_login']))
        {
            self::$is_login = true;
            self::$user_id  = $_SESSION['user_id'];
        }
        else
        {
            self::$is_login = false;
        }
        $conn = db_connect();
        fail_test($conn, false);

        $sql = "SELECT * FROM `users` WHERE `user_id`=" . self::$user_id; 
        $user_info  = db_fetch_line($conn, $sql);
        fail_test($user_info, false);
        self::$user_info = $user_info;
        logger::log_add_info("username:" . self::$user_info['username']);
    }

    public static function set_login($user_id)
    {
        $_SESSION['is_login'] = true;
        self::$is_login       = true;
        
        $_SESSION['user_id']  = $user_id;
        self::$user_id        = $user_id;
    }

    public static function set_logout()
    {
        self::$is_login = false;
        self::$user_id  = self::ANONYMOUS_ID;
        session_destroy();
    }
}

?>
