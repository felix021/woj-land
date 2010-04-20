<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $title = htmlspecialchars($p['title']);
        $cid = $p['cid'];
        echo <<<eot
<style>td{text-align:center;}</style>
<div id="tt">Contests - <a href="$web_root/contest/detail?contest_id={$p['cid']}">$title</a></div> 
<div id="main"> 
    <table><tbody> 
        <tr> 
            <th width="50">Rank</th> 
            <th> Name </th> 
            <th width="60">Solved</th> 
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
            $trc = $i++ & 1 ? 'tro' : 'tre';
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
                        //$disp = $pinfo->submits . '/' . floor($pinfo->ac_time / 60);
                        $disp = time_to_str($pinfo->ac_time);
                    }
                    else
                    {
                        $disp = $pinfo->submits . '/--';
                    }
                    $disp .= '<br/>(' . (int)(-count($pinfo->wrongs)) . ')';
                }
                else
                {
                    //$disp = '(0)';
                }
                echo <<<eot
            <td> $disp </td> 

eot;
            }
                echo <<<eot
        </tr>

eot;
        }


        $page = (int)$p['page'];
        $prev = $page - 1;
        $next = $page + 1;
        $title = urlencode($p['title']);
        echo <<<eot
    </tbody></table> 

<br/>
 <div> 
    <span class="bt"><a href="javascript:history.back(1)"> Back </a></span> &nbsp;
    <span class="bt"><a href="$web_root/contest/standing?contest_id=$cid&page=1"> Top </a></span> &nbsp;
    <span class="bt"><a href="$web_root/contest/standing?contest_id=$cid&page=$prev"> Prev Page </a></span> &nbsp;
    <span class="bt"><a href="$web_root/contest/standing?contest_id=$cid&page=$next"> Next Page </a></span> 
  </div><br/> 
</div> 

eot;
        return true;
    }
}

?>
