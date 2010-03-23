<?php

class Main extends cframe
{
    public function process()
    {
        $conn = db_connect();
        fail_test($conn);

        $username = preg_replace("/(^ *| *$)/", "", request::$arr_post['username']);
        $username = db_escape($conn, $username);
        $sql = <<<eot
SELECT `user_id`, `password`
  FROM `users` WHERE `username`='$username'
eot;
        $line = db_fetch_line($conn, $sql);
        if (false == $line)
        {
            FM_LOG_WARNING('user not exist');
            $msg = 'User ' . request::$arr_post['username'] . ' does not exists';
            throw new Exception($msg);
        }

        FM_LOG_DEBUG('post: %s', print_r(request::$arr_post, true));
        $pass_seed = $line['password'] . request::$arr_post['seed'];
        $passEnc   = md5($pass_seed);
        FM_LOG_DEBUG("md5(%s) = %s", $pass_seed, $passEnc);
        if ($passEnc !== request::$arr_post['passEnc'])
        {
            FM_LOG_DEBUG("post: %s, %s\ndb: %s, %s",
                request::$arr_post['passEnc'], request::$arr_post['seed'],
                $passEnc, $line['password']);
            FM_LOG_WARNING('bad password');
            throw new Exception('Bad password!');
        }

        $user_id = $line['user_id'];
        session::set_login($user_id);
        
        return true;
    }

    public function display()
    {
        $url = request::$arr_post['origURL'];
        if (!preg_match("/\/user\/(login|logout)/", $url))
        {
            response::set_redirect($url);
        }

        response::add_data('links', array(
            'Back'      => 'javascript:history.back(1)',
            'Problems'  => land_conf::$web_root . '/problem/list',
            ));
        response::display_msg("Hey, you've logged in succeesfully~");
        return true;
    }
}

?>
