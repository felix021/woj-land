<?php

require_once(MODULE_ROOT . '/problem/problem.func.php');
require_once(MODULE_ROOT . '/contest/contest.func.php');

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

        $seq_char = '';
        if ($problem['contest_id'] > 0)
        {
            $contest = get_contest_by_id($problem['contest_id']);
            if (false === check_visibility($problem, $contest))
            {
                throw new Exception('This problem is currently unavailable.');
            }
            $status = contest_status($contest['start_time'], $contest['end_time']);
            if ($status == land_conf::CONTEST_RUNNING)
                $seq_char = seq_to_char($problem['contest_seq']);
        }
        response::add_data('seq_char', $seq_char);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("detail.tpl.php");
        return true;
    }
}

?>
