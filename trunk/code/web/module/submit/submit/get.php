<?php

class Main extends cframe
{
    protected $need_login = false;
    protected $need_info  = true;

    public function process()
    {
        $problem_id = 1001;
        if (isset(request::$arr_get['problem_id']))
        {
            $problem_id = (int)request::$arr_get['problem_id'];
        }
        $share_code     = 0;
        $preferred_lang = land_conf::LANG_C;
        if (session::$is_login)
        {
            $preferred_lang = session::$user_info['preferred_lang'];
            $share_code     = session::$user_info['share_code'];
        }
        response::add_data('anonymous_name', session::ANONYMOUS_NAME);
        response::add_data('preferred_lang', $preferred_lang);
        response::add_data('share_code', $share_code);
        response::add_data('problem_id', $problem_id);
        response::add_data('lang', land_conf::$lang);
        response::add_data('min_len', land_conf::MIN_SOURCE_LEN);
        response::add_data('max_len', land_conf::MAX_SOURCE_LEN);
        //TODO vcontest_id 
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("submit.tpl.php");
        return true;
    }
}

?>
