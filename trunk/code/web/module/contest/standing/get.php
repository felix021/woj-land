<?php

require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = false;

    public function process()
    {
        $cid = (int)request::$arr_get['contest_id'];
        response::add_data('cid', $cid);

        $page = 1;
        if (isset(request::$arr_get['page']))
        {
            $page = (int)request::$arr_get['page'];
            if ($page < 1) $page = 1;
        }
        $itpp  = land_conf::USERS_PER_PAGE;
        $start = ($page - 1) * $itpp;

        response::add_data('page', $page);
        response::add_data('rank', $start);

        $contest = get_contest_by_id($cid);
        check_pending($contest);

        $title = $contest['title'];
        response::add_data('title', $title);

        $conn  = db_connect();
        fail_test($conn, false);

        $sql = "SELECT `problem_id`, `contest_seq` FROM `problems` WHERE `contest_id`=$cid";
        $lines = db_fetch_lines($conn, $sql, -1);
        $arr_seq = array();
        foreach ($lines as $line) $arr_seq[$line['contest_seq']] = $line['problem_id'];
        ksort($arr_seq);
        fail_test($arr_seq, false);

        response::add_data('arr_seq', $arr_seq);

        $sql = <<<eot
SELECT `user_id`, `username`, `accepts`, `penalty`, `info_json` 
    FROM `user_at_contest`
    WHERE `contest_id`=$cid
    ORDER BY `accepts` DESC, `penalty` ASC
    LIMIT $start,$itpp
eot;
        $users = db_fetch_lines($conn, $sql, -1);
        fail_test($users, false);
        db_close($conn);

        foreach ($users as &$user)
        {
            $info_json = json_decode($user['info_json']);
            $arr_pinfo = array();
            foreach ($info_json as $pinfo)
            {
                $arr_pinfo[$pinfo->seq] = $pinfo;
            }
            $user['pinfo'] = $arr_pinfo;
            //$user['penalty'] = time_to_str($user['penalty']);
        }
        response::add_data('users', $users);

        return true;
    }

    public function display()
    {
        $this->set_my_tpl("standing.tpl.php");
        return true;
    }
}

?>
