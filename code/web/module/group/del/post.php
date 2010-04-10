<?php

require_once(MODULE_ROOT . '/group/groups.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $p = request::$arr_post;

        $seed = session::get_vcode();
        if (false === $seed || $seed != $p['seed'])
        {
            throw new Exception("Seed not set, please try again.");
        }

        $sql = 'DELETE FROM `groups` WHERE `group_id`=' . (int)$p['group_id'];

        $conn = db_connect();
        fail_test($conn, false);

        $res = db_query($conn, $sql);
        fail_test($res, false);

        db_close($conn);

        response::add_data('msg', 'Group deleted.');
        return true;
    }

    public function display()
    {
        $this->set_my_tpl('del.tpl.php');
        return true;
    }
}

?>
