<?php

class Main extends cframe
{
    public function process()
    {
        response::add_data('vcode', session::gen_vcode());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("vcode.tpl.php");
        return true;
    }
}

?>
