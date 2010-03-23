<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        echo <<<eot
<div id="tt"> Problem Set </div> 
  <div id="main"> 
 
  <table><tbody> 
  <tr> 
    <th width="200"></th> 
    <th width="100">From</th> 
    <th width="350">Problems Volume</th> 
    <th width="100">To</th> 
    <th width="200"></th> 
  </tr> 

eot;
        for ($i = 1; $i <= $p['volumes']; $i++)
        {
            $tr_class = ($i & 1) ? "tro" : "tre";
            $start = $p['start_id'] + ($i - 1) * land_conf::PROBLEMS_PER_VOLUME;
            $end   = $start + land_conf::PROBLEMS_PER_VOLUME - 1;
            if ($i == $p['volumes'])
                $end = $p['maxid'];
            echo <<<eot
  <tr class="$tr_class"> 
    <td></td> 
    <td align="center">$start</td> 
    <td align="center"><a href="{$web_root}/problem/list?volume=$i" class="blue">Volume $i</a></td> 
    <td align="center">$end</td> 
    <td></td> 
  </tr> 

eot;
        }
        echo <<<eot
  </tbody></table> 
  <br /> 
  <div> 
    <form method="post" action="{$web_root}/problem/search"> 
    <strong>Search By Problem Title: </strong>
    <input name="key" type="text" value='' size="50" maxlength="255" />
    <input type="submit" value="Go" /> 
    </form> 
  </div> 
  </div> 
eot;
        return true;
    }
}

?>
