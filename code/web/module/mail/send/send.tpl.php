<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root   = land_conf::$web_root;
        $t_un       = isset($p['to_username']) ? htmlspecialchars($p['to_username']) : '';
        $title      = isset($p['title']) ? htmlspecialchars($p['title']) : '';
        $content    = isset($p['content']) ? htmlspecialchars($p['content']) : '';
        echo <<<eot
<div id="tt">Send Mail</div> 

<script language="javascript">
function doFocus()
{
    var ct = $('content');
    if (ct.value.length > 0)
    {
        ct.focus();
    }
    else
    {
        $('t_un').focus();
    }
}

function fillSendForm()
{
    var t_un = $('t_un');
    if (t_un.value.length == 0)
    {
        alert("Please type in the receiver's name");
        t_un.focus();
        return false;
    }

    var title = $('title');
    if (title.value.length == 0)
    {
        alert('Please input the title of your mail.');
        title.focus();
        return false;
    }
    if (title.value.length > 100)
    {
        alert('The title is tooooo long ( > 100 characters).');
        title.focus();
        return false;
    }

    var ct = $('content');
    if (ct.value.length == 0)
    {
        alert('Please input the content of your mail.');
        ct.focus();
        return false;
    }
    if (ct.value.length > 65536)
    {
        alert('Your mail is tooooo long (>64K).');
        ct.focus();
        return false;
    }

    return true;
}
</script>
<div id="main"> 
    <form action="$web_root/mail/send" method="post" onsubmit="javascript:return fillSendForm();">  
        <table><tbody> 
            <tr class="tro"> 
                <td width="80"></td> 
                <td width="100" align="right"><strong>To&nbsp;&nbsp;</strong></td> 
                <td width="700" align="left" style="padding-left:5px;"><input size="15" name="to_username" id="t_un" value="{$t_un}" tabindex="1"/> (Type in receiver's name here) </td> 
                <td width="70"></td> 
            </tr> 
            <tr class="tre"> 
                <td></td> 
                <td align="right"><strong>Title&nbsp;&nbsp;</strong></td> 
                <td align="left" style="padding-left:5px;"><input size="80" name="title" id="title" value="{$title}" tabindex="2"/></td> 
                <td></td> 
            </tr> 
            <tr class="tro"> 
                <td></td> 
                <td align="right" valign="top"><strong>Content:&nbsp;&nbsp;</strong></td> 
                <td align="left" style="padding-left:5px;"><textarea id="content" name="content" rows="20" cols="80" tabindex="3">{$content}</textarea></td> 
                <td></td> 
            </tr> 
            <tr class="tre"> 
                <td></td> 
                <td></td> 
                <td><input type="submit" value="Send" tabindex="4"/> <input type="reset" value="Reset" tabindex="5"/></td> 
                <td></td> 
            </tr> 
        </tbody></table> 
    </form> 
</div> 
<script language="javascript">doFocus();</script>
eot;
        return true;
    }
}

?>
