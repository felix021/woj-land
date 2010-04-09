<?php

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("admin.tpl.php");
        return true;
    }
}

?>
