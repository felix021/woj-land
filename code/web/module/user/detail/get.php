<?php

require_once(MODULE_ROOT . '/user/user.func.php');

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $user_id  = session::ANONYMOUS_ID;
        $username = session::ANONYMOUS_NAME;
        $sql = 'SELECT * FROM `users` WHERE ';
        $user = null;
        $conn = null;
        if (isset(request::$arr_get['user_id']))
        {
            $user = get_user_by_user_id($conn, request::$arr_get['user_id']);
        }
        else if (isset(request::$arr_get['username']))
        {
            $user = get_user_by_username($conn, request::$arr_get['username']);
        }
        else
        {
            db_close($conn);
            FM_LOG_WARNING("no user_id or username provided");
            throw new Exception("");
        }

        if (false == $user)
        {
            FM_LOG_WARNING("unknown user");
            throw new Exception("This user does not exist in land. Maybe he's still on noah's ark?");
        }

        $submit = (int)$user['submit'];
        $solved = (int)$user['solved'];
        $ratio  = ($submit > 0) ? $solved / $submit : 0;
        $sql = <<<eot
SELECT COUNT(*) FROM `users` 
    WHERE  `solved`>$solved 
       OR (`solved`=$solved AND (`solved`/`submit`)>$ratio)
       OR (`solved`=$solved AND (`solved`/`submit`)=$ratio AND `submit`>$submit)
eot;
        $rank = db_count($conn, $sql) + 1;

        $user['rank'] = $rank;
        $arr_solved = explode('|', $user['solved_list']);
        sort($arr_solved);
        response::add_data('user', $user);
        response::add_data('arr_solved', $arr_solved);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("detail.tpl.php");
        return true;
    }
}

?>
