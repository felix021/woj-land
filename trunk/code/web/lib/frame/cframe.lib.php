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

    public function set_my_tpl($filename)
    {
        $debug = debug_backtrace();
        //FM_LOG_DEBUG("%s", print_r($debug, true));
        $tpl = dirname($debug[0]['file']) . "/" . $filename;
        response::set_tpl($tpl);
    }
}

?>
