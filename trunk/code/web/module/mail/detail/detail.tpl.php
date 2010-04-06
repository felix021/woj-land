<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $mail = $p['mail'];
        foreach ($mail as &$v) $v = htmlspecialchars($v);
        echo <<<eot
<div id="tt">Read Mail</div> 

<style>
.tname{padding-right:5px;}
.tvalue{padding-left:5px;}
</style>

<div id="main"> 

    <table><tbody> 
            <tr> 
                <th width="80"></th> 
                <th class="tname" width="100" align="right">Title</th> 
                <th class="tvalue" width="700" align="left">{$mail['title']}</th> 
                <th width="70"></th> 
            </tr> 
            <tr class="tre"> 
                <td></td> 
                <td class="tname" align="right"><strong>From</strong></td> 
                <td class="tvalue" align="left">{$mail['from_username']}</td> 
                <td></td> 
            </tr> 
            <tr class="tro"> 
                <td></td> 
                <td class="tname" align="right"><strong>To</strong></td> 
                <td class="tvalue" align="left">{$mail['to_username']}</td> 
                <td></td> 
            </tr> 
            <tr class="tre"> 
                <td></td> 
                <td class="tname" align="right"><strong>Send Time</strong></td> 
                <td class="tvalue" align="left">{$mail['send_time']}</td> 
                <td></td> 
            </tr> 
            <tr class="tro" valign="top"> 
                <td></td> 
                <td class="tname" align="right"><strong>Content</strong></td> 
                <td class="tvalue" align="left"><textarea readonly name="content" rows="20" cols="80">{$mail['content']}</textarea></td> 
                <td></td> 
            </tr> 
    </tbody></table> 

    <br /> 
    <span class="bt"><a href="javascript:history.back(1)">Return</a></span>&nbsp;&nbsp;
eot;
        if (!$p['out_mail'])
        {
            echo <<<eot
    <span class="bt"><a href="$web_root/mail/send?rep_mail_id={$mail['mail_id']}">Reply</a></span>&nbsp;&nbsp;
eot;
        }
        echo <<<eot
    <span class="bt"><a href="$web_root/mail/delete?mail_id={$mail['mail_id']}" onclick="javascript:return confirm('Are you sure to delete this mail?');">Delete</a></span> 
    <br /><br /> 
</div> 
eot;
        return true;
    }
}

?>
