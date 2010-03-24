<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $language = '';
        $do_share = $p['share_code'] == 1 ? "checked" : "";
        foreach ($p['lang'] as $k => $v)
        {
            $sel = ($k == $p['preferred_lang']) ? "selected " : "";
            $v = htmlspecialchars($v);
            $language .= "<option $sel value=\"$k\">&nbsp;$v&nbsp;</option>\n";
        }
 
        echo '<div id="tt">Submit</div>';

        if (!session::$is_login)
        {
            $anonymous = htmlspecialchars($p['anonymous_name']);
            echo <<<eot
<br/>
<span class="ntc">You haven't <a href="{$web_root}/user/login">login</a> yet, but you can still submit as user '$anonymous'</span>
eot;
        }
        echo <<<eot

<script language="javascript">
function fillSubmitForm()
{
    var source = $('source').value;
    if (source.length < 10)
    {
        alert("your source code is too short...");
        return;
    }
    else if (source.length > 65536)
    {
        alert("your source code is too long (>64k)...");
        return;
    }
    var problem_id = $('problem_id').value;
    if (problem_id < 4)
    {
        alert('please input a valid problem_id...');
        return;
    }
    var submit_btn = $('submit_btn');
    submit_btn.click();
}
</script>
  <div id="main"> 
    <form action="{$web_root}/submit/do_submit" method="post"> 
    <table><tbody> 
      <tr> 
        <th width="80"></th> 
        <th colspan="2">
            Paste your source code here</th> 
        <th width="80"></th> 
      </tr> 

      <tr class="tre"> 
        <td></td> 
        <td align="right"><strong>Problem ID</strong></td> 
        <td align="left"><input style="padding:2px" id="problem_id" maxLength="5" size="10" name="problem_id" value="{$p['problem_id']}" /></td> 
        <td></td> 
      </tr> 
      <tr class="tro"> 
        <td></td> 
        <td align="right"><strong>Language</strong></td> 
        <td align="left"> 
          <select id="lang" size="1" name="lang"> 
            $language
          </select> 
        </td> 
        <td></td> 
      </tr> 
      <tr class="tre"> 
        <td></td> 
        <td align="right"></strong></td> 
        <td align="left"> 
            <input type="checkbox" value="1" name="share code" $do_share/>
            I'd like to share this code
        </td> 
        <td></td> 
      </tr> 
      <tr class="tro" valign="top"> 
        <td></td> 
        <td align="right"><strong>Source</strong></td> 
        <td align="left"><textarea id="source" name="source" rows="20" cols="80"></textarea></td> 
        <td></td> 
      </tr> 
      <tr class="tre"> 
        <td></td> 
        <td></td> 
        <td>
            <input type="button" value="Submit" onclick="javascript:fillSubmitForm();"/>
            <input type="submit" id="submit_btn" style="display:none;"/>
            <input type="reset" value="Reset" />
        </td> 
        <td></td> 
      </tr> 
    </tbody></table> 
    </form> 
  </div> 
eot;
        return true;
    }
}

?>
