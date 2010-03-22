<?php

class header extends ctemplate
{
    public function display()
    {
        echo <<<eot
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <title>HomePage of Wuhan Univ. Online Judge</title>    
    <link href="./style/noah.css" rel="stylesheet" type="text/css" /> 
</head> 
<body> 
<center> 
<div id="bar"> 
<a href=".">Home</a> | 

eot;
        if (session::$is_login)
        {
            echo '<a href="user/logout">Logout</a> | ';
        }
        else
        {
            echo '<a href="user/login">Login</a> | ';
        }
        echo <<<eot

<a href="problems/volume">Problems</a> | 
<a href="contest/list">Contests</a> | 
<a href="submit/submit">Submit</a> | 
<a href="status">Status</a> | 
<a href="ranklisk">Ranklist</a> | 
<a href="user/register">Register</a> | 
<a href="mail/list">Mail</a> | 
<a href="faq.html" target="_blank">FAQ</a> 
</div> 

eot;
    }
}

?>
