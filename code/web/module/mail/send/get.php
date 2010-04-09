<?php

require_once(MODULE_ROOT . '/mail/mail.func.php');

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $mail_id = 0;
        if (isset(request::$arr_get['rep_mail_id']))
        {
            $mail_id = (int) request::$arr_get['rep_mail_id'];
        }
        $conn = null;
        $mail = $mail_id > 0 ? get_mail_by_mail_id($conn, $mail_id) : null;
        if ($mail)
        {
            $uid = session::$user_id;
            if ($mail['to_user_id'] != $uid && $mail['from_user_id'] != $uid)
            {
                FM_LOG_WARNING("Unauthorized access to mail:%d, uid:%d", $mail_id, $uid);
                throw new Exception("You don't have permission to this mail.");
            }
            response::add_data('to_username', $mail['from_username']);
            response::add_data('title', 'Re: ' . $mail['title']);
            response::add_data('content', 
                  "\n\n\n--- {$mail['from_username']} writes @{$mail['send_time']} ---\n\n"
                . substr($mail['content'], 0, land_conf::MAIL_SLICE_LEN));
        }
        else
        {
            response::add_data('to_username', '');
        }
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("send.tpl.php");
        return true;
    }
}

?>
