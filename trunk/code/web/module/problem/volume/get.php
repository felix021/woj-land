<?php

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $conn = db_connect();
        fail_test($conn, false);

        $sql = "SELECT MAX(`problem_id`) FROM `problems`";
        $maxid = db_count($conn, $sql);
        db_close($conn);
        if ($maxid == 1000)
        {
            FM_LOG_WARNING("problems count = 0");
            throw new Exception("Currently there's no problem in Land :(");
        }
        $volumes = ($maxid - land_conf::MIN_PROBLEM_ID);
        $volumes = ($volumes + land_conf::PROBLEMS_PER_VOLUME);
        $volumes = floor($volumes / land_conf::PROBLEMS_PER_VOLUME);
        FM_LOG_DEBUG("maxid: %d, volumes: %d", $maxid, $volumes);
        response::add_data('maxid', $maxid);
        response::add_data('volumes', $volumes);
        response::add_data('start_id', land_conf::MIN_PROBLEM_ID);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("volume.tpl.php");
        return true;
    }
}

?>
