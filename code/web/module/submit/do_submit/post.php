<?php

require_once(MODULE_ROOT . '/problem/problem.func.php');
require_once(MODULE_ROOT . '/problem/problem_contest_info.class.php');
require_once(MODULE_ROOT . '/contest/contest.func.php');

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $tbl_name = 'sources';
        $is_admin = false;
        if (isset(request::$arr_post['admin']))
        {
            if (!is_admin())
            {
                throw new Exception("You don't have permission to submit as an administrator.");
            }
            $tbl_name = 'admin_sources';
            $is_admin = true;
        }

        $problem_id = (int)request::$arr_post['problem_id'];
        $problem = get_problem_by_id($problem_id);

        $status = land_conf::CONTEST_UNKNOWN;

        //如果是admin提交 则不计入contest
        $cid    = $is_admin ? 0 : $problem['contest_id'];

        $in_contest = false;
        //判断该题目是否处于比赛、该用户是否可以提交
        if ($cid != 0) //题目属于某个比赛
        {
            $contest = get_contest_by_id($problem['contest_id']);
            $status  = contest_status($contest['start_time'], $contest['end_time']);

            //比赛不允许匿名参加
            if ($status == land_conf::CONTEST_RUNNING && !session::$is_login)
            {
                throw new Exception('Anonymous user are not allowed to attend contests. Please login first.');
            }

            if ($status == land_conf::CONTEST_PENDING ||
                false == check_visibility($problem, $contest))
            {
                FM_LOG_WARNING('unauthorized access to pending contest, or private contest');
                //未开始，或者不允许参加的用户
                throw new Exception('This problem is currently unavailable.');
            }
        }

        if ($status == land_conf::CONTEST_FINISHED || $is_admin)
        {
            $cid = 0; //比赛结束了, 或是管理员的提交
        }
       
        if ($status == land_conf::CONTEST_RUNNING && !$is_admin)
        {
            $in_contest = true;
        }

        $language   = (int)request::$arr_post['lang'];
        $source     = request::$arr_post['source'];
        if (strlen($source) < land_conf::MIN_SOURCE_LEN)
        {
            throw new Exception("Your source code is too short..");
        }
        else if (strlen($source) > land_conf::MAX_SOURCE_LEN)
        {
            $k = round(land_conf::MAX_SOURCE_LEN / 1024, 0);
            throw new Exception("Your source code is too long (more than $k KB)..");
        }
        $share_code = isset(request::$arr_post['share_code']) ? 1 : 0;
        $user_id    = session::ANONYMOUS_ID;
        $username   = session::ANONYMOUS_NAME;
        if (session::$is_login)
        {
            $user_id  = session::$user_id;
            $username = session::$user_info['username'];
        }

        $conn = db_connect();
        fail_test($conn, false);

        //如果比赛进行中且是第一次提交该比赛，需要增加user_at_contest的一行
        $info_json = array();
        if (!$is_admin && $in_contest)
        {
            $info_json = array();
            $sql = <<<eot
SELECT `info_json` FROM `user_at_contest`
    WHERE `user_id`=$user_id AND `contest_id`=$cid
eot;
            $line = db_fetch_line($conn, $sql);
            if (false === $line)
            {
                //第一次提交
                $empty_arr_str = json_encode(array());
                $username = db_escape($conn, session::$user_info['username']);
                $sql = <<<eot
INSERT INTO `user_at_contest` 
(`user_id`, `username`, `contest_id`, `accepts`, `penalty`, `info_json`)
VALUES
($user_id, '$username', $cid, 0, 0, '$empty_arr_str')
eot;
                $res = db_query($conn, $sql);
                fail_test($res, false);
            }
            else
            {
                //第n次提交
                $info_json = json_decode($line['info_json']);
            }
            FM_LOG_TRACE('info_json: %s', dump_var($info_json));
            $seq = $problem['contest_seq'];
            $idx = pgi_get_idx_by_seq($info_json, $seq);
            $info_json[$idx]->submits++;
        }

        $res = db_query($conn, 'START TRANSACTION');
        fail_test($res, false);

        $in_trans = true;
        do
        {
            if (!$is_admin)
            {
                //更新users的submit次数
                $sql = <<<eot
UPDATE `users` SET `submit`=`submit`+1
    WHERE `user_id`=$user_id
eot;
                $res = db_query($conn, $sql);
                if (false == $res)
                {
                    FM_LOG_WARNING("error update users");
                    break;
                }

                //更新problems的submit次数
                $sql = <<<eot
UPDATE `problems` SET `submitted`=`submitted`+1
    WHERE `problem_id`=$problem_id
eot;
                $res = db_query($conn, $sql);
                if (false == $res)
                {
                    FM_LOG_WARNING("error update problems");
                    break;
                }
               
                //如果是在比赛过程中
                if ($in_contest)  
                {
                    //更新problem_at_contest的total submit次数
                    $sql = <<<eot
UPDATE `problem_at_contest` SET `total`=`total`+1
    WHERE `problem_id`=$problem_id AND `contest_id`=$cid
eot;
                    $res = db_query($conn, $sql);
                    if (false == $res)
                    {
                        FM_LOG_WARNING("error update problem_at_contest");
                        break;
                    }

                    //更新user_at_contest该题的submit次数
                    $info_str = db_escape($conn, json_encode($info_json));
                    $sql = <<<eot
UPDATE `user_at_contest` SET `info_json`='$info_str'
    WHERE `user_id`=$user_id AND `contest_id`=$cid
eot;
                    $res = db_query($conn, $sql);
                    if (false == $res)
                    {
                        FM_LOG_WARNING("error update user_at_contest");
                        break;
                    }
                } //End of In_Contest
            } //End of Not Admin

            $length = strlen($source);
            $source = db_escape($conn, $source);
            $username = db_escape($conn, $username);
            $submit_time = date("Y-m-d H:i:s");
            $submit_ip   = request::$client_ip;

            //更新sources/admin_sources表
            $sql = <<<eot
INSERT INTO `{$tbl_name}` 
(`problem_id`, `user_id`, `username`, `contest_id`, `source_code`,
 `submit_time`, `submit_ip`, `lang`, `share`, `length`)
VALUES
($problem_id, $user_id, '$username', $cid, '$source', '$submit_time', '$submit_ip', $language, $share_code, $length)
eot;

            $source_id = db_insert($conn, $sql);
            if (false === $source_id)
            {
                FM_LOG_WARNING('Error insert source_tbl');
                break;
            }

            $res = db_query($conn, 'COMMIT');
            fail_test($res, false);

            $in_trans = false;

            if ($is_admin)
                $source_id = -$source_id;

            //notify deamon
            notify_daemon_java($source_id);

        } while (false);

        if ($in_trans)
        {
            $res = db_query($conn, 'ROLLBACK');
            FM_LOG_WARNING('do submit failed');
            throw new Exception('');
        }

        $url = land_conf::$web_root . '/status?username=' . $username
             . ($is_admin ? '&admin=1' : '')
             . ($in_contest ? '&contest_id=' . $cid : '');
        response::add_data('return_url', $url);
        response::add_data('links', array(
            'Status'    => $url,
            )
        );
        response::display_msg("Source code successfully submitted!");
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
