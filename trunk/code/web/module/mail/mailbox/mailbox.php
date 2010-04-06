<?php

abstract class mailbox extends cframe
{
    protected $need_login = true;
    protected $need_info  = true;

    protected $param_id   = '';
    protected $param_del  = '';

    public function process()
    {
        $page = 1;
        if (isset(request::$arr_get['page']))
        {
            $page = (int) request::$arr_get['page'];
            if ($page < 1 ) $page = 1;
        }
        $itpp   = land_conf::MAILS_PER_PAGE;
        $start  = ($page - 1) * $itpp;
        $uid    = session::$user_id;
        $sql    = <<<eot
SELECT `mail_id`, `from_user_id`, `from_username`, `to_user_id`, `to_username`, `send_time`, `title`, `unread`
    FROM `mails`
    WHERE `{$this->param_id}`=$uid AND `{$this->param_del}`=0
    ORDER BY `send_time` DESC
    LIMIT $start,$itpp
eot;

        $conn = db_connect();
        fail_test($conn, false);

        $mails = db_fetch_lines($conn, $sql, $itpp);
        fail_test($mails, false);
        db_close($conn);

        response::add_data('page', $page);
        response::add_data('mails', $mails);
        response::add_data('username', session::$user_info['username']);
        return true;
    }
}

?>
