<?php

class header implements itemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
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

eot;
        if (session::$is_login)
        {
            echo '<a href="' . $web_root . '/user/logout">Logout</a> | ';
        }
        else
        {
            echo '<a href="' . $web_root . '/user/login">Login</a> | ';
        }
        echo <<<eot

<a href="$web_root/problems/volume">Problems</a> | 
<a href="$web_root/contest/list">Contests</a> | 
<a href="$web_root/submit/submit">Submit</a> | 
<a href="$web_root/status">Status</a> | 
<a href="$web_root/ranklisk">Ranklist</a> | 
<a href="$web_root/user/register">Register</a> | 
<a href="$web_root/mail/list">Mail</a> | 
<a href="$web_root/faq.html" target="_blank">FAQ</a> 
</div> 

eot;
    }
}

?>
