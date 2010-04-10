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

        $priv_f = array();
        $gname = $p['group_name'];
        foreach (land_conf::$priv_fields as $f)
        {
            $priv_f[] = "`$f`";
            $priv_v[] = isset($p[$f]) ? (int)$p[$f] : 0;
        }
        $priv_f_str = join(",", $priv_f);
        $priv_v_str = join(",", $priv_v);

        $conn = db_connect();
        fail_test($conn, false);
        $gname = db_escape($conn, $gname);

        $sql = <<<eot
INSERT INTO `groups`
(`group_id`, `group_name`, $priv_f_str)
VALUES
(NULL, '$gname' , $priv_v_str)
eot;

        $gid = db_insert($conn, $sql);
        fail_test($gid, false);

        db_close($conn);

        response::add_link('Go Back', land_conf::$web_root . '/group');
        response::display_msg('Group added successfully.');
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
