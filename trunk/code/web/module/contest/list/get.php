<?php

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = false;

    public function process()
    {
        $page = 1;
        if (isset(request::$arr_get['page']))
            $page = (int) request::$arr_get['page'];
        $page = $page < 1 ? 1 : $page;

        $itpp  = land_conf::CONTESTS_PER_PAGE;
        $start = ($page - 1) * $itpp;

        $conn = db_connect();
        fail_test($conn, false);

        $sql = <<<eot
SELECT * FROM `contests` 
    WHERE `enabled`=1
    ORDER BY `start_time` DESC, `end_time` DESC
    LIMIT $start,$itpp
eot;
        $contests = db_fetch_lines($conn, $sql, -1);
        fail_test($contests, false);

        db_close($conn);

        response::add_data('page', $page);
        response::add_data('contests', $contests);

        return true;
    }

    public function display()
    {
        $this->set_my_tpl("list.tpl.php");
        return true;
    }
}

?>
