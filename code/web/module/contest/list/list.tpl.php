<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $page = $p['page'];
        $prev = $page - 1;
        $next = $page + 1;

        $extra_col = '';
        if (is_admin())
        {
            $extra_col = '<th width="60">Edit</th>';
        }

        echo <<<eot
<style>td{text-align:center;}</style>
<div id="tt">Contests List</div> 
<div id="main"> 
    <table><tbody> 
        <tr> 
            <th width="420">Title</th> 
            <th width="80">Status</th> 
            <th width="140">Start</th> 
            <th width="140">End</th> 
            <th width="60">Type</th> 
            $extra_col
        </tr> 
eot;
        if (is_array($p['contests']))
        foreach ($p['contests'] as $contest)
        {
            foreach ($contest as &$v) $v = htmlspecialchars($v);
            $start      = strtotime($contest['start_time']);
            $end        = strtotime($contest['end_time']);
            $now        = time();
            $status     = '';
            if ($now < $start)
            {
                $status = '<span style="color:green;">Pending</span>';
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
            if (is_admin())
            {
                $extra_col = "<td><a href=\"$web_root/contest/edit?contest_id={$contest['contest_id']}\">Edit</a></td>";
            }
            echo <<<eot
        <tr class="tro"> 
            <td><a href="$web_root/contest/detail?contest_id={$contest['contest_id']}">{$contest['title']}</a></td> 
            <td>$status</td>
            <td>{$contest['start_time']}</td>
            <td>{$contest['end_time']}</td>
            <td>$pub</td> 
            $extra_col
        </tr> 
eot;
        }

        echo <<<eot
    </tbody></table> 
    <br/>
    <span class="bt"><a href="$web_root/contest/list">Top</a></span> 
    <span class="bt"><a href="$web_root/contest/list?page={$prev}">Prev Page</a></span> 
    <span class="bt"><a href="$web_root/contest/list?page={$next}">Next Page</a></span>
    <br/>
    <br/>
</div>

eot;
        return true;
    }
}

?>
