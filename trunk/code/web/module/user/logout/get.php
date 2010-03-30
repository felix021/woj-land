<?php

class Main extends cframe
{
    protected $need_session = false;

    public function process()
    {
        session::set_logout();
        response::display_msg('Succeesfully logged out.');
        return true;
    }
}

?>
