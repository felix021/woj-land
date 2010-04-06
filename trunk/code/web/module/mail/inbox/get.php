<?php

require_once(MODULE_ROOT . '/mail/mailbox/mailbox.php');

class Main extends mailbox
{
    protected $param_id  = 'to_user_id';
    protected $param_del = 'reader_del';

    public function display()
    {
        $this->set_my_tpl("inbox.tpl.php");
        return true;
    }
}

?>
