<?php

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $key  = request::$arr_get['key'];
        if ($key != land_conf::UPDATE_KEY) {
            FM_LOG_WARNING("BAD UPDATE KEY %s!", $key);
            return false;
        }

        $type = request::$arr_get['type'];
        if (!in_array($type, array("day", "week", "month"))) {
            FM_LOG_WARNING("BAD TYPE KEY %s!", $type);
            return false;
        }

        $from = date("Y-m-d H:i:s", strtotime("1 {$type} ago"));

        $AC_RESULT = land_conf::OJ_AC;
        $sql = <<<eot
SELECT `username`, COUNT(DISTINCT(problem_id)) as `solved` FROM `sources`
    WHERE `result` = $AC_RESULT
      AND `submit_time` >= '$from'
    GROUP BY `user_id`
    ORDER BY `solved` DESC
    LIMIT 0, 1
eot;

        $conn = db_connect();
        fail_test($conn, false);
        $user = db_fetch_line($conn, $sql);
        db_close($conn);

        $data = cache_util::load("diligent");
        $data->$type = $user['username'];
        cache_util::save("diligent", $data);
        $this->arr_data['user'] = $user['username'];
        return true;
    }

    public function display()
    {
        response::display_msg("UPDATE OK: " . $this->arr_data['user']);
        return true;
    }
}

?>
