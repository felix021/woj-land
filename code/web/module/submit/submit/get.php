<?php

class Main extends cframe
{
    protected $need_login = true;

    public function process()
    {
        if (is_admin())
        {
            //强制管理员只能提交admin的代码，避免误操作
            request::$arr_get['admin'] = true;
        }

        if (isset(request::$arr_get['admin']))
        {
            if (!is_admin())
            {
                throw new Exception("You don't have permission to submit as an administrator.");
            }
            response::add_data('admin', 'admin');
        }
        else
        {
            response::add_data('admin', '');
        }

        $problem_id = '';
        if (isset(request::$arr_get['problem_id']))
        {
            $problem_id = (int)request::$arr_get['problem_id'];
        }
        $share_code     = 0;
        if (session::$is_login)
        {
            $share_code     = session::$user_info['share_code'];
        }
        else
        {
            if (isset(request::$arr_get['contest_id']))
            {
                throw new Exception('Anonymous user are not allowed to attend contests. Please login first.');
            }
        }
        response::add_data('anonymous_name', session::ANONYMOUS_NAME);
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
