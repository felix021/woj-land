<?php

require_once("iframe.lib.php");

class cframe implements iframe
{
    public $errno;
    public $err_info;

    public function pre_process()
    {
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
}

?>
