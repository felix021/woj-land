<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $contest_opt = '<option selected value="0">&nbsp;No Contest&nbsp;</option>' . "\n";
        foreach ($p['contests'] as $contest)
        {
            $cid = $contest['contest_id'];
            $title = htmlspecialchars($contest['title']);
            $contest_opt .= "<option value=\"$cid\">&nbsp;{$title}&nbsp;</option>\n";
        }
        echo <<<eot
<div id="tt"> 
    Add a new problem 
</div> 

<script src="$web_root/editor/fckeditor/fckeditor.js"></script>
<script language="javascript">
    function FillAddProblemForm()
    {
        //for further check
        var title = $('title');
        if (title.value.length == 0)
        {
            alert('Please type in the title!');
            title.focus();
            return false;
        }
        return true;
    }

    window.onload = function()
    {
        var desc = replaceTextarea('description', 300, '100%', 'Land');
        desc.ReplaceTextarea();
        var hint = replaceTextarea('hint', 300, '100%', 'Land');
        hint.ReplaceTextarea();
    }
</script>

<div id="main"> 

    <form action="$web_root/problem/add" method="post" onsubmit="javascript: return FillAddProblemForm();"> 
        <table><tbody> 
                <tr> 
                    <th colspan="4" align="center">Complete the Informations</th> 
                </tr> 
                <tr class="tre"> 
                    <td width="60"></td> 
                    <td align="right"><strong>Title:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<input class="formEle" tabindex="2" name="title" id="title" size="75" value="" /></td> 
                    <td width="60"></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Time Limit:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<input class="formEle" tabindex="3" name="time_limit" id="time_limit" value="1000" size="15" />ms</td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Memory Limit:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<input class="formEle" tabindex="4" name="memory_limit" id="memory_limit" value="65536" size="15" />KB</td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Description:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="5" name="description" id="description" rows="10"style="width:100%" cols="80"></textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Input:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="6" name="input" id="input" rows="5"style="width:100%" cols="80"></textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Output:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="7" name="output" id="output" rows="5"style="width:100%" cols="80"></textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Sample Input:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="8" name="sample_input" id="sample_input" rows="5"style="width:100%" cols="80"></textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Sample Output:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="9" name="sample_output" id="sample_output" rows="5"style="width:100%" cols="80"></textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Hint:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<textarea class="formEle" tabindex="10" name="hint" id="hint" rows="5"style="width:100%" cols="80"></textarea></td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Source:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;<input class="formEle" tabindex="11" name="source" id="source" size="75" value="" /></td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"><strong>Contest:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;
                        <select id="contest_id" name="contest_id" tabindex="12">
                        $contest_opt
                        </select>
                    </td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Special Judge:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;
                        <input type="checkbox" name="spj" tabindex="13" id="spj" class="formEle" value="1"/>
                        This is a spj problem.
                    </td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td></td> 
                    <td align="right"></td> 
                    <td align="left">&nbsp;&nbsp;
                        <input type="checkbox" name="enable" tabindex="14" id="spj" class="formEle" value="1"/>
                        Enable this problem immediately.
                    </td> 
                    <td></td> 
                </tr> 
                <tr class="tro"> 
                    <td></td> 
                    <td align="right"><strong>Difficulty:</strong>&nbsp;&nbsp;</td> 
                    <td align="left">&nbsp;&nbsp;
                        <select name="difficulty" tabindex="15">
                            <option value="1">Easy</option>
                            <option value="3">Medium</option>
                            <option value="5">Difficult</option>
                        </select>
                    </td> 
                    <td></td> 
                </tr> 
                <tr class="tre"> 
                    <td colspan="4" align="center"> 
                        <input type="submit" class="formEle" tabindex="16" name="submit" id="submit" value="Submit" />&nbsp;
                        <input class="formEle" tabindex="17" name="reset" id="reset" type="reset" value="Reset" /> 
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
