<?php

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        response::set_redirect('detail?user_id=' . session::$user_id);
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
