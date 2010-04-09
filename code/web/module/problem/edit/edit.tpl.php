<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $problem = $p['problem'];
        $pid = (int)$problem['problem_id'];
        foreach ($problem as &$v) $v = htmlspecialchars($v);
        $contest_opt = '<option value="0">No Contest</option>';
        echo <<<eot
<div id="tt"> 
    Edit Problem {$pid}
</div> 

<script language="javascript">
    function FillEditProblemForm()
    {
        //for further check
        return true;
    }
</script>

<div id="main"> 

    <form action="$web_root/problem/edit" method="post" onsubmit="javascript: return FillEditProblemForm();"> 
        <input type="hidden" value="{$pid}" class="formEle" tabindex="1" name="problem_id" id="problem_id" /> 
        <table><tbody> 
                <tr> 
                    <th colspan="4" align="center">Complete the Informations</th> 
                </tr> 
                <tr class="tro"> 
                    <td width="100"></td> 
                    <td width="150" align="right"><strong>Problem ID:</strong>&nbsp;&nbsp;</td> 
                    <td width="600" align="left">&nbsp;&nbsp;{$pid}</td> 
                    <td width="100"></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Title:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<input class="formEle" tabindex="2" name="title" id="title" size="75" value="{$problem['title']}" /></td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Time Limit:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<input class="formEle" tabindex="3" name="time_limit" id="time_limit" value="{$problem['time_limit']}" size="15" />ms</td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Memory Limit:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<input class="formEle" tabindex="4" name="memory_limit" id="memory_limit" value="{$problem['memory_limit']}" size="15" />KB</td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Description:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="5" name="description" id="description" rows="10" cols="80">{$problem['description']}</textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Input:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="6" name="input" id="input" rows="5" cols="80">{$problem['input']}</textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Output:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="7" name="output" id="output" rows="5" cols="80">{$problem['output']}</textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Sample Input:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="8" name="sample_input" id="sample_input" rows="5" cols="80">{$problem['sample_input']}</textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Sample Output:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="9" name="sample_output" id="sample_output" rows="5" cols="80">{$problem['sample_output']}</textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Hint:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="10" name="hint" id="hint" rows="5" cols="80">{$problem['hint']}</textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Source:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<input class="formEle" tabindex="11" name="source" id="source" size="75" value="{$problem['source']}" /></td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Contest:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;
                        <select class="formEle" tabindex="12" name="contest_id" id="contest_id"> 
                            {$contest_opt}
                        </select> 
                    </td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td colspan="4" align="center"> 
                        <input type="submit" class="formEle" tabindex="13" name="submit" id="submit" value="Submit" />&nbsp;
                        <input class="formEle" tabindex="14" name="reset" id="reset" type="reset" value="Reset" /> 
                    </td> 
                </tr> 
        </tbody></table> 
    </form> 
</div> 

eot;
        return true;
    }
}

?>
