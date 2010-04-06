<?php

require_once(MODULE_ROOT . '/mail/mailbox/mailbox.tpl.php');

class TPL_Main extends TPL_mailbox
{
    protected $box_name = 'Inbox';
    protected $to_from  = 'FROM';
    protected $to_from_param = 'from_username';
}

?>
