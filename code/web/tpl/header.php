<?php

class header implements itemplate
{
    public function display($p)
    {
        $nav0 = "";
        $nav1 = "";
        $nav2 = "";
        $mail_color = '';
        $web_root = land_conf::$web_root;
        if (session::$is_login)
        {
            if (is_array(session::$priv) && session::$priv['admin'] == 1)
            {
                $nav0 = '<a href="' . $web_root . '/admin">Admin</a> | ';
            }
            
            if (session::$n_unread > 0)
            {
                $mail_color = 'style="color:red;"';
            }

            $nav1 = '<a href="' . $web_root . '/user/logout">Logout</a> | ';
            $nav2 = '<a href="' . $web_root . '/user/setting">Setting</a> | ';
        }
        else
        {
            $nav1 =  '<a href="' . $web_root . '/user/login">Login</a> | ';
            $nav2 = '<a href="' . $web_root . '/user/register">Register</a> | ';
        }
        echo <<<eot
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <title>HomePage of Wuhan Univ. Online Judge</title>    
    <link href="{$web_root}/css/noah.css" rel="stylesheet" type="text/css"/>
    <script src="{$web_root}/js/common.js" language="javascript"></script> 
    <script src="{$web_root}/js/md5-min.js" language="javascript"></script> 
</head> 
<body> 
<center> 
<div id="bar"> 
<a href="$web_root">Home</a> | 
$nav0
$nav1
<a href="$web_root/problem/volume">Problems</a> | 
<a href="$web_root/contest/list">Contests</a> | 
<!-- TODO <a href="$web_root/vcontest/list">vContests</a> | -->
<a href="$web_root/submit/submit">Submit</a> | 
<a href="$web_root/status">Status</a> | 
<a href="$web_root/ranklist">Ranklist</a> | 
$nav2
<a href="$web_root/mail/inbox" $mail_color>Mail</a> | 
<a href="$web_root/faq.html" target="_blank">FAQ</a> 
</div> 


eot;

        $notice = cache_util::load('notice');
        if (strlen($notice->notice) > 0)
        {
            $notice = htmlspecialchars($notice->notice);
            echo <<<eot
 <div class="ntc" id="head_ntc"> Notice: $notice </div> 
eot;
        }
    }
}

?>
