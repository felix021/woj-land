<?php

require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        if (!isset(request::$arr_get['contest_id']))
            throw new Exception('');
        $contest_id = (int)request::$arr_get['contest_id'];
        $contest = get_contest_by_id($contest_id);
        response::add_data('contest', $contest);
        response::add_data('seed', session::gen_vcode());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("edit.tpl.php");
        return true;
    }
}

?>
