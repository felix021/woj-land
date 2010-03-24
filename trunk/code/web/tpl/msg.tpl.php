<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $errmsg = htmlspecialchars($p['msg']);
        if (empty($errmsg))
        {
            $errmsg = "Feels good, doesn't it?";
        }
        echo <<<eot
<div id="tt">Accepted!</div> 
<div id="main">
<p><span class="ntc" style="font-size:14px;">$errmsg</span></p>
<br/>

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
