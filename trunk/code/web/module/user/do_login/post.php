<?php

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        //先验证session中的seed
        $seed = session::get_vcode();
        if (false === $seed)
        {
            FM_LOG_WARNING("no seed set in session, suspicious attacker(or stayed too long in login page)");
            response::add_link('Login', land_conf::$web_root . '/user/login');
            throw new Exception('Error encountered, please try to login again');
        }
        else if ($seed != request::$arr_post['seed'])
        {
            FM_LOG_WARNING("bad seed, suspicious attacker");
            response::add_link('Login', land_conf::$web_root . '/user/login');
            throw new Exception('Error encountered, please try to login again');
        }

        $conn = db_connect();
        fail_test($conn);

        $username = preg_replace("/(^ *| *$)/", "", request::$arr_post['username']);
        $username = db_escape($conn, $username);
        $sql = <<<eot
SELECT `user_id`, `password`
  FROM `users` WHERE `username`='$username' AND `enabled`=1
eot;
        $line = db_fetch_line($conn, $sql);
        db_close($conn);
        if (false == $line)
        {
            FM_LOG_WARNING('user not exist');
            $msg = 'User ' . request::$arr_post['username'] . ' does not exists';
            throw new Exception($msg);
        }

        $pass_seed = $line['password'] . $seed;
        $passEnc   = md5($pass_seed);
        if ($passEnc !== request::$arr_post['passEnc'])
        {
            FM_LOG_WARNING('bad password');
            throw new Exception('Bad password!');
        }

        $user_id = $line['user_id'];

        session::set_login($user_id);
        session::init(session::DO_UPDATE);
        
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
            'Problems'  => land_conf::$web_root . '/problem/volume',
            'Contests'  => land_conf::$web_root . '/contest/list',
            ));
        response::display_msg("The Flood has gone, welcome back to Land again!");
        return true;
    }
}

?>
