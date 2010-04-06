<?php

require_once(MODULE_ROOT . '/mail/mailbox/mailbox.tpl.php');

class TPL_Main extends TPL_mailbox
{
    protected $box_name = 'Outbox';
    protected $to_from  = 'TO';
    protected $to_from_param = 'to_username';
}

?>
