<?php

class Main extends cframe
{
    public function process()
    {
        $source_id = (int)request::$arr_get['source_id'];
        $sql = 'SELECT `user_id`, `result`, `extra_info` from `sources` WHERE `source_id`=' . $source_id;
        $conn = db_connect();
        fail_test($conn, false);

        $source = db_fetch_line($conn, $sql);
        fail_test($conn, false);

        if ($source['user_id'] != session::$user_id)
        {
            FM_LOG_WARNING("unauthorized access to source_extra_info");
            throw new Exception("You don't have permission to this page :(");
        }

        $info = land_conf::$result_name[$source['result']];
        response::add_data('info', $info);
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
