<?php

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        date();
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("hello.tpl.php");
        return true;
    }
}

?>
