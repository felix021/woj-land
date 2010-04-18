<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        echo <<<eot
<style>td{text-align:center;}</style>
<div id="tt">Contests - Summer Practice </div> 
<div id="main"> 
    <table><tbody> 
        <tr> 
            <th width="50">Rank</th> 
            <th> Name </th> 
            <th width="30">Solved</th> 
            <th width="75">Time</th> 

eot;
        foreach ($p['arr_seq'] as $seq => $pid)
        {
            $seq_char = seq_to_char($seq);
            echo <<<eot
            <th><a href="$web_root/problem/detail?problem_id={$pid}">$seq_char</a></th> 

eot;
        }
        echo "        </tr> ";

        $i = $p['rank'];
        foreach ($p['users'] as $user)
        {
            $trc = $i++ & 1 ? 'tro' : 'trc';
            $username = htmlspecialchars($user['username']);
            $penalty = floor($user['penalty'] / 60);
            echo <<<eot
        <tr class="$trc"> 
            <td>$i</td> 
            <td><a href="$web_root/status?username={$username}"> {$username} </a> </td> 
            <td>{$user['accepts']}</td> 
            <td>{$penalty}</td> 
eot;
            foreach ($p['arr_seq'] as $seq => $pid)
            {
                $disp = '';
                if (isset($user['pinfo'][$seq]))
                {
                    $pinfo = $user['pinfo'][$seq];
                    if ($pinfo->ac_time > 0)
                    {
                        $disp = $pinfo->submits . '/' . floor($pinfo->ac_time / 60);
                    }
                    else
                    {
                        $disp = $pinfo->submits . '/--';
                    }
                }
                echo <<<eot
            <td> $disp </td> 

eot;
            }
                echo <<<eot
        </tr>

eot;
        }

        echo <<<eot
    </tbody></table> 
<br></div> 

eot;
        return true;
    }
}

?>
