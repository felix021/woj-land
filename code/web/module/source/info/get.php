<?php

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $source_id = (int)request::$arr_get['source_id'];

        $admin = false;
        $tbl_name = 'sources';
        if (isset(request::$arr_get['admin']))
        {
            $admin = true;
            $tbl_name = 'admin_sources';
            if (!is_admin())
            {
                throw new Exception("Your don't have the permission to access this page.");
            }
        }

        $sql = <<<eot
SELECT `user_id`, `result`, `source_code`, `extra_info` 
    FROM `$tbl_name` 
    WHERE `source_id`=$source_id
eot;
        $conn = db_connect();
        fail_test($conn, false);

        $source = db_fetch_line($conn, $sql);
        fail_test($conn, false);

        if (!is_admin() && 
            $source['user_id'] != session::ANONYMOUS_ID && $source['user_id'] != session::$user_id)
        {
            FM_LOG_WARNING("unauthorized access to source_extra_info");
            throw new Exception("You don't have permission to this page :(");
        }

        if ($source['result'] != land_conf::OJ_CE)
        {
            throw new Exception('No compilation error info');
        }

        $info = land_conf::$result_name[$source['result']];
        response::add_data('info', $info);
        response::add_data('user_id', $source['user_id']);
        response::add_data('source_code', $source['source_code']);
        response::add_data('extra_info', $source['extra_info']);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("info.tpl.php");
        return true;
    }
}

?>
