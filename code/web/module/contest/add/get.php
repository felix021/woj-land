<?php

require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        response::add_data('start_time', date('Y-m-d H:00:00', time() + 3600));
        response::add_data('end_time', date('Y-m-d H:00:00', time() + 3600 * 6));
        response::add_data('seed', session::gen_vcode());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("add.tpl.php");
        return true;
    }
}

?>
