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
 
        echo <<<eot
<div id="tt">Submit</div>

  <div id="main"> 

eot;

        if (!session::$is_login)
        {
            $anonymous = htmlspecialchars($p['anonymous_name']);
            echo <<<eot
<p><span class="ntc" style="font-size:14px;">You haven't <a href="{$web_root}/user/login">login</a> yet, but you can still submit your code as user '$anonymous'</span></p>
eot;
        }
        echo <<<eot

<script language="javascript">


function fillSubmitForm()
{
    var lang_names = ['Unknown', 'C', 'C++', 'Java', 'Pascal'];
    var source = $('source');
    if (source.value.length < {$p['min_len']})
    {
        alert("your source code is too short...");
        source.focus();
        return false;
    }
    else if (source.value.length > {$p['max_len']})
    {
        alert("your source code is too long (>64k)...");
        source.focus();
        return false;
    }
    var problem_id = $('problem_id');
    if (problem_id.value.length < 4)
    {
        alert('please input a valid problem_id...');
        problem_id.focus();
        return false;
    }
    //> <script language="javascript">
    var lang        = $('lang').value;
    var lang_maybe  = guess_lang(source.value);
    var pmt         = '';

    if (lang_maybe > 0 && lang_maybe != lang)
    {
        pmt = 'Your source seems to be a *' + lang_names[lang_maybe]
            + '* program, but you choosed *' + lang_names[lang] 
            + '*. Do you really want to submit?';
    }
    else if (lang_maybe == 0)
    {
        pmt = 'The language of your source seems not to be supported by land, '
            + 'do you still want to submit?';
    }

    if (pmt != '')
    {
        if (confirm(pmt))
        {
            return true;
        }
        else
        {
            $('lang').focus();
            return false;
        }
    }

    return true;
}

function ctrl_enter(evt)
{
    evt = evt ? evt : window.event;
    key = evt.which ? evt.which : evt.keyCode;
    if (evt.ctrlKey && (key == 13 || key == 10))
    {
        $('submit_btn').click();
    }
}

function guess_lang(src)
{
    var lang_maybe  = -1;
    if (src.indexOf('#include') >= 0 || src.indexOf('int main') >= 0)
    { //C || C++
        lang_maybe = 2;
        if (src.indexOf('iostream') >= 0 || src.indexOf('namespace') >= 0) //C++
            lang_maybe = 2;
        else  //C
        {
            lang_maybe = 1;
            if (lang == 2)
                lang_maybe = 2; //C++兼容C
        }
            
    }
    else if (src.indexOf('java') > 0 || src.indexOf('System.out') >= 0 
            || src.indexOf('public class') >= 0)
    { //Java
        lang_maybe = 3;
    }
    else if ((/\bbegin\b/i).test(src) && (/\bend\b/i).test(src))
    { //pascal
        lang_maybe = 4;
    }
    else
    { //unknown
        lang_maybe = 0;
    }
    return lang_maybe;
}

function change_lang()
{
    var lang = $('lang');
    var lang_maybe = guess_lang($('source').value);
    if (lang_maybe > 0)
    {
        lang.value = lang_maybe;
    }
}
</script>
    <form action="{$web_root}/submit/do_submit" method="post"  onkeypress="javascript:ctrl_enter(event);" onsubmit="javascript:return fillSubmitForm();"> 
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
        <td align="left"><input style="padding:2px" id="problem_id" tabindex="3" maxLength="5" size="10" name="problem_id" value="{$p['problem_id']}" /></td> 
        <td></td> 
      </tr> 
      <tr class="tro"> 
        <td></td> 
        <td align="right"><strong>Language</strong></td> 
        <td align="left"> 
          <select id="lang" size="1" name="lang" tabindex="4"> 
            $language
          </select> 
        </td> 
        <td></td> 
      </tr> 
      <tr class="tre"> 
        <td></td> 
        <td align="right"></strong></td> 
        <td align="left"> 
            <input type="checkbox" value="1" name="share code" tabindex="5" $do_share/>
            I'd like to share this code
        </td> 
        <td></td> 
      </tr> 
      <tr class="tro" valign="top"> 
        <td></td> 
        <td align="right"><br/><strong>Source</strong></td> 
        <td align="left"> *Press Ctrl + Enter to submit directly.<br/><textarea id="source" tabindex="1" name="source" rows="20" cols="80" onblur="javascript:change_lang();"></textarea></td> 
        <td></td> 
      </tr> 
      <tr class="tre"> 
        <td></td> 
        <td></td> 
        <td>
            <input type="submit" value="Submit" id="submit_btn" tabindex="2"/>
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
