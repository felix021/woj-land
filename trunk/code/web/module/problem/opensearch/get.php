<?php

require_once(MODULE_ROOT . '/problem/problem.func.php');

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        return true;
    }

    public function display()
    {
        response::add_header("Content-Type: application/xml");
        $this->set_my_tpl("opensearch.tpl.php");
        return true;
    }
}

?>
