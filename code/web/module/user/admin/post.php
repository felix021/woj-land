<?php

require_once(MODULE_ROOT . '/user/user.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $p = request::$arr_post;
        FM_LOG_TRACE('post: %s', print_r($p, true));
        $seed = session::get_vcode();
        if (false == $seed || $seed != $p['seed'])
        {
            FM_LOG_WARNING("Seed not set, or bad seed: session(%s), post(%s)", $seed, $p['seed']);
            throw new Exception('Seed not set, try again.');
        }

        $conn       = db_connect();
        fail_test($conn, false);

        $user_id  = (int)$p['user_id'];
        $nickname = db_escape($conn, request::$arr_post['nick']);
        $school   = db_escape($conn, request::$arr_post['school']);
        $email    = db_escape($conn, trim(request::$arr_post['email']));
        $share_code = (int)force_read(request::$arr_post, 'share_code');
        $group_ids  = request::$arr_post['group_ids'];
        $updatePass = '';
        if (!empty(request::$arr_post['passEnc']))
        {
            $newpass = db_escape($conn, request::$arr_post['passEnc']);
            $updatePass = "`password`='$newpass',";
        }

        $sql = <<<eot
UPDATE `users` SET
    $updatePass
    `nickname`  = '$nickname',
    `school`    = '$school',
    `email`     = '$email',
    `share_code`= $share_code,
    `group_ids` = '$group_ids'
WHERE `user_id`=$user_id
eot;
        $res = db_query($conn, $sql);
        fail_test($res, false);

        db_close($conn);

        response::add_link('Examine', land_conf::$web_root . '/user/detail?user_id=' . $user_id);
        response::add_link('Go Back', 'javascript:history.back(1);');
        response::display_msg("User information updated successfully");
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
