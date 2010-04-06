<?php

class Main extends cframe
{

    protected $need_session = true;
    protected $need_info    = true;
    protected $need_login   = true;

    public function process()
    {
        FM_LOG_TRAC('');
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("hello.tpl.php");
        return true;
    }
}

?>
