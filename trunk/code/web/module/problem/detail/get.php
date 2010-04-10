<?php

require_once(MODULE_ROOT . '/problem/problem.func.php');

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $problem_id = (int)request::$arr_get['problem_id'];
        $problem = get_problem_by_id($problem_id);
        if (!is_admin() && !$problem['enabled'])
        {
            throw new Exception("This problem is currently unavailable :(");
        }
        response::add_data('problem', $problem);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("detail.tpl.php");
        return true;
    }
}

?>
