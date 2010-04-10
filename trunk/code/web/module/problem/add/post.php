<?php

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        //TODO  contests info
        $p = request::$arr_post;
        response::add_data('problem', $p);

        $conn = db_connect();
        fail_test($conn, false);

        foreach ($p as &$v) 
            $v = db_escape($conn, $v);
        $cid = (int)$p['contest_id'];
        $tl  = (int)$p['time_limit'];
        $ml  = (int)$p['memory_limit'];
        $spj = isset($p['spj']) && $p['spj'] == 1 ? 1 : 0;
        $ena = isset($p['enable']) && $p['enable'] == 1 ? 1 : 0;

        $sql = <<<eot
INSERT INTO `problems` 
(`problem_id`, `title`, `description`, `input`, `output`, `sample_input`, `sample_output`,
 `hint`, `source`, `contest_id`, `time_limit`, `memory_limit`, `spj`, `enabled`)
VALUES
(NULL, '{$p['title']}', '{$p['description']}', '{$p['input']}', '{$p['output']}', 
 '{$p['sample_input']}', '{$p['sample_output']}', '{$p['hint']}', '{$p['source']}',
 $cid, $tl, $ml, $spj, $ena)
eot;

        $pid = db_insert($conn, $sql);
        fail_test($pid, false);

        db_close($conn);

        response::add_link('View This Problem', land_conf::$web_root . '/problem/detail?problem_id=' .$pid);
        response::display_msg('Problem information added.');

        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
