<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        echo <<<eot
  <div id="tt">New Account Register</div> 

<script language="javascript">
function fillRegisterForm()
{
    var username        = $('username');
    if (username.value == '')
    {
        alert("Please type in your username..");
        username.focus();
        return false;
    }
    var password        = $('password');
    if (password.value == '')
    {
        alert("Please type in your password..");
        password.focus();
        return false;
    }
    var repeatpassword  = $('repeatpassword');
    var passEnc         = $('passEnc');
    if (password.value != repeatpassword.value)
    {
        alert('Two passwords do not match..');
        repeatpassword.focus();
        return false;
    }
    passEnc.value  = hex_md5(password.value);
    password.value = "";
    repeatpassword.value = "";

    return true;
}
</script>
   
  <div id="main"> 
    <form action="{$this->web_root}/user/do_register" method="post" onsubmit="javascript:return fillRegisterForm();">
    <input type="hidden" name="passEnc" id="passEnc"/>
    <table><tbody> 
      <tr class="tro"> 
        <td width="400" align="right"><strong>Username</strong></td> 
        <td align="left"><input name="username" id="username" type="text" value="" size="20" tabindex="1" /> (less than 20 characters)</td>
      </tr> 
      <tr class="tre"> 
        <td align="right"><strong>Password</strong></td> 
        <td align="left"><input size="20" type="password" name="password" id="password" tabindex="2"/></td> 
      </tr> 
      <tr class="tro"> 
        <td align="right"><strong>Confirm Password</strong></td> 
        <td align="left"><input size="20" type="password" name="repeatpassword" id="repeatpassword" tabindex="3"/></td> 
      </tr> 
      <tr class="tre"> 
        <td align="right"><strong>Nick Name</strong></td> 
        <td align="left"><input size="40" type="text" name="nick"  tabindex="4"/></td> 
      </tr> 
      <tr class="tro"> 
        <td align="right"><strong>School</strong></td> 
        <td align="left"><input size="40" type="text" name="school" tabindex="5"/></td> 
      </tr> 
      <tr class="tre"> 
        <td align="right"><strong>Email</strong></td> 
        <td align="left"><input size="40" type="text" name="email" tabindex="6"/></td> 
      </tr> 
      <tr class="tro"> 
        <td align="right"></td> 
        <td align="left"><input size="40" value="1" type="checkbox" name="share_code" checked tabindex="7"/> I'd like to share my code with others</td> 
      </tr> 
      <tr class="tre"> 
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
