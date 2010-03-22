<?php

require_once("itemplate.lib.php");

class ctemplate implements itemplate
{
    public $arr_tpl = array();
    public $web_root;

    public function __construct()
    {
        $this->web_root = land_conf::$web_root;
        ctemplate_run::run(TPL_ROOT . "/header.php", "header");
    }

    public function display($p)
    {
        var_dump($p);
        return true;
    }

    public function __destruct()
    {
        ctemplate_run::run(TPL_ROOT . "/footer.php", "footer");
    }
}

?>
