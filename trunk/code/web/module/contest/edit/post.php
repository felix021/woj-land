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
        $cid = (int)force_read($p, 'contest_id');
        if ($cid < 1)
            throw new Exception('Bad contest_id provided.');

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
UPDATE `contests` SET
  `title`='{$p['title']}',
  `description`='{$p['description']}',
  `private`='{$pri}',
  `start_time`='{$p['start_time']}',
  `end_time`='{$p['end_time']}'
WHERE `contest_id`=$cid;
eot;

        $res = db_query($conn, $sql);
        fail_test($res, false);

        response::add_link('View This contest', land_conf::$web_root . '/contest/detail?contest_id=' .$cid);
        response::display_msg('contest information updated.');
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
