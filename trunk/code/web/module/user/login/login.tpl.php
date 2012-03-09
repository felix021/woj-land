<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $last_url = htmlspecialchars($p['last_url']);
        echo <<<eot
  <div id="tt"> 
    Login
  </div> 
  
  <div id="main"> 
eot;

        if (isset($p['need_login']))
        {
            echo <<<eot
    <span class="cl">Please Login First!</span> <br /><br /> 
eot;
        }

        echo <<<eot
<script language="javascript">
function fillLoginForm()
{
    $('seed').value = LoadURLSync("POST", "$web_root/ajax/vcode", '');
    var password    = $('password');
    if (password.value == '')
    {
        alert("Please type in your password..");
        password.focus();
        return false;
    }
    var passEnc     = $('passEnc');
    var seed        = $('seed');
    passEnc.value   = encodePass(password.value, seed.value);
    password.value  = '';
    return true;
}
</script>
    
    <form name="loginform" action="{$this->web_root}/user/do_login" method="post" onsubmit="javascript:return fillLoginForm();"> 
      <input type="hidden" name="origURL" value="$last_url" /> 
      <input type="hidden" name="passEnc" id="passEnc" value="" /> 
      <input type="hidden" name="seed" id="seed" value="{$p['seed']}" /> 
      <table>
        <tbody> 
        <tr class="tre"> 
          <td width="400" align="right"><strong>Username</strong></td> 
          <td align="left"><input name="username" tabIndex="1" value="" size="20" maxlength="150" /></td> 
        </tr> 
        <tr class="tro"> 
          <td align="right"><strong>Password</strong></td> 
          <td align="left"><input name="password" type="password" tabIndex="2" value="" size="20" maxLength="150" id="password"/></td> 
        </tr> 
        <tr class="tre"> 
          <td colspan="2" align="center"> 
            <input type="submit" tabIndex="4" value="Login" id="submit_btn"/>
            <input tabIndex="5" type="reset" value="Reset"/> 
          </td> 
        </tr> 
      </tbody></table> 
    </form> 
  </div> 
eot;
    }
}

?>
