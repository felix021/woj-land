<?php

class Main extends cframe
{
    public function process()
    {
        $problem_id = (int)request::$arr_post['problem_id'];
        $language   = (int)request::$arr_post['lang'];
        $source     = request::$arr_post['source'];
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
        $submit_ip   = $_SERVER['REMOTE_ADDR'];
        //TODO contest_id
        $sql = <<<eot
INSERT INTO `sources` 
(`problem_id`, `user_id`, `username`, `contest_id`, `source_code`,
 `submit_time`, `submit_ip`, `lang`, `share`, `length`)
VALUES
($problem_id, $user_id, '$username', 0, '$source', '$submit_time', '$submit_ip', $language, $share_code, $length)
eot;

        $source_id = db_insert($conn, $sql);

        //notify deamon
        notify_daemon_java($source_id);
        return true;
    }

    public function display()
    {
        $url = land_conf::$web_root . '/status';
        response::add_data('return_url', $url);
        response::add_data('links', array(
            'Status'    => $url,
            )
        );
        response::display_msg("Source code successfully submitted!");
        return true;
    }
}

?>
