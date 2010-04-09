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
    <tr class="tre"><td><a href="$web_root/contest/add">Add a new contest</a></td></tr> 
    <tr class="tro"><td><a href="$web_root/submit/admin">Submit in Admin's Home</a></td></tr> 
    <tr class="tre"><td><a href="$web_root/status/admin">See the status in Admin's Home</a></td></tr> 
    <tr class="tro"><td><a href="$web_root/upload">Upload Files</a></td></tr> 
    <tr class="tre"><td><a href="$web_root/user/admin">User Management</a></td></tr> 
    <tr class="tro"><td><a href="$web_root/notice">Set Notice</a></td></tr> 
    </tbody></table> 
  </div> 
<br/>
eot;
        return true;
    }
}

?>
