<?php

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = false;

    public function process()
    {
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("faq.tpl.php");
        return true;
    }
}

?>
