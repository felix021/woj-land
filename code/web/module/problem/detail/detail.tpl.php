<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $problem = $p['problem'];
        $edit_button = '';
        $defunct_button = '';
        foreach ($problem as $key => &$v)
        {
            $v = htmlspecialchars($v);
            $v = str_replace("\r\n", "\n", $v);
            $v = str_replace("\r", "\n", $v);
            $v = str_replace("\n", "<br/>", $v);
            $v = str_replace("  ", "&nbsp;", $v);
        }
        $SPJ = $problem['spj'] == 1 ? "Yes" : "No";

        if (is_admin())
        {
            $edit_button    = "<span class=\"bt\"><a href=\"{$web_root}/problem/edit?problem_id={$problem['problem_id']}\">Edit</a></span>";
            $defunct_button = "<span class=\"bt\"><a href=\"{$web_root}/problem/defuct?problem_id={$problem['problem_id']}\">Defunct</a></span>";
        }

        echo <<<eot
  <div id="tt"> Problem {$problem['problem_id']} - {$problem['title']} </div> 
  
  <div class="ifm"> 
    <strong>Time Limit</strong>: {$problem['time_limit']}MS &nbsp;
    <strong>Memory Limit</strong>: {$problem['memory_limit']}KB<br/> 
    <strong>Total Submit</strong>: {$problem['submitted']}&nbsp;
    <strong>Accepted</strong>: {$problem['accepted']}&nbsp;
    <strong>Special Judge</strong>: {$SPJ}
  </div> 
 
  <div id="main"> 
    <div class="ptt">Description</div> 
    
    <div class="ptx">{$problem['description']}</div> 
    
    <div class="ptt">Input</div> 
        
    <div class="ptx">{$problem['input']}</div> 
 
    <div class="ptt">Output</div> 
    
    <div class="ptx">{$problem['output']}</div> 
 
    <div class="ptt">Sample Input</div> 
    
    <div class="ptx">{$problem['sample_input']}</div> 
 
    <div class="ptt">Sample Output</div> 
        
    <div class="ptx">{$problem['sample_output']}</div> 
    
    <div class="ptt">Hint</div> 
        
    <div class="ptx">{$problem['hint']}</div> 
    
    <div class="ptt">Source</div> 

    <div class="ptx">{$problem['source']}</div> 

    <br /> 

    <div> 
      <span class="bt"><a href="{$web_root}/submit/submit?problem_id={$problem['problem_id']}">Submit</a></span>  
      <!-- TODO <span class="bt"><a href="{$web_root}/discuss/list?problem_id={$problem['problem_id']}">Discuss</a></span>  -->
      <span class="bt"><a href="{$web_root}/status/problem?problem_id={$problem['problem_id']}">Status</a></span> 
      $edit_button
      $defunct_button
    </div> 
    <br /> 
  </div> 
eot;
        return true;
    }
}

?>
