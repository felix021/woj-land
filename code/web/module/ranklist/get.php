<?php

class Main extends cframe
{
    public function process()
    {
        $page = 1;
        if (isset(request::$arr_get['page']))
            $page = (int) request::$arr_get['page'];
        if ($page < 1)
        {
            $page = 1;
        }
        $itpp  = land_conf::USERS_PER_PAGE;
        $start = ($page - 1) * $itpp;

        $sql = <<<eot
SELECT `user_id`, `username`, `nickname`, `solved`, `submit`
  FROM `users`
  ORDER BY `solved` DESC
  LIMIT $start,$itpp
eot;

        $conn = db_connect();
        fail_test($conn, false);

        $users = db_fetch_lines($conn, $sql, $itpp);
        fail_test($users, false);

        db_close($conn);

        foreach ($users as &$user)
        {
            if ($user['submit'] == 0)
                $user['ratio'] = '0';
            else
                $user['ratio'] = round($user['solved'] / $user['submit'], 2);
        }

        response::add_data('page', $page);
        response::add_data('start', $start);
        response::add_data('users', $users);

        return true;
    }

    public function display()
    {
        $this->set_my_tpl("ranklist.tpl.php");
        return true;
    }
}

?>
