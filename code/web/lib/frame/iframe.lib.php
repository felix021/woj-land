<?php

interface iframe
{
    public function pre_process();
    public function process();
    public function post_process();
    public function display();
    public function err_handler();
}

class Exception_frame extends Exception
{
}

?>
