<?php

require_once(CONF_ROOT . '/score.cfg.php');

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $score = array(
            score_conf::EASY_SCORE,
            score_conf::MEDIUM_SCORE,
            score_conf::DIFFICULT_SCORE,
        );
        $score_limit = array(
            score_conf::EASY_LIMIT,
            score_conf::MEDIUM_LIMIT,
            score_conf::DIFFICULT_LIMIT,
            );
        echo <<<eot
  <div id="tt"> C语言上机训练 </div> 
 
  <div id="main" align="left"> 
	<div id="right"> 
		<div class="hpt">Upcoming Contest</div> 
		<div class="hpb"> 
		<a href="contest/list"><strong>Refer to the contest page.</strong></a> 
		</div> 
		
		<div class="hpt">最勤奋Coder！</div> 
		<div class="hpb"> 
            Yesterday: {$p['diligent']->day}<br /> 
            Last Week: {$p['diligent']->week}<br /> 
            Last Month: {$p['diligent']->month}
		</div> 
 
		<div class="hpt">友情链接</div> 
		<div class="hpb"> 
		<div class="ir"><a href="http://bbs.whu.edu.cn/bbsdoc.php?board=ACM_ICPC" target=_blank>ACM/ICPC Board of BBS in Wuhan Univ.</a></div> 
		<div class="ir"><a href="http://acm.pku.edu.cn/JudgeOnline/" target=_blank>OnlineJudge of PeKing Univ.</a></div> 
		<div class="ir"><a href="http://acm.zju.edu.cn/" target=_blank>OnlineJudge of ZheJiang Univ.</a></div> 
		<div class="ir"><a href="http://acm.scu.edu.cn/" target=_blank>OnlineJudge of SiChuan Univ.</a></div> 
		</div> 
	</div> 
	
	<div id="left"> 
		<div class="hpt">使用说明</div> 
		<div class="hpb"> 
        <p>&nbsp; &nbsp; 使用手册下载：[<a href="upload/manual.doc">WOJ使用指南</a>] 。</p>
        <p>&nbsp; &nbsp; 多做点题，做完以后去找 [<a href="status?username=answer">answer</a>] 的代码对照学习。</p>
        <p>&nbsp; &nbsp; 关于本系统更具体的问题，请参考 [<a href="faq">FAQ</a>] 。</p>
    </div> 
 
		<div class="hpt">最新消息</div> 
		<div class="hpb"> 
    <div class="news"><span class="newst">Mar 7<sup>th</sup>, 2012:</span> C语言上机训练系统启用。</div>
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
