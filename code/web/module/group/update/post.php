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

        $gid   = (int)$p['group_id'];
        $gname = $p['group_name'];

        $fields = array();
        foreach (land_conf::$priv_fields as $f)
        {
            $k = "`$f`";
            $v = isset($p[$f]) ? (int)$p[$f] : 0;
            $fields[] = "$k=$v";
        }
        $field_str = join(",\n  ", $fields);

        $conn = db_connect();
        fail_test($conn, false);
        $gname = db_escape($conn, $gname);

        $sql = <<<eot
UPDATE `groups` SET
  `group_name`='$gname',
  $field_str
  WHERE `group_id`=$gid
eot;

        $res = db_query($conn, $sql);
        fail_test($res, false);

        db_close($conn);

        response::add_link('Go Back', land_conf::$web_root . '/group');
        response::display_msg('Group updated successfully.');
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
