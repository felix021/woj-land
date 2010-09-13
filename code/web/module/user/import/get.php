<?php

require_once(MODULE_ROOT . '/user/user.func.php');
require_once(MODULE_ROOT . '/group/groups.func.php');

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        response::add_data('seed', session::gen_vcode());
        return true;
    }

    public function display()
    {
        $this->set_my_tpl('import.tpl.php');
        return true;
    }
}

?>
