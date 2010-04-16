<?php

class problem_contest_info
{
    public $seq     = 0;
    public $ac_time = 0;
    public $submits = 0;
    public $wrongs  = array();
}

function pgi_get_idx_by_seq(&$arr, $seq)
{
    if (!is_array($arr))
    {
        $arr = array();
    }
    $i = 0;
    for (; $i < count($arr); $i++)
    {
        if ($arr[$i]->seq == $seq)
            return $i;
    }

    $arr[$i] = new problem_contest_info();
    $arr[$i]->seq = $seq;
    return $i;
}

?>
