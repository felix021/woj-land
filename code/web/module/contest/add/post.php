<?php

require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $conn = db_connect();
        fail_test($conn, false);

        $p= request::$arr_post;
        $seed = session::get_vcode();
        if (false == $seed || $seed != $p['seed'])
        {
            FM_LOG_WARNING("Seed not set, or bad seed: session(%s), post(%s)", $seed, $p['seed']);
            throw new Exception('Seed not set, try again.');
        }

        foreach ($p as &$v) 
        {
            $v = db_escape($conn, $v);
        }
        $pri = ($p['private'] == 1) ? 1 : 0;

        $start = time_check($p['start_time']);
        if (false === $start)
            throw new Exception ('start_time is in bad format.');

        $end = time_check($p['end_time']);
        if (false === $end)
            throw new Exception ('end_time is in bad format.');

        if ($start > $end)
        {
            throw new Exception('start_time should not be later than end_time.');
        }

        $sql = <<<eot
INSERT INTO `contests` 
 (`contest_id`, `title`, `description`, `private`, `start_time`, `end_time`)
VALUES
 (NULL, '{$p['title']}', '{$p['description']}', '{$pri}', '{$p['start_time']}', '{$p['end_time']}')
eot;

        $cid = db_insert($conn, $sql);
        fail_test($cid, false);

        response::add_link('View This contest', land_conf::$web_root . '/contest/detail?contest_id=' .$cid);
        response::display_msg('Contest information added.');
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
