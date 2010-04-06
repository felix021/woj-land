<?php

require_once(MODULE_ROOT . '/mail/mailbox/mailbox.php');

class Main extends mailbox
{
    protected $param_id  = 'from_user_id';
    protected $param_del = 'writer_del';

    public function display()
    {
        $this->set_my_tpl("outbox.tpl.php");
        return true;
    }
}

?>
