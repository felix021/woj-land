<?php

class Main extends cframe
{
    public function process()
    {
        $user_id  = session::ANONYMOUS_ID;
        $username = session::ANONYMOUS_NAME;
        $sql = 'SELECT * FROM `users` WHERE ';
        $conn = db_connect();
        if (isset(request::$arr_get['user_id']))
        {
            $user_id = (int)request::$arr_get['user_id'];
            $sql .= "`user_id`=$user_id";
        }
        else if (isset(request::$arr_get['username']))
        {
            $username = request::$arr_get['username'];
            $sql .= "`username`='" . db_escape($conn, $username) . "'";
        }
        else
        {
            db_close($conn);
            FM_LOG_WARNING("no user_id or username provided");
            throw new Exception("");
        }

        $user = db_fetch_line($conn, $sql);
        FM_LOG_DEBUG("user: %s", print_r($user, true));
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
        response::add_data('user', $user);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("detail.tpl.php");
        return true;
    }
}

?>
