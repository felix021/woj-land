<?php

class Notice
{
    public $notice;
    public function __construct($str)
    {
        $this->notice = $str;
    }
}

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $notice = request::$arr_post['notice'];
        cache_util::save('notice', new Notice($notice));
        response::display_msg('Set notice succeeded.');
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
