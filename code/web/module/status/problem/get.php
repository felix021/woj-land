<?php

require_once(MODULE_ROOT . '/problem/problem.func.php');

class Main extends cframe
{

    protected $need_session = true;
    protected $need_login   = false;

    public function process()
    {
        $page    = 1;
        if (isset(request::$arr_get['page']))
            $page    = (int)request::$arr_get['page'];
        if ($page < 1)
            $page = 1;

        $itpp  = land_conf::STATUS_PER_PAGE;
        $start = ($page - 1) * $itpp;

        $pid     = (int)request::$arr_get['problem_id'];
        $problem = get_problem_by_id($pid);
        response::add_data('problem', $problem);

        response::add_data('problem_id', $pid);
        response::add_data('page', $page);

        $conn = db_connect();
        fail_test($conn, false);

        $ac = land_conf::OJ_AC;
        $sql = <<<eot
SELECT `source_id`, `username`, `memory_usage`, `time_usage`, `lang`, `length`, `submit_time`
    FROM `sources` 
    WHERE `problem_id`=$pid AND `result`=$ac
    ORDER BY `time_usage` ASC, `memory_usage` ASC
    LIMIT $start,$itpp
eot;
        $lines = db_fetch_lines($conn, $sql, -1);
        response::add_data('statuses', $lines);

        $sql = 'SELECT `result`, COUNT(*) as `num` FROM `sources` WHERE problem_id=' . $pid . ' GROUP BY `result`';
        $lines = db_fetch_lines($conn, $sql, -1);
        $results = array(
            'AC'    => 0,
            'PE'    => 0,
            'TLE'    => 0,
            'MLE'    => 0,
            'WA'    => 0,
            'RE'    => 0,
            'OLE'    => 0,
            'CE'    => 0,
            'RF'    => 0,
            'SE'    => 0,
            'TOTAL'    => 0,
            );
        foreach ($lines as $line)
        {
            switch($line['result'])
            {
                case land_conf::OJ_WAIT: break;
                case land_conf::OJ_AC: $results['AC'] += $line['num']; break;
                case land_conf::OJ_PE: $results['PE'] += $line['num']; break;
                case land_conf::OJ_TLE: $results['TLE'] += $line['num']; break;
                case land_conf::OJ_MLE: $results['MLE'] += $line['num']; break;
                case land_conf::OJ_WA: $results['WA'] += $line['num']; break;
                case land_conf::OJ_OLE: $results['OLE'] += $line['num']; break;
                case land_conf::OJ_CE: $results['CE'] += $line['num']; break;
                case land_conf::OJ_RF: $results['RF'] += $line['num']; break;
                case land_conf::OJ_SE: $results['SE'] += $line['num']; break;
                default: $results['RE'] += $line['num']; break;
            }
            $results['TOTAL'] += $line['num'];
        }
        response::add_data('results', $results);

        db_close($conn);
        return true;
    }

    public function display()
    {
        $this->set_my_tpl("problem.tpl.php");
        return true;
    }
}

?>
