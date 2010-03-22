<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        echo <<<eot
  <div id="tt"> Welcome to Land </div> 
 
  <div id="main" align="left"> 
	<div id="right"> 
		<div class="hpt">Upcoming Contest</div> 
		<div class="hpb"> 
		<a href="contest/list"><strong>Refer to the contest page.</strong></a> 
		</div> 
		
		<div class="hpt">The Most Diligent Programmer</div> 
		<div class="hpb"> 
            Yesterday: {$p['diligent']->day}<br /> 
            Last Week: {$p['diligent']->week}<br /> 
            Last Month: {$p['diligent']->month}
		</div> 
		
    
 
		<div class="hpt">Links</div> 
		<div class="hpb"> 
		<div class="ir"><a href="http://bbs.whu.edu.cn/bbsdoc.php?board=ACM_ICPC" target=_blank>ACM/ICPC Board of BBS in Wuhan Univ.</a></div> 
		<div class="ir"><a href="http://acm.pku.edu.cn/JudgeOnline/" target=_blank>OnlineJudge of PeKing Univ.</a></div> 
		<div class="ir"><a href="http://acm.zju.edu.cn/" target=_blank>OnlineJudge of ZheJiang Univ.</a></div> 
		<div class="ir"><a href="http://acm.scu.edu.cn/" target=_blank>OnlineJudge of SiChuan Univ.</a></div> 
		</div> 
	</div> 
	
	<div id="left"> 
		<div class="hpt">Guide for Beginners</div> 
		<div class="hpb"> 
		&nbsp;&nbsp;&nbsp;Choose a problem from <a href="problem/volume">problem sets</a>, 
		then solve it, <a href="submit/submit">submit</a> your code if you are sure that your 
		code is right. Sometimes there is hints after a problem, it will be useful.<br /> 
		<a href="faq.html"><img src="img/faq2.jpg" alt="Frequently Asked Questions" align="right"  /></a> 
    &nbsp;&nbsp;&nbsp;<a href="contest/list">Contests</a> will be hold with a fixed schedule, you can take part in anyone to show yourself.<br /> 
    &nbsp;&nbsp;&nbsp;Read <a href="faq.html">FAQ</a> carefully first when you have any problem on how to use this system, 
    many questions are already solved.<br /> 
    </div> 
 
		<div class="hpt">News</div> 
		<div class="hpb"> 
    <div class="news"><span class="newst">Mar 22<sup>nd</sup>, 2010:</span> Land is coming soon!</div>
    <div class="news"><span class="newst">Mar 2<sup>nd</sup>, 2007:</span> Change noah to a new style.</div> 
    <div class="news"><span class="newst">Jan 5<sup>th</sup>, 2007:</span> Noah v2.0 project started, <a href="mailto:acm@whu.edu.cn?Subject=Suggestion for the Noah v2.0">contact us</a> for any suggestion.</div> 
    
    <div class="news"><span class="newst">Mar 22<sup>nd</sup>, 2006:</span> WHU Online Judge Version 1.0 released</div> 
    </div> 
	</div> 
</div> 
eot;
    }
}

?>
