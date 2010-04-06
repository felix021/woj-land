<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root   = land_conf::$web_root;
        $source     = $p['source'];
        $language   = land_conf::$lang[$source['lang']];
        $result     = land_conf::$result_name[$source['result']];
        $username   = htmlspecialchars($source['username']);

        $code = htmlspecialchars($source['source_code']);
        $code = str_replace("\r\n", "\n", $code);
        $code = str_replace("\r", "\n", $code);
        $code = str_replace("\n", "<br/>", $code);
        $code = str_replace("  ", "&nbsp; ", $code);
        $code = str_replace("\t", "&nbsp; &nbsp; ", $code);

        echo <<<eot

    <link href="$web_root/css/codeh.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="$web_root/js/chcommon.js"></script>
    <script type="text/javascript" src="$web_root/js/codeh.js"></script>

    <div id="tt">Source - {$source['source_id']}</div> 
    <div class="ifm"> 
    <strong>Problem id</strong>: {$source['problem_id']}&nbsp;&nbsp;<strong>Username</strong>: {$username}<br /> 
    <strong>Memory</strong>: {$source['memory_usage']}KB&nbsp;&nbsp;<strong>Time</strong>: {$source['time_usage']}ms<br /> 
    <strong>Language</strong>: {$language}&nbsp;&nbsp;<strong>Result</strong>: {$result}<br /> 
    </div> 
 
    <div id="main"> 
    <div class="ptt">Code</div> 
    <div class="code" id="code">$code</div> 
    </div> 

    <script language="javascript">
    var src = $('code').innerHTML;
    var language = '$language';
    var lang_maybe = guess_lang({$source['lang']}, src);
    if (lang_maybe > 0) language = lang_names[lang_maybe];
    CodeHilight('code', language);
    </script>
eot;
        return true;
    }
}

?>
