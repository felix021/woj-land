<?php

class Main extends cframe
{
    public function display()
    {
        response::set_tpl("register.tpl.php");
        return true;
    }
}

?>
