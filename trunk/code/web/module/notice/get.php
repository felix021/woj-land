<?php

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $notice = cache_util::load('notice');
        response::add_data('notice', $notice->notice);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("notice.tpl.php");
        return true;
    }
}

?>
