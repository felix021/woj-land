<?php

class Main extends cframe
{
    //未登录不允许查看代码
    protected $need_login = true;

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

        $conn = db_connect();
        fail_test($conn, false);

        $sql = "SELECT * FROM `{$tbl_name}` WHERE `source_id`=$source_id";
        $source = db_fetch_line($conn, $sql);
        fail_test($source, false);

        $visible  = false;
        do {
            //1. 提交者
            if ($source['user_id'] == session::$user_id)
            {
                $visible = true;
                break;
            }

            //2. AC过这题且该代码允许共享
            $solved_list = session::$user_info['solved_list'];
            if (in_solved_list($source['problem_id'], $solved_list)
                && $source['share'] == 1)
            {
                $visible = true;
                break;
            }

            //3. 有看代码权限
            $group_ids = session::$user_info['group_ids'];
            //FM_LOG_DEBUG("priv: %s", print_r($priv, true));
            if (is_array(session::$priv) && session::$priv['view_src'])
            {
                $visible = true;
                break;
            }

        } while (false);

        if (!$visible)
        {
            FM_LOG_WARNING("no permission to view src_code");
            throw new Exception("You don't have permission to access this page :(");
        }

        if (isset(request::$arr_get['format']) && request::$arr_get['format'] == 1)
        {
            include_once(dirname(__FILE__) . "/source.inc.php");
            $source['source_code'] = format_code($source['source_code']);
        }

        response::add_data('source', $source);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("source.tpl.php");
        return true;
    }
}

?>
