<?php

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $pid = (int) request::$arr_get['problem_id'];
        if ($pid <= 0)
            throw new Exception ('No problem_id provided');

        $sql = '';
        $msg = '';
        $act = request::$arr_get['act'];
        if ($act == 'enable')
        {
            $sql = 'UPDATE `problems` SET `enabled`=1 WHERE `problem_id`=' . $pid;
            $msg = 'Problem is enabled.';
        }
        else
        {
            $sql = 'UPDATE `problems` SET `enabled`=0 WHERE `problem_id`=' . $pid;
            $msg = 'Problem is disabled.';
        }

        $conn = db_connect();
        fail_test($conn, false);

        $res = db_query($conn, $sql);
        fail_test($res);

        db_close($conn);

        response::display_msg($msg);
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
