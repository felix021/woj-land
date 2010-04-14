<?php

require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = false;

    public function process()
    {
        if (!isset(request::$arr_get['contest_id']))
            throw new Exception('');
        $contest_id = (int)request::$arr_get['contest_id'];
        $contest = get_contest_by_id($contest_id);

        $ended = (time() > strtotime($contest['end_time']));
        //没结束的private比赛，只有 “管理员” 和 “有private权限的” 才能访问
        if ($contest['private'] && !$ended && !is_admin() && !has_private_privilege())
        {
            throw new Exception("This is a private contest, please try another one :)");
        }

        response::add_data('contest', $contest);

        $conn = db_connect();
        fail_test($conn, false);

        $sql = <<<eot
SELECT `problem_id`, `title`, `contest_seq` 
    FROM `problems`
    WHERE `contest_id`=$contest_id AND enabled=1
    ORDER BY `contest_seq` ASC
eot;
        $problems = db_fetch_lines($conn, $sql, -1);
        fail_test($problems, false);

        db_close($conn);

        foreach ($problems as &$p)
            $p['char'] = seq_to_char($p['contest_seq']);

        response::add_data('problems', $problems);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("detail.tpl.php");
        return true;
    }
}

?>
