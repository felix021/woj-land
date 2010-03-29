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
SELECT `user_id`, `username`, `nickname`, `solved`, `submit`, (`solved`/`submit`) as `ratio`
  FROM `users`
  ORDER BY `solved` DESC, `ratio` DESC, `submit` DESC
  LIMIT $start,$itpp
eot;

        $conn = db_connect();
        fail_test($conn, false);

        $users = db_fetch_lines($conn, $sql, $itpp);
        fail_test($users, false);

        db_close($conn);

        foreach ($users as &$user)
        {
            $user['ratio'] = round($user['ratio'], 2);
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
