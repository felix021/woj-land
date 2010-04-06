<?php

require_once(MODULE_ROOT . '/mail/mail.func.php');

class Main extends cframe
{

    protected $need_session = true;
    protected $need_info    = true;

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

        $sql = 'UPDATE `mails` SET `%s`=1 WHERE `mail_id`=' . $mail_id;
        if ($mail['to_user_id'] == $uid)
        {
            $sql = sprintf($sql, 'reader_del');
        }
        else
        {
            $sql = sprintf($sql, 'writer_del');
        }

        $res = db_query($conn, $sql);
        fail_test($res, false);
        db_close($conn);

        response::add_link('Inbox', land_conf::$web_root . '/mail/inbox'); 
        response::add_link('Outbox', land_conf::$web_root . '/mail/outbox'); 
        response::display_msg('The mail is now somewhere deep in the ocean.');

        return true;
    }
}

?>
