<?php

require_once(MODULE_ROOT . '/user/user.func.php');

class Main extends cframe
{

    protected $need_session = true;
    protected $need_info    = true;
    protected $need_login   = true;

    public function process()
    {
        $conn = null;
        $user = get_user_by_username($conn, request::$arr_post['to_username']);
        if (false == $user)
        {
            FM_LOG_WARNING("unknown user");
            throw new Exception("This user does not exist in land. Maybe he's still on noah's ark?");
        }
        $f_uid = session::$user_id;
        $f_un  = db_escape($conn, session::$user_info['username']);
        $t_uid = $user['user_id'];
        $t_un  = db_escape($conn, $user['username']);
        $stime = date("Y-m-d H:i:s");
        $title = db_escape($conn, request::$arr_post['title']);
        $ct    = db_escape($conn, request::$arr_post['content']);

        $sql = <<<eot
INSERT INTO `mails` 
(`from_user_id`, `from_username`, `to_user_id`, `to_username`, `send_time`, `title`, `content`)
VALUES
($f_uid, '$f_un', $t_uid, '$t_un', '$stime', '$title', '$ct')
eot;

        $mail_id = db_insert($conn, $sql);
        response::add_link('Inbox', land_conf::$web_root . '/mail/inbox');
        response::add_link('Outbox', land_conf::$web_root . '/mail/outbox');
        response::display_msg("Your mail has been sent.");
        return true;
    }

}

?>
