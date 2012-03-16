<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $pro = $p['problem'];
        $res = $p['results'];
        $pid = (int)$p['problem_id'];
        $page = $p['page'];
        $prev = $page - 1;
        $next = $page + 1;

        echo <<<eot
<style type="text/css"> 
td{text-align:center;}
</style> 
<div id="tt"> 
    Problem Status - <a href="$web_root/problem/detail?problem_id={$pid}" >{$pid}</a> 
</div> 

<div id="main"> 
      <table><tbody> 
      <tr> 
        <th width="120">User Submitted</th> 
        <th width="120">User Solved</th> 
        <th width="80">Total</th> 
        <th width="50">AC</th> 
        <th width="50">PE</th> 
        <th width="50">WA</th> 
        <th width="50">TLE</th> 
        <th width="50">RE</th> 
        <th width="50">MLE</th> 
        <th width="50">OLE</th> 
        <th width="50">CE</th> 
      </tr> 
      <tr class="tro"> 
        <td>{$pro['submitted']}</td> 
        <td>{$pro['accepted']}</td> 
        <td>{$res['TOTAL']}</td> 
        <td>{$res['AC']}</td> 
        <td>{$res['PE']}</td> 
        <td>{$res['WA']}</td> 
        <td>{$res['TLE']}</td> 
        <td>{$res['RE']}</td> 
        <td>{$res['MLE']}</td> 
        <td>{$res['OLE']}</td> 
        <td>{$res['CE']}</td> 
      </tr> 
      </tbody></table> 
      <br/>

    <table><tbody> 
      <tr> 
        <th width="60">Rank</th> 
        <th width="70">Run ID</th> 
        <th width="130">User</th> 
        <th width="60">Time</th> 
        <th width="70">Memory</th> 
        <th width="90">Language</th> 
        <th width="80">Length</th> 
        <th width="170">Submit Time</th> 
      </tr> 
eot;
        $i = 0;
        if (is_array($p['statuses']))
        foreach ($p['statuses'] as $status)
        {
            $tr_class = $i++ & 1 ? 'tro' : 'tre';
            foreach ($status as &$v) $v = htmlspecialchars($v);
            $lang = land_conf::$lang[$status['lang']];
            $rank = $i + land_conf::STATUS_PER_PAGE * ($page - 1);
            echo <<<eot
      <tr class="{$tr_class}"> 
        <td>{$rank}</td> 
        <td>{$status['source_id']}</td> 
        <td><a href="$web_root/user/detail?username={$status['username']}">{$status['username']}</a></td> 
        <td>{$status['time_usage']}</td> 
        <td>{$status['memory_usage']}</td> 
        <td><a href="$web_root/source?source_id={$status['source_id']}">{$lang}</a></td> 
        <td>{$status['length']}</td> 
        <td>{$status['submit_time']}</td> 
      </tr> 
eot;
        }
        echo <<<eot
    </tbody></table> 
    <br/>
    <span class="bt"><a href="$web_root/status/problem?problem_id={$pid}">Top</a></span> 
    <span class="bt"><a href="$web_root/status/problem?page={$prev}&problem_id={$pid}">Prev Page</a></span> 
    <span class="bt"><a href="$web_root/status/problem?page={$next}&problem_id={$pid}">Next Page</a></span>
    <br/>
    <br/>
</div> 
eot;
        return true;
    }
}

?>
