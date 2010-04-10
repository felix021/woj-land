<?php

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $tbl_name = 'sources';
        $admin = false;
        if (isset(request::$arr_post['admin']))
        {
            if (!is_admin())
            {
                throw new Exception("You don't have permission to submit as an administrator.");
            }
            $tbl_name = 'admin_sources';
            $admin = true;
        }

        $problem_id = (int)request::$arr_post['problem_id'];
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

        $length = strlen($source);
        $source = db_escape($conn, $source);
        $username = db_escape($conn, $username);
        $submit_time = date("Y-m-d H:i:s");
        $submit_ip   = request::$client_ip;
        //TODO contest_id
        $sql = <<<eot
INSERT INTO `{$tbl_name}` 
(`problem_id`, `user_id`, `username`, `contest_id`, `source_code`,
 `submit_time`, `submit_ip`, `lang`, `share`, `length`)
VALUES
($problem_id, $user_id, '$username', 0, '$source', '$submit_time', '$submit_ip', $language, $share_code, $length)
eot;

        $source_id = db_insert($conn, $sql);

        if ($admin)
            $source_id = -$source_id;

        //notify deamon
        notify_daemon_java($source_id);

        $url = land_conf::$web_root . '/status' . ($admin ? '?admin' : '');
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
