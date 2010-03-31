<?php

final class session
{
    const ANONYMOUS_ID      = 2;
    const ANONYMOUS_NAME    = 'anonymous';

    public static $is_login = false;
    public static $user_id  = self::ANONYMOUS_ID;
    public static $user_info = array();

    public static function init($need_info)
    {
        if (isset($_SESSION['land_is_login']))
        {
            self::$is_login = true;
            self::$user_id  = $_SESSION['land_user_id'];
            if ($need_info)
            {
                $conn = db_connect();
                fail_test($conn, false);

                $sql = "SELECT * FROM `users` WHERE `user_id`=" . self::$user_id; 
                $user_info  = db_fetch_line($conn, $sql);
                db_close($conn);
                fail_test($user_info, false);
                self::$user_info = $user_info;
                logger::log_add_info("username:" . self::$user_info['username']);
            }
        }
        else
        {
            self::$is_login = false;
        }

    }

    public static function set_login($user_id)
    {
        //匿名用户不允许登录
        if ($user_id != self::ANONYMOUS_ID)
        {
            $_SESSION['land_is_login']  = true;
            self::$is_login             = true;
            
            $_SESSION['land_user_id']   = $user_id;
            self::$user_id              = $user_id;
        }
        else
        {
            throw new Exception("User '".self::ANONYMOUS_NAME."' is not allowed to login.");
        }
    }

    public static function set_logout()
    {
        self::$is_login = false;
        self::$user_id  = self::ANONYMOUS_ID;
        session_destroy();
    }

    public static function gen_vcode($len = 6)
    {
        if ($len <= 0) $len = 6;
        $vcode = rndstr($len);
        $_SESSION['land_vcode'] = $vcode;
        return $vcode;
    }

    public static function get_vcode()
    {
        $vcode = false;
        if (isset($_SESSION['land_vcode']))
        {
            $vcode = $_SESSION['land_vcode'];
            unset($_SESSION['land_vcode']); //vcode只能用一次
        }
        return $vcode;
    }
}

?>
