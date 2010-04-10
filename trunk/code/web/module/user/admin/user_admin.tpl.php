<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $user           = $p['user'];
        $user_id        = (int)$user['user_id'];
        $username       = htmlspecialchars($user['username']);
        $nickname       = htmlspecialchars($user['nickname']);
        $school         = htmlspecialchars($user['school']);
        $email          = htmlspecialchars($user['email']);
        $checked        = $user['share_code'] ? 'checked' : '';
        $arr_group_id   = explode(';', $user['group_ids']);
        $arr_group_id   = array_filter($arr_group_id, create_function('$a', 'return !empty($a);'));
        $group_str      = '<option value="">*No Group*</option>';
        foreach ($p['groups'] as $group)
        {
            $gid    = $group['group_id'];
            $gname  = htmlspecialchars($group['group_name']);
            $sel = '';
            if (in_array($group['group_id'], $arr_group_id))
            {
                $sel = 'selected';
            }
            $group_str .= "<option $sel value=\"{$gid}\">$gname</option>\n";
        }

        echo <<<eot
  <div id="tt">Admin: Modify User's Information</div> 
<script language="javascript">
function fillSettingForm()
{
try{
    var password    = $('password');
    if (password.value != '')
    {
        var passEnc         = $('passEnc');
        passEnc.value       = hex_md5(password.value);
        password.value      = '';
    }
    var gids = $('group_ids');
    var sel_gid = $('select_gid');
    gids.value = '';
    for (var i = 0; i < sel_gid.options.length; i++)
        if (sel_gid.options[i].selected)
            gids.value += '' + sel_gid.options[i].value + ';';
    gids.value = gids.value.replace(/^ *;|; *$/g, '');
}
catch(e){alert(e); return false;}
    return true;
}

</script>
   
  <div id="main"> 
    <form action="{$this->web_root}/user/admin" method="post" onsubmit="return fillSettingForm();">
    <input type="hidden" name="passEnc" id="passEnc"/>
    <input type="hidden" name="seed" id="seed" value="{$p['seed']}"/>
    <input type="hidden" name="user_id" value="{$user_id}"/>
    <input type="hidden" name="group_ids" id="group_ids" value=""/>
    <table><tbody> 
      <tr class="tre"> 
        <td width="400" align="right"><strong>Username</strong></td> 
        <td align="left">&nbsp;$username (Registered at {$p['user']['reg_time']})</td>
      </tr> 
      <tr class="tro"> 
        <td width="400" align="right"><strong>*Password</strong></td> 
        <td align="left"><input size="20" type="password" name="password" id="password" tabindex="1"/> 
            Leave it blank if you don't want to change it.</td> 
      </tr> 
      <tr class="tre"> 
        <td align="right"><strong>Nick Name</strong></td> 
        <td align="left"><input size="40" type="text" name="nick" value="{$nickname}" tabindex="4"/></td> 
      </tr> 
      <tr class="tro"> 
        <td align="right"><strong>School</strong></td> 
        <td align="left"><input size="40" type="text" name="school" value="$school" tabindex="5"/></td> 
      </tr> 
      <tr class="tre"> 
        <td align="right"><strong>Email</strong></td> 
        <td align="left"><input size="40" type="text" name="email" value="$email" tabindex="6"/></td> 
      </tr> 
      <tr class="tro"> 
        <td align="right"></td> 
        <td align="left"><input size="40" value="1" type="checkbox" name="share_code" $checked tabindex="7"/> share code</td> 
      </tr> 
      <tr class="tre"> 
        <td align="right"><strong>Group(Multi Select)</strong></td> 
        <td align="left">
            <select id="select_gid" multiple size="8" tabindex="8" style="width:300px;">
            $group_str
            </select>
        </td> 
      </tr> 
      <tr class="tro"> 
        <td colspan="2" align="center"> 
        <input type="submit" id="submit_btn" value="Submit" tabindex="9"/>
        <input type="reset" value="Reset" name="reset" /> 
        </td> 
      </tr> 
    </tbody></table> 
    </form> 
  </div> 
eot;
    }
}

?>
