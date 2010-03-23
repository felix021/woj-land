<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $errmsg = htmlspecialchars($p['errmsg']);
        if (empty($errmsg))
        {
            $errmsg = "System is busy, please try again later :)";
        }
        echo <<<eot
<div id="tt">Ooooops!</div> 
<div id="main">
<p><span class="ntc" style="font-size:14px;">$errmsg</span></p>

eot;
        if (isset($p['links']) && is_array($p['links']) && count($p['links']) > 0)
        {
            $first = true;
            echo "<span class=\"ptx\" style=\"text-align:center\">\n";
            foreach ($p['links'] as $k => $v)
            {
                if ($first) $first = !$first;
                else echo " | \n";
                $k = htmlspecialchars($k);
                echo <<<eot
<a href="$v">$k</a>

eot;
            }
            echo '</span>';
        }
        echo "\n</div>\n";
    }
}

?>
