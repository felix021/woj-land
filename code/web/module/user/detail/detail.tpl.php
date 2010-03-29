<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $user = $p['user'];
        foreach ($user as &$v) $v = htmlspecialchars($v);
        $username = $user['username'];
        $email = str_replace('@', '[#at]', $user['email']);
        $extra_info = '';
        if ($user['user_id'] == session::ANONYMOUS_ID)
            $extra_info = ': This user is used for anonymous access such as submit.';
        echo <<<eot
  <div id="tt"> User Status - {$username} </div> 
 
  <div id="main"> 
    <table><tbody align="left"> 
     <tr> 
      <th width="100"></th> 
      <th colSpan="2">{$username}{$extra_info}</th> 
      <th width="100"></th> 
     </tr> 
     <tr class="tro"> 
      <td></td> 
      <td width="125"><strong>Rank:</strong></td> 
      <td width="625">{$user['rank']}</td> 
      <td></td> 
     </tr> 
     <tr class="tre"> 
      <td></td> 
      <td><strong>Solved:</strong></td> 
      <td>{$user['solved']}</td> 
      <td></td> 
     </tr> 
     <tr class="tro"> 
      <td></td> 
      <td><strong>Submissions:</strong></td> 
      <td>{$user['submit']}</td> 
      <td></td> 
     </tr> 
     <tr class="tre"> 
      <td></td> 
      <td><strong>School:</strong></td> 
      <td>{$user['school']}</td> 
      <td></td> 
     </tr> 
     <tr class="tro"> 
      <td></td> 
      <td><strong>Email:</strong></td> 
      <td>{$email}</td> 
      <td></td> 
     </tr> 
     <tr class="tre"> 
      <td></td> 
      <td><strong>Solved Problem:</strong></td> 
      <td> 
eot;
        $arr_solved = explode("|", $user['solved_list']);
        foreach ($arr_solved as $pid)
        {
            $pid = (int)$pid;
            if ($pid < 1) continue;
            echo <<<eot
        <a href="$web_root/problem/detail?problem_id=$pid">$pid</a> &nbsp;
eot;
        }
        echo <<<eot
      </td> 
      <td></td> 
     </tr> 
    </tbody></table> 
  <br /> 
  <div><span class="bt"><a href="$web_root/ranklist">Back To Ranklist</a></span></div> 
  <br /> 
  </div> 

eot;
        return true;
    }
}

?>
