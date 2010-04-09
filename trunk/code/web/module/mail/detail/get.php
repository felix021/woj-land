<?php

require_once(MODULE_ROOT . '/mail/mail.func.php');

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $mail_id = (int)request::$arr_get['mail_id'];

        $mail = get_mail_by_mail_id($conn, $mail_id);

        $uid = session::$user_id;
        if ($mail['to_user_id'] != $uid && $mail['from_user_id'] != $uid)
        {
            FM_LOG_TRACE("Unauthorized access to mail(%d), user: %d", $mail_id, $uid);
            throw new Exception("You don't have permission to access this mail.");
        }

        if ($mail['to_user_id'] == $uid && $mail['unread'] == 1)
        {
            db_query($conn, 'UPDATE `mails` SET `unread`=0 WHERE `mail_id`=' . $mail_id);
        }
        db_close($conn);

        session::read_mail();
        response::add_data('mail', $mail);
        response::add_data('out_mail', $mail['from_user_id'] == $uid);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("detail.tpl.php");
        return true;
    }
}

?>
