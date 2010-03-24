<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $errmsg = htmlspecialchars($p['errmsg']);
        if (empty($errmsg))
        {
            $errmsg = "System is busy, please try again later :(";
        }
        echo <<<eot
<div id="tt">Ooooops!</div> 
<div id="main">
<p><span class="cl" style="font-size:16px;">$errmsg</span></p>
<p style="line-height:0px;"><br/></p>

eot;
        if (isset($p['links']) && is_array($p['links']) && count($p['links']) > 0)
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
