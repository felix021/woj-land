<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $pid = (int)$p['problem_id'];
        echo <<<eot
  <div id="tt">Manage Files For Problem <a href="$web_root/problem/detail?problem_id={$pid}">{$pid}</a></div> 

<script language="javascript">
var to_be_deleted = '';
function delData(pid, file)
{
    if (!confirm("Are you sure to delete " + file + ".in and " + file + ".out ?"))
        return;
    var url     = '$web_root/files/delete';
    var values  = 'problem_id=' + pid + '&file=' + encodeURIComponent(file);
    to_be_deleted = 'io_' + file;
    LoadURL('POST', url, values, ajax_del);
}

function ajax_del(status, response)
{
    if (status == 200)
    {
        alert(response);
        var t = $(to_be_deleted);
        t.parentNode.removeChild(t);
    }
    else
    {
        alert('Operation failed');
    }
    to_be_deleted = '';
}
</script>
<style>
td{text-align:center;}
</style>

  <div id="main"> 
<form action="$web_root/files/upload" method="post" enctype="multipart/form-data" name="form_data" id="form_data" onsubmit="javascript: return checkDataNames()">
  <input type="hidden" name="problem_id" id="problem_id" value="{$pid}"/>
  <input type="hidden" name="seed" id="seed" value="{$p['seed']}"/>
  <table><tbody align="left"> 
    <tr class="tro"> 
      <th width="50"></th> 
      <th align="center" width="200"><strong>Files</strong></th> 
      <th align="center" width="250"><b>Input</b></th> 
      <th align="center" width="250"><b>Output</b></th> 
      <th align="center" width="100"><b>Operation</b></th> 
      <th width="50"></th> 
    </tr> 
eot;
        $i = 0;
        foreach ($p['files'] as $io)
        {
            if (empty($io)) continue;
            $tr_class = $i++ & 1 ? 'tro' : 'tre';
            $io       = htmlspecialchars($io);
            $in       = $io . '.in';
            $out      = $io . '.out';
            echo <<<eot
    <tr class="{$tr_class}" id="io_$io"> 
      <td></td> 
      <td>{$i}</td> 
      <td>$in</td> 
      <td>$out</td> 
      <td><a href="javascript:delData($pid, '$io')"/>Remove</a></td> 
      <td></td> 
    </tr> 
eot;
        }
        $tr_class = $i++ & 1 ? 'tro' : 'tre';
        $tr_class1 = $i++ & 1 ? 'tro' : 'tre';
        echo <<<eot
    <tr class="$tr_class"> 
      <td></td> 
      <td>Add</td> 
      <td><input type="file" name="input[]"/></td> 
      <td><input type="file" name="output[]"/></td> 
      <td><a href="javascript: moreData()"/>More</a></td> 
      <td></td> 
    </tr> 
        <tr class="$tr_class1" id="submit_tr">
      <td></td> 
      <td></td> 
      <td colspan="2" style="text-align:left;"><input type="submit" value="Upload"/></td> 
      <td></td> 
      <td></td> 
    </tr> 
  </tbody></table> 
</form> 

<script language="javascript">
var data_idx_tr = $i;
function moreData()
{
try{
    var tr = document.createElement('tr');
    tr.className = ++data_idx_tr & 1 ? 'tro' : 'tre';
    var td = document.createElement('td');
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = 'Add';
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = '<input type="file" name="input[]"/>';
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = '<input type="file" name="output[]"/>';
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = '<a href="javascript:moreData()">More</a>';
    tr.appendChild(td);
    td = document.createElement('td');
    tr.appendChild(td);
    var submit_tr = $('submit_tr');
    submit_tr.parentNode.insertBefore(tr, submit_tr);
}catch(e){alert(e);}
}

function checkDataNames()
{
try{
    var inputs  = document.getElementsByName('input[]');
    var outputs = document.getElementsByName('output[]');
    var n_files = inputs.length;
    var i;
    var reg_in  = /\.in$/;
    var reg_out = /\.out$/;
    for (i = 0; i < n_files; i++)
    {
        var in_f  = inputs[i].value.replace(/^.*[\\\\\/]/g, '');
        var out_f = outputs[i].value.replace(/^.*[\\\\\/]/g, '');
        
        if (!reg_in.test(in_f))
        {
            alert('Input file "' + in_f + '" should have an extension .in');
            return false;
        }
        
        if (!reg_out.test(out_f))
        {
            alert('Output file "' + out_f + '" should have an extension .out');
            return false;
        }

        if (in_f.replace('.in', '') != out_f.replace('.out', ''))
        {
            alert('Input file "' + in_f + '" and output file "' + out_f + '" do not share one name');
            return false;
        }
    }
}catch(e){alert(e); }
    return true;
}

function checkSPJ()
{
    var spj = $('spj');
    var reg = /\.(cpp|exe)$/;
    if (reg.test(spj.value))
        return true;
    alert('spj file should be a cpp source or an exe file');
    return false;
}
</script>

    <br/>

  <table><tbody align="left">
    <tr class="tro">
      <th width="50"></th>
      <th align="center" colspan="2"><strong>SPJ</strong></th>
      <th width="50"></th>
    </tr>
eot;
        if ($p['spj'])
        {
            echo <<<eot
    <tr class="tro">
      <td widtd="50"></td>
      <td align="center" width="400"><strong>spj.exe</strong></td>
      <td align="center" width="100">  Remove </td>
      <td widtd="50"></td>
    </tr>
eot;
        }
        echo <<<eot

  <form action="$web_root/files/spj" method="post" enctype="multipart/form-data" onsubmit="javascript: return checkSPJ();">
    <tr class="tre">
      <td widtd="50"><input type="hidden" name="seed" value="{$p['seed']}"/> <input type="hidden" name="problem_id" value="{$pid}"/></td>
      <td align="center" width="400">Upload a cpp source or spj.exe here: <input type="file" name="spj" id="spj"/></td>
      <td align="center" width="100"><input type="submit" value="Upload"/> </td>
      <td widtd="50"></td>
    </tr>
  </form>
  </tbody></table>
  </div> 
eot;
        return true;
    }
}

?>
