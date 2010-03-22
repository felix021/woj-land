<?php

class footer extends ctemplate
{
    public function display($p)
    {
        echo <<<eot

<div id="ft"> 
<hr width="900" size=0 /> 
Online Judge System of Wuhan Univ. Version 1.0<br /> 
Copyright &copy; 2010 ACM/ICPC Team of Wuhan University. All rights reserved.<br /> 
Please <a href="mailto:acm@whu.edu.cn?Subject=Suggestion of the OnlineJudge" >contact us</a> if you have any suggestion or problem.<br /><br /> 
</div> 
</center> 
</body> 
</html> 
eot;
    }
}

?>
