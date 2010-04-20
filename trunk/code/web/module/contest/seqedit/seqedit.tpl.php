<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;

        $pid_seq = $p['pid_seq'];
        $lines   = count($pid_seq);
        $contest = $p['contest'];
        $cid = (int)$contest['contest_id'];
        foreach ($contest as &$v) $v = htmlspecialchars($v);

        echo <<<eot
<div id="tt"> 
    Edit Problem Sequence for contest <a href="$web_root/contest/detail?contest_id=$cid">{$contest['title']}</a>
</div> 

<script language="javascript">

    var lines = {$lines};
    
    function FillEditSeqForm()
    {
        var seqs = document.getElementsByName('seq[]');
        var seqv = new Array();
        for (var i = 0; i < lines; i++)
        {
            seqv.push(seqs[i].value.charCodeAt(0) - ('A').charCodeAt(0));
        }
        qsort(seqv, 0, lines - 1, cmp_less);
        if (seqv[0] != 0) 
        {
            alert('Bad sequence. Seq-characters should start from "A".');
            seqs[0].focus();
            return false;
        }
        for (var i = 1; i < lines; i++)
        {
            if (seqv[i] != seqv[i-1] + 1)
            {
                alert('Bad sequence. Seq-characters should be in alphabetic sequence.');
                seqs[0].focus();
                return false;
            }
        }
        return true;
    }
</script>
<style>td{text-align:center;}</style>

<div id="main"> 
    <p><span class="ifm" style="font-size:12px;">Seq-characters should start from 'A', and shoud be in alphabetic sequence.</span></p> 

    <form action="$web_root/contest/seqedit" method="post" onsubmit="javascript: return FillEditSeqForm();"> 
    <input type="hidden" name="contest_id" value="{$cid}" /> 
    <input type="hidden" name="seed" value="{$p['seed']}" /> 
    <table><tbody>
        <tr>
            <th width="150"></th>
            <th width="100">Problem ID</th>
            <th>Title</th>
            <th width="100">Sequence</th>
            <th width="150"></th>
        </tr>

eot;
        $i = 0;
        foreach ($pid_seq as $pro)
        {
            $pid = $pro['problem_id'];
            $title = htmlspecialchars($pro['title']);
            $ch  = seq_to_char($pro['contest_seq']);
            $trc = $i++ & 1 ? 'tro' : 'tre';
            echo <<<eot
        <tr class="$trc">
            <td><input type="hidden" name="pid[]" value="$pid"/></td>
            <td>$pid</td>
            <td>$title</td>
            <td><input type="text" size="5" style="text-align:center" name="seq[]" value="$ch" tabindex="$i"/></td>
            <td></td>
        </tr>

eot;
        }

        $si = $i++;
        $ri = $i++;
        echo <<<eot
        <tr>
            <td></td>
            <td colspan="3"><input type="submit" value="Submit" tabindex="$si"/> &nbsp;
                <input type="reset" value="Reset" tabindex="$ri"/></td>
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
