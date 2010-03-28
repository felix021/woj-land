<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $last_url = htmlspecialchars($p['last_url']);
        echo <<<eot
  <div id="tt"> 
    Login
  </div> 
  
  <div id="main"> 
<script language="javascript">

function fillLoginForm()
{
    var password    = $('password');
    //alert(hex_md5(password.value));
    var passEnc     = $('passEnc');
    var seed        = $('seed');
    passEnc.value   = encodePass(password.value, seed.value);
    password.value  = '';
    var submit_btn  = $('submit_btn');
    submit_btn.click();
}

function checkEnter(key)
{
    if (key == 13 || key == 10)
        fillLoginForm();
}
</script>
    
    <form name="loginform" action="{$this->web_root}/user/do_login" method="post" onkeypress="javascript:key_event(event, checkEnter)"> 
      <input type="hidden" name="origURL" value="$last_url" /> 
      <input type="hidden" name="passEnc" id="passEnc" value="" /> 
      <input type="hidden" name="seed" id="seed" value="{$p['seed']}" /> 
      <table>
        <tbody> 
        <tr class="tro"> 
          <td width="400" align="right"><strong>Username</strong></td> 
          <td align="left"><input name="username" tabIndex="1" value="" size="20" maxlength="150" /></td> 
        </tr> 
        <tr class="tre"> 
          <td align="right"><strong>Password</strong></td> 
          <td align="left"><input name="password" type="password" tabIndex="2" value="" size="20" maxLength="150" id="password"/></td> 
        </tr> 
        <tr class="tro"> 
          <td colspan="2" align="center"> 
            <input tabIndex="4" type="button" value="Login" name="doLogin" onclick="javascript:fillLoginForm();"/> 
            <input tabIndex="5" type="submit" value="Cancel" name="doCancel" /> 
            <input type="submit" id="submit_btn" style="display:none;"/>
          </td> 
        </tr> 
      </tbody></table> 
    </form> 
  </div> 
eot;
    }
}

?>
