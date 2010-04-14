<?php

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        response::add_data('time', time());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("time.tpl.php");
        return true;
    }
}

?>
