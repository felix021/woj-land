<?php

require_once(MODULE_ROOT . '/problem/problem.func.php');

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $search = request::$arr_post['key'];
        if (empty($search))
        {
            throw new Exception("Please provide the search field.");
        }
        $sql = <<<eot
SELECT `problem_id`, `contest_id`, `title`, `submitted`, `accepted`
  FROM `problems`
  WHERE `title` LIKE '%$search%'
eot;
        if (!is_admin())
        {
            $sql .= ' AND `enabled`=1';
        }
        $conn = db_connect();
        fail_test($conn, false);
        $problems = db_fetch_lines($conn, $sql, -1);
        db_close($conn);
        foreach ($problems as &$p)
        {
            $ac = $p['accepted'];
            $st = $p['submitted'];
            if ($st == 0)
            {
                $p['ratio'] = 0;
            }
            else
            {
                $p['ratio'] = round($ac * 100 / $st, 2);
            }
        }
        if (!is_admin())
            $problems = filter_contest_problem($problems);
        response::add_data('problems', $problems);
        response::add_data('volume', 'Found');
        $solved_list = session::$is_login ? session::$user_info['solved_list'] : '';
        response::add_data('solved', $solved_list);

        return true;
    }

    public function display()
    {
        //$this->set_my_tpl("list.tpl.php");
        response::set_tpl(MODULE_ROOT . '/problem/list/list.tpl.php');
        return true;
    }
}

?>
