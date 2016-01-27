<?php

require_once(MODULE_ROOT . '/problem/problem.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        if (!isset(request::$arr_get['problem_id']))
            throw new Exception('');
        $problem_id = (int)request::$arr_get['problem_id'];
        $problem = get_problem_by_id($problem_id);
        response::add_data('problem', $problem);

        response::add_data('contests', load_all_contests());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("edit.tpl.php");
        return true;
    }
}

?>
