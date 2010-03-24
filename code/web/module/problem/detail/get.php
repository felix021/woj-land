<?php

class Main extends cframe
{
    public function process()
    {
        $conn = db_connect();
        fail_test($conn, false);

        $problem_id = (int)request::$arr_get['problem_id'];
        $sql = "SELECT * FROM `problems` WHERE `problem_id`=$problem_id";
        $problem    = db_fetch_line($conn, $sql);
        if ($line == false)
        {
            FM_LOG_TRACE("request a not-exist problem");
            throw new Exception("This problem does not exist in Land.");
        }
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("detail.tpl.php");
        return true;
    }
}

?>
