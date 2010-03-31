<?php

class Main extends cframe
{
    protected $need_login = true;
    protected $need_info  = true;

    public function process()
    {
        response::add_data('user', session::$user_info);
        response::add_data('lang', land_conf::$lang);
        response::add_data('seed', session::gen_vcode());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("setting.tpl.php");
        return true;
    }
}

?>
