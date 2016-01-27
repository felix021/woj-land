<?php

class Main extends cframe
{
    public function process()
    {
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("format.tpl.php");
        return true;
    }
}

?>
