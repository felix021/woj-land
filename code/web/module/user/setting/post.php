<?php

class Main extends cframe
{
    public function process()
    {
        if (!session::$is_login)
        {
            response::add_link('Login', land_conf::$web_root . '/user/login');
            throw new Exception("Please login first ~.~");
        }

        $user_id    = (int)session::$user_id;
        $sql        = 'SELECT `password` FROM `users` WHERE `user_id`=' . $user_id;
        $conn       = db_connect();
        fail_test($conn, false);
        $user       = db_fetch_line($conn, $sql);
        fail_test($user, false);

        $pass_seed  = request::$arr_post['seed'];
        $passEnc    = request::$arr_post['passEnc'];

        if ($passEnc != md5($user['password'] . $pass_seed))
        {
            FM_LOG_WARNING("bad password");
            throw new Exception("Please input the right password!");
        }

        $nickname = db_escape($conn, request::$arr_post['nick']);
        $school   = db_escape($conn, request::$arr_post['school']);
        $email    = db_escape($conn, trim(request::$arr_post['email']));
        $lang     = (int)request::$arr_post['lang'];
        $share_code = (int)request::$arr_post['share_code'];
        $updatePass = '';
        if (!empty(request::$arr_post['new_passEnc']))
        {
            $newpass = db_escape($conn, request::$arr_post['new_passEnc']);
            $updatePass = "`password`='$newpass',";
        }

        $sql = <<<eot
UPDATE `users` SET
    $updatePass
    `nickname`  = '$nickname',
    `school`    = '$school',
    `email`     = '$email',
    `preferred_lang` = $lang,
    `share_code`= $share_code
WHERE `user_id`=$user_id
eot;
        $res = db_query($conn, $sql);
        fail_test($res, false);

        response::add_link('Examine', land_conf::$web_root . '/user/detail?user_id=' . $user_id);
        response::add_link('Go Back', 'javascript:history.back(1);');
        response::display_msg("You've successfully updated your information :)");
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
