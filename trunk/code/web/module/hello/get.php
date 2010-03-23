<?php

class Main extends cframe
{
    public function process()
    {
        return true;
    }

    public function display()
    {
        FM_LOG_TRACE("Hi, I'm here!");
        response::add_data("hello", "world!");
        $this->set_my_tpl("hello.tpl.php");
        return true;
    }
}

?>
