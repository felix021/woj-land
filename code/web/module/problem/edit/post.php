<?php

require_once(MODULE_ROOT . '/problem/problem.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $conn = db_connect();
        fail_test($conn, false);

        $p= request::$arr_post;
        foreach ($p as &$v) 
        {
            $v = db_escape($conn, $v);
        }
        $pid = (int)$p['problem_id'];
        $time_limit = (int)$p['time_limit'];
        $memory_limit = (int)$p['memory_limit'];
        $contest_id = (int)$p['contest_id'];
        $spj = (isset($p['spj']) && $p['spj'] == 1) ? 1 : 0;

        $sql = <<<eot
UPDATE `problems` SET
  `title`='{$p['title']}',
  `description`='{$p['description']}',
  `time_limit`={$time_limit},
  `memory_limit`={$memory_limit},
  `input`='{$p['input']}',
  `output`='{$p['output']}',
  `sample_input`='{$p['sample_input']}',
  `sample_output`='{$p['sample_output']}',
  `hint`='{$p['hint']}',
  `source`='{$p['source']}',
  `contest_id`={$contest_id},
  `spj`={$spj}
WHERE `problem_id`=$pid;
eot;

        $res = db_query($conn, $sql);
        fail_test($res, false);

        response::add_link('View This Problem', land_conf::$web_root . '/problem/detail?problem_id=' .$pid);
        response::display_msg('Problem information updated.');
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
