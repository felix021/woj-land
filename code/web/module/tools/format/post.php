<?php

class Main extends cframe
{
    public function process()
    {
        require_once(MODULE_ROOT . '/source/source.inc.php');
        $source = format_code(request::$arr_post['source']);
        response::add_data('source', $source);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("format.tpl.php");
        return true;
    }
}

?>
