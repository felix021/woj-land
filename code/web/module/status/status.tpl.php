<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        //FM_LOG_DEBUG("%s", dump_var($p));
        $web_root = land_conf::$web_root;
        header("Refresh: 30");

        $result_opt = '<option value="">&nbsp;All&nbsp;</option>' . "\n";
        $result_s = is_null($p['result']) ? -1 : (int)$p['result'];
        foreach ($p['result_name'] as $k => $v)
        {
            $sel = $k == $result_s ? "selected" : "";
            $v = htmlspecialchars($v);
            $result_opt .= "    <option $sel value=\"$k\">&nbsp;$v&nbsp;</option>\n";
        }

        $language_opt = '<option value="">&nbsp;All&nbsp;</option>' . "\n";
        $lang_s = is_null($p['language']) ? -1 : (int)$p['language'];
        foreach ($p['lang'] as $k => $v)
        {
            $sel = $k == $lang_s ? "selected" : "";
            $v = htmlspecialchars($v);
            $language_opt .= "<option $sel value=\"$k\">&nbsp;$v&nbsp;</option>\n";
        }
 
        $username = htmlspecialchars($p['username']);
        echo <<<eot
<meta http-equiv="Refresh" content="30"/>
  <div id="tt">Status</div> 
 
  <div id="main"> 
 
  <form action="$web_root/status" method="get"> 
   <input type="hidden" name="contest_id" value="{$p['contest_id']}" /> 
   <strong>Search: </strong>
   <strong>Problem ID</strong> <input size="6" name="problem_id" value="{$p['problem_id']}"/>
   <strong>Username</strong> <input size="12" name="username" value="{$username}"/>
   <strong>Result</strong> 
    <select size="1" name="result" > 
    $result_opt
   </select>
   <strong>Language</strong> <select size="1" name="language" > 
    $language_opt
   </select>&nbsp;
   <input type="submit" value="Go" width="8" /> 
        <input type="button" onclick="javascript:window.location = '$web_root/status';" value="Cancel"/>
  </form> 
  <br/> 
 
  <table><tbody> 
  <tr> 
    <th width="70">Run ID</th> 
    <th width="155">User</th> 
    <th width="75">Problem</th> 
    <th width="200">Result</th> 
    <th width="70">Memory</th> 
    <th width="60">Time</th> 
    <th width="85">Language</th> 
    <th width="75">Length</th> 
    <th width="160">Submit Time</th> 
  </tr> 
eot;
        $i = 0;
        foreach ($p['status'] as $line)
        {
            $i++;
            $tr_class       = $i & 1 ? 'tro' : 'tre';
            $username       = htmlspecialchars($line['username']);
            $problem_id     = (int)$line['problem_id'];
            $result         = $line['result'];
            $result_name    = htmlspecialchars(land_conf::$result_name[$result]);
            $result_color   = land_conf::$result_color[$result];
            $lang           = $p['lang'][$line['lang']];
            $lang           = "<a href=\"source?source_id={$line['source_id']}\">$lang</a>";
            echo <<<eot
   <tr class="$tr_class"> 
    <td style="text-align:center;">{$line['source_id']}</td> 
    <td style="text-align:center;"><a href="$web_root/user/detail?username={$username}">$username</a></td> 
    <td style="text-align:center;"><a href="$web_root/problem/detail?problem_id={$problem_id}">{$problem_id}</a></td> 
    <td style="text-align:center;"> 
       <span class="STYLE7"><a href="$web_root/source/info?source_id={$line['source_id']}"><font color="$result_color">$result_name</font></a></span> 
    </td> 
	<td style="text-align:center;">{$line['memory_usage']}</td> 
    <td style="text-align:center;">{$line['time_usage']}</td> 
    
    <td style="text-align:center;"> 
     <!--Authenticate whether the access to source is valid	--> 
        $lang
    </td> 
	<td style="text-align:center;">{$line['length']}</td> 
    <td style="text-align:center;">{$line['submit_time']}</td> 
   </tr> 
eot;
        }

        $page = $p['page'];
        $last_page = $page - 1;
        $next_page = $page + 1;
        $arr_query = array(
            'contest_id'    => $p['contest_id'],
            'problem_id'    => $p['problem_id'],
            'username'    => $p['username'],
            'language'    => $p['language'],
            'result'    => $p['result'],
            );
        $query = http_build_query($arr_query);

        echo <<<eot
  </tbody></table> 
 
  <br /> 
  <div> 
       <span class="bt"><a href="$web_root/status?page=1&$query">Top</a></span> 
       <span class="bt"><a href="$web_root/status?page=$last_page&$query">Previous Page</a></span> 
       <span class="bt"><a href="$web_root/status?page=$next_page&$query">Next Page</a></span> 
  </div> 
  <br/>
eot;
        return true;
    }
}

?>
