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
                $nav0 = '<a href="' . $web_root . '/admin">管 理</a> | ';
            }
            
            $new_mail = '';
            if (session::$n_unread > 0)
            {
                $mail_color = 'style="color:red;"';
                $new_mail = '('.session::$n_unread.')';
            }

            $nav1 = '<a href="' . $web_root . '/user/logout">注 销</a> | ';
            $nav2 = '<a href="' . $web_root . '/user/setting">设 置</a> | ';
            $nav3 = "<a href=\"$web_root/mail/inbox\" $mail_color>站内信$new_mail</a> | ";
            $nav4 = "<a href=\"$web_root/user/self\">个人信息</a> | ";
        }
        else
        {
            $nav1 =  '<a href="' . $web_root . '/user/login">登 录</a> | ';
            $nav2 = '<a href="' . $web_root . '/user/register">注 册</a> | ';
            $nav3 = ''; 
            $nav4 = '';
        }

        $title = "C语言上机训练系统";
        if (!empty(land_conf::$page_title))
            $title = land_conf::$page_title;
        $title = htmlspecialchars($title);
        echo <<<eot
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <title>$title</title>    
    <link href="{$web_root}/css/noah.css" rel="stylesheet" type="text/css"/>
    <script src="{$web_root}/js/common.js" language="javascript"></script> 
    <script src="{$web_root}/js/md5-min.js" language="javascript"></script> 
    <link title="Search Problems" rel="search"  type="application/opensearchdescription+xml"  href="{$web_root}/problem/opensearch" /> 
</head> 
<body> 
<center> 
<div id="bar"> 
<a href="$web_root">首 页</a> | 
$nav0
$nav1
<a href="$web_root/problem/volume">题目列表</a> | 
<a href="$web_root/contest/list">比赛</a> | 
<!-- <a href="$web_root/vcontest/list">vContests</a> | -->
<a href="$web_root/submit/submit">提 交</a> | 
<a href="$web_root/status">状 态</a> | 
<a href="$web_root/ranklist">排 名</a> | 
$nav4
$nav2
$nav3
<a href="$web_root/faq" target="_blank">FAQ</a> 
</div> 
<div id="tt" style="line-height: 10px;padding:10px;background-color:#ffff00;">
    <a href="upload/manual.doc">使用手册下载</a>
</div> 

eot;

        $notice = cache_util::load('notice');
        if (strlen($notice->notice) > 0)
        {
            $notice = htmlspecialchars($notice->notice);
            echo <<<eot
 <div class="ntc" id="head_ntc" style="font-size: 20px;"> Notice: $notice </div> 
eot;
        }
    }
}

?>
