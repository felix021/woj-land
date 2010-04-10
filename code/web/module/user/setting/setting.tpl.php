<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $user           = $p['user'];
        $username       = htmlspecialchars($user['username']);
        $nickname       = htmlspecialchars($user['nickname']);
        $school         = htmlspecialchars($user['school']);
        $email          = htmlspecialchars($user['email']);
        $checked        = $user['share_code'] ? 'checked' : '';
        echo <<<eot
  <div id="tt">Modify Your Information</div> 
<script language="javascript">
function fillSettingForm()
{
    var password    = $('password');
    if (password.value == '')
    {
        alert("Please type in your password..");
        password.focus();
        return false;
    }
    var passEnc         = $('passEnc');
    var seed            = $('seed');
    passEnc.value = encodePass(password.value, seed.value);

    var new_password    = $('new_password');
    var new_passEnc     = $('new_passEnc');
    var repeatpassword  = $('repeatpassword');
    if (new_password.value != '')
    {
        if (new_password.value != repeatpassword.value)
        {
            alert('New passwords do not match..');
            repeatpassword.focus();
            return false;
        }
        new_passEnc.value    = hex_md5(new_password.value);
    }

    password.value       = '';
    new_password.value   = '';
    repeatpassword.value = '';

    return true;
}

</script>
   
  <div id="main"> 
    <div><span class="ntc">Notice: Just leave new password fields empty if you wanna keep it unchanged.</span> </div>
    <br/>
    <form action="{$this->web_root}/user/setting" method="post" onsubmit="return fillSettingForm();">
    <input type="hidden" name="passEnc" id="passEnc"/>
    <input type="hidden" name="seed" id="seed" value="{$p['seed']}"/>
    <input type="hidden" name="new_passEnc" id="new_passEnc"/>
    <table><tbody> 
      <tr class="tre"> 
        <td width="400" align="right"><strong>Username</strong></td> 
        <td align="left">$username</td>
      </tr> 
      <tr class="tro"> 
        <td width="400" align="right"><strong>*Password</strong></td> 
        <td align="left"><input size="20" type="password" name="password" id="password" tabindex="1"/></td> 
      </tr> 
      <tr class="tre"> 
        <td align="right"><strong>New Password</strong></td> 
        <td align="left"><input size="20" type="password" name="new_password" id="new_password" tabindex="2"/></td> 
      </tr> 
      <tr class="tro"> 
        <td align="right"><strong>Confirm Password</strong></td> 
        <td align="left"><input size="20" type="password" name="repeatpassword" id="repeatpassword" tabindex="3"/></td> 
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
        <td align="left"><input size="40" value="1" type="checkbox" name="share_code" $checked tabindex="7"/> I'd like to share my code with others</td> 
      </tr> 
      <tr class="tro"> 
        <td colspan="2" align="center"> 
        <input type="submit" id="submit_btn" value="Submit" tabindex="8"/>
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
