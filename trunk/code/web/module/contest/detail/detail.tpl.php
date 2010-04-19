<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $contest = $p['contest'];
        $cid = (int)$contest['contest_id'];
        foreach ($contest as &$v) $v = htmlspecialchars($v);
        $start      = strtotime($contest['start_time']);
        $end        = strtotime($contest['end_time']);
        $now        = time();
        $now_str    = date('Y-m-d H:i:s', $now);
        $status     = '';
        $pending    = 0;
        if ($now < $start)
        {
            $status = '<span style="color:green;">Pending</span>';
            $pending = 1;
        }
        else if ($now > $end)
        {
            $status = '<span style="color:black;">Finished</span>';
        }
        else
        {
            $status = '<span style="color:red;">Running</span>';
        }
        $pub        = '';
        if ($contest['private'])
        {
            $pub = '<span style="color:red">Private</span>';
        }
        else
        {
            $pub = '<span>Public</span>';
        }

        $seq_edit_bt = '';
        if (is_admin())
        {
            $seq_edit_bt = "<span class=\"bt\"><a href=\"$web_root/contest/seqedit?contest_id=$cid\">Edit Sequence</a></span>";
        }

        echo <<<eot
<div id="tt"> 
Contest - {$contest['title']}
</div> 
<style>td{text-align:center;}</style>

<script>
var server_time = $now;
var start_time = $start;
var interval = 0;
var pending = $pending;

function sync_server_time(status, text)
{
    if (status == 200)
    {
        interval = 0;
        timestamp = new Number(text);
        setTimeout('updateTime()', 1000);
    }
}

function updateTime()
{
try{
    server_time++;
    if (pending == 1 && server_time >= start_time)
    {
        //alert('Attention: Contest starts!');
        location.reload();
    }
    var now = $('now');
    var D = new Date(server_time * 1000); //miliseconds
    var Y = D.getFullYear();
    var m = (D.getMonth() + 1);
    if (m < 10) m = '0' + m.toString();
    var d = D.getDate();
    if (d < 10) d = '0' + d.toString();
    var H = D.getHours();
    if (H < 10) H = '0' + H.toString();
    var i = D.getMinutes();
    if (i < 10) i = '0' + i.toString();
    var s = D.getSeconds();
    if (s < 10) s = '0' + s.toString();
    
    now.innerHTML = Y + '-' + m + '-' + d + ' ' + H + ':' + i + ':' + s;
    D = null;
    if (interval >= 60) //update once a minute
    {
        interval = 0;
        LoadURL('POST', '$web_root/ajax/time', '', sync_server_time);
    }
    else
    {
        interval++;
        setTimeout('updateTime()', 1000);
    }
}catch(e) {alert(e);}
}

</script>

<div class="ifm"> 
<strong>Start Time</strong>: {$contest['start_time']} &nbsp;<strong>End Time</strong>: {$contest['end_time']}<br/> 
<strong>Server Time</strong>: <span id="now">$now_str</span>&nbsp; <br/>
<strong>Status</strong>: $status &nbsp; <strong>Type</strong>: $pub
</div> 

<div id="main"> 

<table><tbody> 
    <tr> 
        <th width="100"></th> 
        <th width="150">Problem Id</th> 
        <th>Title</th> 
        <th width="100"></th> 
    </tr> 
eot;

        $i = 0;
        foreach ($p['problems'] as $problem)
        {
            $pid = (int)$problem['problem_id'];
            $trc = $i++ & 1 ? 'tro' : 'tre';
            $title = htmlspecialchars($problem['title']);
            echo <<<eot
    <tr class="{$trc}">
        <td></td> 
        <td>Problem {$problem['char']}</td> 
        <td><a href="$web_root/problem/detail?problem_id=$pid&contest_id=$cid">{$title}</a></td> 
        <td></td> 
    </tr>

eot;
        }

        $title = urlencode(htmlspecialchars($p['contest']['title']));

        echo <<<eot

</tbody></table> 
<br/>
<div style="text-indent:100px;">

    <span class="bt"><a href="$web_root/contest/standing?contest_id=$cid&title={$title}">Standing</a></span>&nbsp;
    <span class="bt"><a href="$web_root/status?contest_id=$cid">Status</a></span>&nbsp;
    <span class="bt"><a href="$web_root/contest/statistics?contest_id=$cid&title={$title}">Statistics</a></span> 
    $seq_edit_bt
    </div>
<br />
</div> 

<script>
try{
    setTimeout('updateTime()', 1000);
}
catch(e) {alert(e);}
</script>
eot;
        return true;
    }
}

?>
