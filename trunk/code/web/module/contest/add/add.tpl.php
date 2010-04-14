<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $pub = 'checked'; $pri = '';
        echo <<<eot
<div id="tt"> 
    Add a new contest
</div> 

<script language="javascript">
    function FillAddcontestForm()
    {
        var start_time = $('start_time');
        var end_time   = $('end_time');
        var title      = $('title');

        if (title.value.length == 0)
        {
            alert('Please choose a title for this contest');
            title.focus();
            return false;
        }

        var reg_time = /^ *\\d{4}-\\d{1,2}-\\d{1,2} +\\d{1,2}:\\d{1,2}:\\d{1,2} *$/;

        if (!reg_time.test(start_time.value))
        {
            alert('Start time is invalid.');
            start_time.focus();
            return false;
        }

        if (!reg_time.test(end_time.value))
        {
            alert('end time is invalid.');
            end_time.focus();
            return false;
        }
        return true;
    }
</script>
<style>
td{padding-left:3px; padding-right:3px;}
</style>

<div id="main"> 

    <form action="$web_root/contest/add" method="post" onsubmit="javascript: return FillAddcontestForm();"> 
    <input type="hidden" name="seed" value="{$p['seed']}" /> 
    <table><tbody> 
        <tr> 
            <th colspan="4" align="center">Complete the Information</th> 
        </tr> 
        <tr class="tre"> 
            <td width="100"></td> 
            <td width="150" align="right"><strong>Title</strong> </td> 
            <td width="600" align="left"> <input type="text" tabindex="1" size="75" name="title" id="title" value="" /></td> 
            <td width="100"></td> 
        </tr> 
        <tr class="tro"> 
            <td></td> 
            <td align="right"><strong>Type</strong> </td> 
            <td align="left"> 
                <input tabindex="2" type="radio" name="private" $pub value="0"/>Public &nbsp;
                <input tabindex="3" type="radio" name="private" $pri value="1"/>Private
            </td> 
            <td></td> 
        </tr> 
        <tr class="tre"> 
            <td></td> 
            <td align="right"><strong>Description</strong> </td> 
            <td align="left"><textarea tabindex="4" name="description" rows="5" cols="80"></textarea></td> 
            <td></td> 
        </tr> 
        <tr class="tro"> 
            <td></td> 
            <td align="right"><strong>Start Time</strong> </td> 
            <td align="left"> 
                <input tabindex="5" type="text" id="start_time" name="start_time" value="{$p['start_time']}"/> *Format: yyyy-mm-dd HH:MM:SS
            </td> 
            <td></td> 
        </tr>
        <tr class="tre"> 
            <td></td> 
            <td align="right"><strong>End Time</strong> </td> 
            <td align="left"> 
                <input tabindex="6" type="text" id="end_time" name="end_time" value="{$p['end_time']}"/>
            </td> 
            <td></td> 
        </tr> 
        <tr class="tro"> 
            <td></td> 
            <td colspan="2" align="center"> 
                <input tabindex="7" type="submit" value="Submit" />&nbsp;
                <input tabindex="8" type="reset"  value="Reset" /> 
            </td> 
            <td></td> 
        </tr> 
    </tbody></table> 
    </form> 
</div> 

eot;
        return true;
    }
}

?>
