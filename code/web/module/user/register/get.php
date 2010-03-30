<?php

class Main extends cframe
{
    protected $need_login = false;
    protected $need_info  = false;

    public function process()
    {
        response::add_data('lang', land_conf::$lang);
        return true;
    }
    public function display()
    {
        $this->set_my_tpl("register.tpl.php");
        return true;
    }
}

?>
