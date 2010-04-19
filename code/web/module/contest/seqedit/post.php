<?php

require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $p      = request::$arr_post;
        if (!isset($p['contest_id']))
        {
            throw new Exception("No contest_id provided");
        }
        $cid  = (int)$p['contest_id'];

        $seed = session::get_vcode();
        if (false == $seed || $seed != $p['seed'])
        {
            FM_LOG_WARNING("Seed not set, or bad seed: session(%s), post(%s)", $seed, $p['seed']);
            throw new Exception('Seed not set, try again.');
        }

        $pids = request::$arr_post['pid'];
        $seqs = request::$arr_post['seq'];

        if (count($pids) != count($seqs))
        {
            FM_LOG_WARNING("bad post data");
            throw new Exception('');
        }

        $conn = db_connect();
        fail_test($conn, false);

        $res = db_query($conn, 'START TRANSACTION');
        fail_test($res, false);

        $in_trans = true;
        do
        {
            $lines = count($pids);
            $succ = true;
            for ($i = 0; $i < $lines; $i++)
            {
                $pid = (int)$pids[$i];
                $seq = char_to_seq($seqs[$i]);
                $sql = "UPDATE `problems` SET `contest_seq`=$seq WHERE `problem_id`=$pid";
                $res = db_query($conn, $sql);
                if ($res === false)
                {
                    FM_LOG_WARNING("update problems failed, pid: %d, seq: %d", $pid, $seq);
                    $succ = false;
                    break;
                }
                $sql = <<<eot
UPDATE `problem_at_contest` SET `contest_seq`=$seq 
    WHERE `problem_id`=$pid AND `contest_id`=$cid
eot;
                $res = db_query($conn, $sql);
                if ($res === false)
                {
                    FM_LOG_WARNING("update problem_at_contest failed, pid: %d, seq: %d",$pid, $seq);
                    $succ = false;
                    break;
                }
            }
            if ($succ === false) break;
            $in_trans = false;
        } while(false);

        if (!$in_trans)
        {
            $res = db_query($conn, 'COMMIT');
            if ($res === false)
            {
                db_query($conn, 'ROLLBACK');
                FM_LOG_WARNING("fuck, commit failed.");
                throw new Exception('');
            }
        }
        else
        {
            db_query($conn, 'ROLLBACK');
            throw new Exception('');
        }

        db_close($conn);

        response::display_msg('Problem sequence updated.');
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
