<?php

require_once("iframe.lib.php");

class cframe implements iframe
{
    public $errno;
    public $err_info;

    //默认需要session, 如不需要session，则覆盖为false
    protected $need_session = true;

    //默认不需要login, 如需要login，则覆盖为true
    protected $need_login   = false;

    public function pre_process()
    {
        if ($this->need_session)
        {
            session::init();
            if ($this->need_login && !session::$is_login)
            {
                FM_LOG_WARNING("User not login");
                $return_url = urlencode($_SERVER['REQUEST_URI']);
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $return_url = urlencode(force_read($_SERVER, 'HTTP_REFERER'));
                }
                response::set_redirect(land_conf::$web_root . "/user/login?need_login&u=$return_url");
            }
        }
        return true;
    }

    public function process()
    {
        return true;
    }

    public function post_process()
    {
        return true;
    }

    public function display()
    {
        return true;
    }

    public function err_handler()
    {
        FM_LOG_WARNING("err_handler incompleted");
        return true;
    }

    public function set_my_tpl($filename)
    {
        $debug = debug_backtrace();
        //FM_LOG_DEBUG("%s", print_r($debug, true));
        $tpl = dirname($debug[0]['file']) . "/" . $filename;
        response::set_tpl($tpl);
    }
}

class acframe extends cframe
{
    protected $need_admin = true;

    public function pre_process()
    {
        if (false === parent::pre_process())
        {
            return false;
        }

        if (!is_admin())
        {
            throw new Exception("You don't have permission to access this page :(");
        }

        return true;
    }
}

?>
