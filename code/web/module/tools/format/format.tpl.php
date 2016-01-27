<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root   = land_conf::$web_root;
        $source     = isset($p['source']) ? $p['source'] : '';
        $language   = land_conf::$lang[$source['lang']];
        $code = htmlspecialchars($source);
        if (!empty($code)) {
            $code = str_replace("\n", "<br/>", $code);
            $code = str_replace("  ", "&nbsp; ", $code);
            $code = str_replace("\t", "&nbsp; &nbsp; ", $code);
            echo <<<eot

    <link href="$web_root/css/codeh.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="$web_root/js/chcommon.js"></script>
    <script type="text/javascript" src="$web_root/js/codeh.js"></script>

    <div id="tt">Source from You</div> 
    <div id="main"> 
    <div class="ptt">Code</div> 
    <div class="code" id="code">$code</div> 
    </div> 

    <script language="javascript">
    var src = $('code').innerHTML;
    var language = '$language';
    var lang_maybe = guess_lang("1", src);
    if (lang_maybe > 0) language = lang_names[lang_maybe];
    CodeHilight('code', language);
    </script>
eot;
        }
        else
        {
            echo <<<eot
    <div id="tt">粘贴并对代码排版</div> 
<form method="POST">
<p><textarea rows="30" cols="120" id="source" name="source"></textarea></p>
<p><input type="submit" value="提交"/></p>
</form>
<script type="text/javascript">
    window.onload = function() {
        $('source').focus();
    }
</script>
eot;
        }
        return true;
    }
}

?>
