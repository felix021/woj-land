<?php

class Main extends cframe
{
    public function display()
    {
        FM_LOG_TRACE("Hi, I'm here!");
        //echo "hello, world!";
        response::add_data("hello", "world!");
        $this->set_my_tpl("hello.tpl.php");
        return true;
    }
}

?>
