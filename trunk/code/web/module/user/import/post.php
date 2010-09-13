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

        $arr_user = explode("\n", $_POST['userdata']);
        $arr_err  = array();
        $reg_time = date("Y-m-d H:i:s");
        foreach ($arr_user as $user) {
            $user = trim($user);
            if (empty($user))
                continue;
            $arr_data = explode('|', $user);
            foreach ($arr_data as &$data)
            {
                $data = db_escape($conn, trim($data));
            }
            $username = $arr_data[0];
            $password = md5($arr_data[1]);
            $nickname = '';
            $school   = '';
            $email    = '';

            if (isset($arr_data[2]))
                $nickname = $arr_data[2];
            if (isset($arr_data[3]))
                $school   = $arr_data[3];
            if (isset($arr_data[4]))
                $email    = $arr_data[4];

            $sql = <<<eot
INSERT INTO `users` 
(`user_id`, `username`, `password`, `nickname`, `school`, `email`, `reg_time`) VALUES
(NULL, '$username', '$password', '$nickname', '$school', '$email', '$reg_time');
eot;
            $res = db_query($conn, $sql);
            if ($res === false) {
                $arr_err[] = $username;
            }
        }
        db_close($conn);

        response::add_link('Go Back', 'javascript:history.back(1);');
        if (count($arr_err) == 0) {
            response::display_msg("User imported.");
        }
        else {
            response::display_msg("failed usernames are: " . join(", ", $arr_err));
        }
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
