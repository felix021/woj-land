<?php

require_once(MODULE_ROOT . '/problem/problem_contest_info.class.php');
require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $cid = (int)request::$arr_get['contest_id'];
        if ($cid < 1)
        {
            FM_LOG_WARNING("BAD contest_id");
            throw new Exception('');
        }
        response::add_data('contest_id', $cid);

        $sql = <<<eot
SELECT * FROM `problem_at_contest` 
    WHERE `contest_id`=$cid
    ORDER BY `contest_seq` ASC
eot;

        $conn = db_connect();
        fail_test($conn, false);

        $arr_statis = db_fetch_lines($conn, $sql, -1);
        fail_test($arr_statis, false);

        db_close($conn);

        response::add_data('arr_statis', $arr_statis);
        response::add_data('title', force_read(request::$arr_get, 'title'));
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("statis.tpl.php");
        return true;
    }
}

?>
