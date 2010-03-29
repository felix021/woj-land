<?php

class Main extends cframe
{
    public function process()
    {
        if (!session::$is_login)
        {
            response::add_link('Login', land_conf::$web_root . '/user/login');
            throw new Exception("Please login first ~.~");
        }
        response::add_data('user', session::$user_info);
        response::add_data('lang', land_conf::$lang);
        response::add_data('seed', rndstr(6));
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("setting.tpl.php");
        return true;
    }
}

?>
