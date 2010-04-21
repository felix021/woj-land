<?php

require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        response::add_data('contests', load_unfinished_contests());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("add.tpl.php");
        return true;
    }
}

?>
