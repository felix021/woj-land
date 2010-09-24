<?php

final class session
{
    const ANONYMOUS_ID       = 2;
    const ANONYMOUS_NAME     = 'anonymous';
    const DO_UPDATE          = true;

    public static $is_login  = false;
    public static $user_id   = self::ANONYMOUS_ID;
    public static $user_info = array();
    public static $priv      = null;
    public static $n_unread  = 0;

    //使session独立于其他应用，不互相干扰
    public static $sess_id   = null;

    public static function init($do_update = false)
    {
        self::$sess_id = land_conf::$web_root;
        if (isset($_SESSION[self::$sess_id]['is_login']))
        {
            self::$is_login  = true;
            self::$user_id   = $_SESSION[self::$sess_id]['user_id'];

            if ($do_update)
            {
                self::$user_info = self::get_user_info($do_update);
                self::$priv      = self::get_priv($do_update);
                self::$n_unread  = self::get_n_unread($do_update);
            }
            else
            {
                self::$user_info = $_SESSION[self::$sess_id]['user_info'];
                self::$priv      = $_SESSION[self::$sess_id]['priv'];
                self::$n_unread  = $_SESSION[self::$sess_id]['n_unread'];
            }

            logger::log_add_info("username:" . self::$user_info['username']);
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
            $_SESSION[self::$sess_id]['is_login']  = true;
            self::$is_login             = true;
            
            $_SESSION[self::$sess_id]['user_id']   = $user_id;
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
        $_SESSION[self::$sess_id]['vcode'] = $vcode;
        response::add_header('Pragma: no-cache');
        response::add_header('Cache-Control: no-cache, must-revalidate');
        response::add_header('Expires: 0');
        return $vcode;
    }

    public static function get_vcode()
    {
        $vcode = false;
        if (isset($_SESSION[self::$sess_id]['vcode']))
        {
            $vcode = $_SESSION[self::$sess_id]['vcode'];
            unset($_SESSION[self::$sess_id]['vcode']); //vcode只能用一次
        }
        return $vcode;
    }

    public static function get($k)
    {
        if (isset($user_info[$k]))
        {
            return $user_info[$k];
        }
        return null;
    }

    public static function set($k, $v)
    {
        self::$user_info[$k] = $v;
    }

    public static function get_user_info($do_update = false)
    {
        if (!self::$is_login)
        {
            FM_LOG_WARNING("User not login");
            return false;
        }

        $user_info = null;

        if ($do_update || !isset($_SESSION[self::$sess_id]['user_info']))
        {

            $conn = db_connect();
            fail_test($conn, false);

            $sql = "SELECT * FROM `users` WHERE `user_id`=" . self::$user_id; 
            $user_info  = db_fetch_line($conn, $sql);
            db_close($conn);

            fail_test($user_info, false);
            $_SESSION[self::$sess_id]['user_info'] = $user_info;

        }
        else
        {
            $user_info = $_SESSION[self::$sess_id]['user_info'];
        }

        self::$user_info = $user_info;

        return $user_info;
    }

    public static function get_priv($do_update = false)
    {
        if (!self::$is_login)
        {
            FM_LOG_WARNING("User not login");
            return false;
        }

        $priv = null;

        if ($do_update || !isset($_SESSION[self::$sess_id]['priv']))
        {
            if (count(self::$user_info) == 0)
            {
                self::$user_info = self::get_user_info($do_update);
            }
            $priv =  get_privileges_by_groups(self::$user_info['group_ids']);
            $_SESSION[self::$sess_id]['priv'] = $priv;
        }
        else
        {
            $priv = $_SESSION[self::$sess_id]['priv'];
        }

        self::$priv = $priv;

        return $priv;
    }

    public static function get_n_unread($do_update = false)
    {
        if (!self::$is_login)
        {
            FM_LOG_WARNING("User not login");
            return false;
        }

        $n_unread = null;

        if ($do_update || !isset($_SESSION[self::$sess_id]['n_unread']))
        {
            $conn = db_connect();
            fail_test($conn, false);

            $n_unread = db_count($conn,
                'SELECT COUNT(*) FROM `mails` ' .
                '  WHERE `to_user_id`='.(int)self::$user_id.' AND `unread`=1'
            );
            fail_test($n_unread, false);
            db_close($conn);

            $_SESSION[self::$sess_id]['n_unread'] = $n_unread;
        }
        else
        {
            $n_unread = $_SESSION[self::$sess_id]['n_unread'];
        }

        self::$n_unread = $n_unread;

        return $n_unread;
    }

    public function read_mail()
    {
        $_SESSION[self::$sess_id]['n_unread']--;
        self::$n_unread = $_SESSION[self::$sess_id]['n_unread'];
    }
}

?>
