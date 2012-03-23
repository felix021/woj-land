<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $info = htmlspecialchars($p['info']);
        $extra_info = htmlspecialchars($p['extra_info']);
        if (empty($extra_info))
        {
            $extra_info = 'No more infomation available.';
        }
        $source_code = htmlspecialchars(str_replace("\r", "", $p['source_code']));
        $code = explode("\n", $source_code);
        $source = "<table><tr><td width='40'></td><td></td></tr>\n";
        $i = 0;
        foreach ($code as $line)
        {
            $i++;
            $lineno = sprintf("%04d", $i);
            $source .= "<tr><td class=\"line\">$lineno</td>"
                    .  "<td style='white-space:pre;'>$line</td></tr>\n";
        }
        $source .= "</table>";

        $user_source = "";
        if (is_admin() || $p['user_id'] != session::ANONYMOUS_ID)
            $user_source = <<<eot
<div class="ptt">Source Code</div> 
<div class="code" id="codes">$source</div>
eot;

        echo <<<eot
<style> td.line { color:#666; } </style>
<div id="main"> 
<br /> 
<div> 
<span class="cl">$info</span> 
</div> 
<br /> 
<div class="ptt">Information</div> 
<div class="code"><pre>$extra_info</pre></div> 
$user_source
</div> 
eot;
        return true;
    }
}

?>
