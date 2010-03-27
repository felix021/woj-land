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
        echo <<<eot
<div id="main"> 
<br /> 
<div> 
<span class="cl">$info</span> 
</div> 
<br /> 
<div class="ptt">Information</div> 
<div class="code"><pre>$extra_info</pre></div> 
</div> 
eot;
        return true;
    }
}

?>
