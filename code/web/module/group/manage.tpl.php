<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $groups = $p['groups'];
        echo <<<eot
  <div id="tt">Manage Groups</div> 

<script language="javascript">
var seed = '{$p['seed']}';

function delGroup(gid, gname)
{
try{
    if (!confirm('Are you sure to delete group "' + gname + '" ?'))
        return;

    var url = '$web_root/group/del';
    var values = 'group_id=' + encodeURIComponent(gid) + '&seed=' + encodeURIComponent(seed);
    LoadURL('POST', url, values, ajax_del);
}
catch(e) {alert(e);}
}

function ajax_del(status, text)
{
    if (status == 200)
    {
        alert(text)
        location.reload();
    }
    else
    {
        alert('Operation failed...');
    }
}
</script>

<style>
td{text-align:center;}
</style>

  <div id="main"> 
  <table><tbody align="left"> 
    <tr class="tro"> 
      <th></th> 
      <th width="50" align="center">ID</th> 
      <th align="center" width="150"><strong>Name</strong></th> 
      <th align="center" width="400"><b>Privileges</b></th> 
      <th align="center" width="150"><b>Operation</b></th> 
      <th></th> 
    </tr> 
eot;
        $i = 0;
        foreach ($p['groups'] as $g)
        {
            $gid    = (int)$g['group_id'];
            $gname  = htmlspecialchars($g['group_name']);
            $tr_class = $i++ & 1 ? 'tro' : 'tre';
            $priv_str = '';
            foreach (land_conf::$priv_fields as $f)
            {
                $checked = $g[$f] == 1 ? 'checked' : '';
                $f = htmlspecialchars($f);
                $priv_str .= "<input type=\"checkbox\" name=\"$f\" value=\"1\" $checked/> $f &nbsp;\n";
            }
            echo <<<eot
    <form action="$web_root/group/update" method="post">
    <tr class="{$tr_class}"> 
      <td><input type="hidden" name="seed" id="seed" value="{$p['seed']}"/></td> 
      <td><input type="hidden" value="$gid" name="group_id"/>$gid</td> 
      <td><input type="text" value="{$gname}" name="group_name"/></td> 
      <td>$priv_str</td>
      <td><input type="submit" value="Update"/> <input type="button" value="Delete" onclick="javascript: delGroup($gid, '$gname');"/></td> 
      <td></td> 
    </tr> 
    </form>
eot;
        }
        $priv_str = '';
        foreach (land_conf::$priv_fields as $f)
        {
            $f = htmlspecialchars($f);
            $priv_str .= "<input type=\"checkbox\" name=\"$f\" value=\"1\"/> $f &nbsp;\n";
        }
        $tr_class = $i++ & 1 ? 'tro' : 'tre';
        echo <<<eot
    <form action="$web_root/group/add" method="post" onsubmit="javascript: return true;">
    <tr class="$tr_class"> 
      <td><input type="hidden" name="seed" id="seed" value="{$p['seed']}"/></td> 
      <td>New</td> 
      <td><input type="text" name="group_name" value=""/></td> 
      <td>$priv_str</td> 
      <td><input type="submit" value="Add"/></td> 
      <td></td> 
    </tr> 
    </form>
  </tbody></table> 
</form> 


  </div> 
eot;
        return true;
    }
}

?>
