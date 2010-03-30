<?php

class TPL_Main extends ctemplate
{

    public function display($p)
    {
        if (isset($p['return_url']))
        {
            $t = land_conf::STAY_TIME;
            $url = $p['return_url'];
            header("Refresh: $t; url=$url");
            echo <<<eot
<meta http-equiv="Refresh" content-type="$t; url=$url"/>

eot;
        }
        $msg = htmlspecialchars($p['msg']);
        if (empty($msg))
        {
            $msg = "Feels good, doesn't it?";
        }
        echo <<<eot
<div id="tt">Operation Accepted!</div> 
<div id="main">
<p><span class="ntc" style="font-size:16px;background-color:#f7ffe7">$msg</span></p>
<p style="line-height:0px;"><br/></p>

eot;
        if (isset($p['links']) &&is_array($p['links']) && count($p['links']) > 0)
        {
            echo "<p style=\"text-align:center\">\n";
            foreach ($p['links'] as $k => $v)
            {
                $k = htmlspecialchars($k);
                echo <<<eot
<span class="bt"><a href="$v">$k</a></span>

eot;
            }
            echo '</p>';
        }
        echo "\n</div>\n";
    }
}

?>
