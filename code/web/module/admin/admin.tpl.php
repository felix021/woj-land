<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        echo <<<eot
<style>td{text-align:center;}</style>
  <div id="tt">Welcome to Noah Admin Home</div> 
  <div id="main"> 
    <table><tbody> 
    <tr><th>Quick Launch</th></tr> 
    <tr class="tro"><td><a href="$web_root/problem/add">Add a new problem</a></td></tr> 
    <tr class="tre">
        <td>
          <form method="get" action="$web_root/files/manage">
            Problem ID: <input type="text" name="problem_id" value="1001" size="10" /> 
            <input type="submit" value="Manage Files"/>
          </form>
        </td>
    </tr> 
    <tr class="tro"><td><a href="$web_root/contest/add">Add a new contest</a></td></tr> 
    <tr class="tre"><td><a href="$web_root/submit/submit?admin">Submit as an administrator</a></td></tr> 
    <tr class="tro"><td><a href="$web_root/status?admin">View admin status</a></td></tr> 
    <tr class="tre">
        <td>
          <form method="get" action="$web_root/user/admin">
            Username: <input type="text" name="username" value="" size="15" /> 
            <input type="submit" value="Edit"/>
          </form>
        </td>
    </tr> 
    <tr class="tro"><td><a href="$web_root/notice">Set Notice</a></td></tr> 
    </tbody></table> 
  </div> 
<br/>
eot;
        return true;
    }
}

?>
