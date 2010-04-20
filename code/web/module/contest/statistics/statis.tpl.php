<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $title = htmlspecialchars($p['title']);
        $cid = $p['contest_id'];
        echo <<<eot
<div id="tt">
    Contest Statistics - <a href="$web_root/contest/detail?contest_id=$cid">{$title}</a>
</div>

<style>td{text-align:center;}</style>

<div id="main">
    <table><tbody>
        <tr>
            <th></th>
            <th width="75">AC</th>
            <th width="75">PE</th>
            <th width="75">CE</th>
            <th width="75">WA</th>
            <th width="75">TLE</th>
            <th width="75">RE</th>
            <th width="75">MLE</th>
            <th width="75">OLE</th>
            <th width="100">Total</th>
        </tr>
eot;
        $total = array(
            'AC'	=> 0,
            'PE'	=> 0,
            'CE'	=> 0,
            'WA'	=> 0,
            'TLE'	=> 0,
            'RE'	=> 0,
            'MLE'	=> 0,
            'OLE'	=> 0,
            'total'	=> 0,
            );
        $i = 0;
        foreach ($p['arr_statis'] as $statis)
        {
            $ch = seq_to_char($statis['contest_seq']);
            $pid = $statis['problem_id'];
            foreach ($statis as $k => $v)
            {
                if (isset($total[$k]))
                    $total[$k] += $v;
            }
            $trc = $i++ & 1 ? 'tro' : 'tre';
            echo <<<eot
        <tr class="$trc">
            <td><a href="$web_root/problem/detail?problem_id=$pid">$ch</a></td>
            <td>{$statis['AC']}</td>
            <td>{$statis['PE']}</td>
            <td>{$statis['CE']}</td>
            <td>{$statis['WA']}</td>
            <td>{$statis['TLE']}</td>
            <td>{$statis['RE']}</td>
            <td>{$statis['MLE']}</td>
            <td>{$statis['OLE']}</td>
            <td>{$statis['total']}</td>
        </tr>

eot;
        }
        echo <<<eot
        <tr style="background-color:#ffff7f;height:24px;font-weight:bold">
            <td>Total</td>
            <td>{$total['AC']}</td>
            <td>{$total['PE']}</td>
            <td>{$total['CE']}</td>
            <td>{$total['WA']}</td>
            <td>{$total['TLE']}</td>
            <td>{$total['RE']}</td>
            <td>{$total['MLE']}</td>
            <td>{$total['OLE']}</td>
            <td>{$total['total']}</td>
        </tr>
    <tbody></table>
<br/>
<span class="bt"><a href="$web_root/contest/detail?contest_id=$cid">Back to Contest</a></span>
<br/><br/>
</div>
eot;
        return true;
    }
}

?>
