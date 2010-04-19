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
        $conn = db_connect();
        fail_test($conn, false);

        $sql = <<<eot
SELECT `problem_id`, `title`, `contest_seq` FROM `problems`
    WHERE `contest_id`=$contest_id
    ORDER BY `contest_seq` ASC
eot;

        $lines = db_fetch_lines($conn, $sql, -1);
        fail_test($lines);

        response::add_data('pid_seq', $lines);
        response::add_data('contest', $contest);
        response::add_data('seed', session::gen_vcode());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("seqedit.tpl.php");
        return true;
    }
}

?>
