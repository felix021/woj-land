<?php

require_once("itemplate.lib.php");

class ctemplate implements itemplate
{
    public $arr_tpl = array();

    public function display($p)
    {
        var_dump($p);
        return true;
    }
}

?>
