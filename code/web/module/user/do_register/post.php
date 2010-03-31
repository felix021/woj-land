<?php

class Main extends cframe
{

    protected $need_login = false;
    protected $need_info  = false;

    public function process()
    {
        $conn = db_connect();
        fail_test($conn, false);

        //check username
        $username = preg_replace("/^ *| *$/", "", request::$arr_post['username']);
        if (empty($username))
        {
            FM_LOG_WARNING("empty username");
            throw new Exception("Username should not be empty");
        }
        if (strlen($username) > 20)
        {
            FM_LOG_WARNINIG("user name too long: %s", $username);
            throw new Exception("Username should be less than 20 characters");
        }

        //check if used
        $username = db_escape($conn, $username);
        $count = db_count($conn,
            "SELECT COUNT(*) FROM `users` WHERE `username`='$username'");
        if ($count != 0)
        {
            db_close($conn);
            FM_LOG_WARNING("username has been used, count: %s", $count);
            throw new Exception("Username has been used ~.~");
        }

        foreach (request::$arr_post as $key => &$v)
        {
            $v = db_escape($conn, $v);
        }
        //FM_LOG_DEBUG("post: %s", print_r(request::$arr_post, true));
        extract(request::$arr_post, EXTR_PREFIX_ALL, "REG");
        $REG_time = date("Y-m-d H:i:s");
        $REG_ip   = request::$client_ip;
        $REG_share_code = isset(request::$arr_post['share_code']) ? 1 : 0;
        $sql = <<<eot
INSERT INTO `users` 
(`user_id`, `username`, `password`, `nickname`, `email`, `school`, `reg_time`, `last_ip`, `submit`, `solved`, `enabled`, `preferred_lang`, `share_code`, `group_ids`, `solved_list`) 
VALUES
(NULL, '$REG_username', '$REG_passEnc', '$REG_nick', '$REG_email',
'$REG_school', '$REG_time', '$REG_ip', 0, 0, 1, $REG_lang, $REG_share_code, "", "");
eot;

        $user_id = db_insert($conn, $sql);

        db_close($conn);

        session::set_login($user_id);
        return true;
    }

    public function display()
    {
        response::add_data('links',
            array(
                'Problems'  => land_conf::$web_root . "/problem/volume",
                'FAQ'       => land_conf::$web_root . "/faq.html",
                )
            );
        response::display_msg('Hey, ' . request::$arr_post['username'] 
            . ', you\'ve just registered an account in Land. Now enjoy it!');
    }
}

?>
