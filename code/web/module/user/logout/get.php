<?php

class Main extends cframe
{
    public function process()
    {
        session::set_logout();
        response::display_msg('Succeesfully logged out.');
        return true;
    }
}

?>
