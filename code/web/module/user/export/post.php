<?php

require_once(MODULE_ROOT . '/user/user.func.php');
require_once(MODULE_ROOT . '/user/score.func.php');

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

        $arr_username = explode("\n", trim($_POST['userdata']));
        foreach ($arr_username as &$username)
            $username = "'" . db_escape($conn, trim($username)) . "'";
        $usernames = join(',', $arr_username);

        $sql    = "SELECT * FROM users WHERE username IN ($usernames);";
        FM_LOG_DEBUG($sql);

        $users  = db_fetch_lines($conn, $sql, -1);
        fail_test($users, false);
        $arr_result = array();
        foreach ($users as $user) {
            $arr_result[] = array(
                'username' => $user['username'],
                'score'    => get_score($user['easy'], $user['medium'], $user['difficult']),
            );
        }

        db_close($conn);

        response::add_data('result', $arr_result);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl('download.tpl.php');
        return true;
    }
}

?>
