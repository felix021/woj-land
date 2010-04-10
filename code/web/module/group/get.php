<?php

require_once(MODULE_ROOT . '/group/groups.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $groups = load_all_groups();

        response::add_data('groups', $groups);
        response::add_data('seed', session::gen_vcode());

        return true;
    }

    public function display()
    {
        $this->set_my_tpl("manage.tpl.php");
        return true;
    }
}

?>
