<?php

class Main extends cframe
{
    protected $need_info  = true;
    //未登录不允许查看代码
    protected $need_login = true;

    public function process()
    {
        $source_id = (int)request::$arr_get['source_id'];
        $conn = db_connect();
        fail_test($conn, false);

        $sql = "SELECT * FROM `sources` WHERE `source_id`=$source_id";
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
            $priv = get_privileges_by_groups($group_ids);
            //FM_LOG_DEBUG("priv: %s", print_r($priv, true));
            if ($priv['view_src'])
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
