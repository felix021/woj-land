<?php

class Main extends cframe
{
    public $contest_id;
    public $problem_id;
    public $username;
    public $language;
    public $result;
    public $conn;
    
    public function process()
    {
        $page = 1;
        if (isset(request::$arr_get['page']))
        {
            $page = (int)request::$arr_get['page'];
            if ($page < 1)
            {
                $page = 1;
            }
        }
        $itpp  = land_conf::STATUS_PER_PAGE;
        $start = ($page - 1) * $itpp;

        $conn = db_connect();
        fail_test($conn, false);
        $this->conn = $conn;

        $where_cond = $this->get_where_cond();
        $sql = <<<eot
SELECT `source_id`, `problem_id`, `username`, `length`, `submit_time`,
    `result`, `memory_usage`, `time_usage`, `lang`, `share`
  FROM `sources`
  $where_cond
  ORDER BY `source_id` desc
  LIMIT $start, $itpp;
eot;

        $lines = db_fetch_lines($conn, $sql, $itpp);
        db_close($conn);
        
        foreach ($lines as &$line)
        {
            //TODO 该代码是否可见(share + AC)
            $line['visible'] = true;
        }

        response::add_data('status', $lines);
        response::add_data('result_name', land_conf::$result_name);
        response::add_data('lang', land_conf::$lang);
        response::add_data('page', $page);

        response::add_data('contest_id', $this->contest_id);
        response::add_data('problem_id', $this->problem_id);
        response::add_data('username', $this->username);
        response::add_data('language', $this->language);
        response::add_data('result', $this->result);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("status.tpl.php");
        return true;
    }

    public function get_where_cond()
    {
        $cond = array();

        $contest_id = force_read(request::$arr_get, 'contest_id');
        if (!is_null($contest_id) && '' !== ($contest_id))
        {
            $cond[] = '`contest_id`=' . (int)$contest_id;
            $this->contest_id = $contest_id;
        }

        $problem_id = force_read(request::$arr_get, 'problem_id');
        if (!is_null($problem_id) && '' !== ($problem_id))
        {
            $cond[] = '`problem_id`=' . (int)$problem_id;
            $this->problem_id = $problem_id;
        }

        $username   = force_read(request::$arr_get, 'username');
        if (!is_null($username) && '' !== ($username))
        {
            $cond[] = '`username`="' . db_escape($this->conn, $username) . '"';
            $this->username = $username;
        }

        $language   = force_read(request::$arr_get, 'language');
        if (!is_null($language) && '' !== ($language))
        {
            $cond[] = '`lang`=' . (int)$language;
            $this->language = $language;
        }

        $result     = force_read(request::$arr_get, 'result');
        if (!is_null($result) && '' !== ($result))
        {
            $cond[] = '`result`=' . (int)$result;
            $this->result = $result;
        }

        if (count($cond) > 0)
            return 'WHERE ' . implode(' AND ', $cond);
        else
            return '';
    }

}

?>
