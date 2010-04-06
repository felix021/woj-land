<?php

class TPL_mailbox extends ctemplate
{
    protected $box_name         = '';
    protected $to_from          = '';
    protected $to_from_param    = '';

    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $un = htmlspecialchars($p['username']);
        echo <<<eot
<div id="tt"><b>$un</b>'s {$this->box_name}</div> 

<div id="main"> 
<p>
    <span class="bt"><a href="$web_root/mail/send">Send mail</a></span> &nbsp;
    <span class="bt"><a href="$web_root/mail/inbox">Inbox</a></span> &nbsp;
    <span class="bt"><a href="$web_root/mail/outbox">Outbox</a></span> &nbsp;
</p>

<script>
function confirmDel()
{
    return confirm("Are you sure to delete this mail?");
}
</script>

    <table> <tbody> 
        <tr> 
            <th width="40">No.</th> 
            <th width="150">{$this->to_from}</th> 
            <th width="500">Title</th> 
            <th width="150">Date</th> 
            <th width="100">Operation</th> 
        </tr> 
eot;

        $i = ($p['page'] - 1) * land_conf::MAILS_PER_PAGE;
        foreach ($p['mails'] as $mail)
        {
            $username   = htmlspecialchars($mail[$this->to_from_param]);
            $username_e = urlencode($username);
            $title = htmlspecialchars($mail['title']);
            $tr_class = $i++ & 1 ? 'tre' : 'tro';
            $bgcolor = $mail['unread'] ? 'bgcolor="#ffff7f"' : '';
            echo <<<eot
        <tr class="$tr_class"> 
            <td align="center"><a href="$web_root/mail/detail?mail_id={$mail['mail_id']}">$i</a></td> 
            <td align="center"><a href="$web_root/user/detail?username={$username}">$username</a></td> 
            <td align="center" $bgcolor><a href="$web_root/mail/detail?mail_id={$mail['mail_id']}">$title</a> </td>
            <td align="center">{$mail['send_time']}</td> 
            <td align="center"><a href="$web_root/mail/delete?mail_id={$mail['mail_id']}" onclick="javascript:return confirmDel()">Delete</a></td> 
        </tr>
eot;
        }

        $page = (int)$p['page'];
        $prev = $page > 2 ? $page - 1 : 1;
        $next = $page + 1;
        echo <<<eot
        </tbody>
    </table> 
    <br /> 
    <span class="bt"><a href="$web_root/mail/inbox">&nbsp;TOP&nbsp;</a></span> &nbsp;
    <span class="bt"><a href="$web_root/mail/inbox?page=$prev">&nbsp;Prev&nbsp;</a></span> &nbsp;
    <span class="bt"><a href="$web_root/mail/inbox?page=$next">&nbsp;Next&nbsp;</a></span> 
    <br /><br /> 
</div> 
eot;
        return true;
    }
}

?>
