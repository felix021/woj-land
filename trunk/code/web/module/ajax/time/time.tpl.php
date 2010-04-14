<?php

class TPL_Main implements itemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        echo $p['time'];
        return true;
    }
}

?>
