<?php

class Main extends cframe
{
    protected $need_login = false;

    public function process()
    {
        $volume = (int)request::$arr_get['volume'];
        $start  = land_conf::MIN_PROBLEM_ID 
                + ($volume - 1) * land_conf::PROBLEMS_PER_VOLUME;
        $end    = $start + land_conf::PROBLEMS_PER_VOLUME - 1;

        $sql = <<<eot
SELECT `problem_id`, `title`, `submitted`, `accepted`
  FROM `problems`
  WHERE `problem_id` >= $start AND `problem_id` <=$end
eot;
        if (!is_admin())
        {
            $sql .= ' AND `enabled`=1';
        }
        $conn = db_connect();
        fail_test($conn, false);
        $problems = db_fetch_lines($conn, $sql, land_conf::PROBLEMS_PER_VOLUME);
        db_close($conn);
        foreach ($problems as &$p)
        {
            $ac = $p['accepted'];
            $st = $p['submitted'];
            if ($st == 0)
            {
                $p['ratio'] = 0;
            }
            else
            {
                $p['ratio'] = round($ac * 100 / $st, 2);
            }
        }
        response::add_data('problems', $problems);
        response::add_data('volume', $volume);

        return true;
    }

    public function display()
    {
        $this->set_my_tpl("list.tpl.php");
        return true;
    }
}

?>
