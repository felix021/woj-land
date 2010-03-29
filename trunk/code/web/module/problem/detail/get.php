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
        db_close($conn);
        if ($problem == false)
        {
            FM_LOG_WARNING("request a not-exist problem");
            throw new Exception("This problem does not exist in Land. Maybe it's still on noah's ark?");
        }

        response::add_data('problem', $problem);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("detail.tpl.php");
        return true;
    }
}

?>
