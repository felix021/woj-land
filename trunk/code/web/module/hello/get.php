<?php

class Main extends cframe
{
    public function process()
    {
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("hello.tpl.php");
        return true;
    }
}

?>
