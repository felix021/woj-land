<?php

class Main extends cframe
{
    protected $need_session = true;
    protected $need_login   = false;

    public function process()
    {
        response::add_data('priv', session::$priv);

        $diligent = cache_util::load('diligent');
        response::add_data_arr(array('diligent' => $diligent));

        return true;
    }

    public function display()
    {
        $this->set_my_tpl("index.tpl.php");
        return true;
    }
}

?>
