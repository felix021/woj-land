<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $problem_data = json_encode($p['problems']);
        echo <<<eot
<script language="javascript">
var problem_data = $problem_data;
function show_problem_data(data)
{
try
{
    var problems = $('problems');
    while (problems.hasChildNodes())
    {
        var child = problems.childNodes[0];
        problems.removeChild(child);
    }
    var tbl, tbody, tr, th, td;
    tbl     = document.createElement('table');
    tbody   = document.createElement('tbody');
    tbody.align = 'center';
    tr      = document.createElement('tr');
    tr.className = 'tro';
    th      = document.createElement('th');
    th.width = 80;
    tr.appendChild(th);
    th      = document.createElement('th');
    th.width = 100;
    th.innerHTML = '<a href="javascript:sort_by(cmp_id)">ID</a>';
    tr.appendChild(th);
    th      = document.createElement('th');
    th.width = 590;
    th.innerHTML = 'Title';
    tr.appendChild(th);
    th      = document.createElement('th');
    th.width = 180;
    th.innerHTML = 
        '<a href="javascript:sort_by(cmp_ratio)">Ratio</a>'
      + ' (<a href="javascript:sort_by(cmp_accepted)">AC</a>/'
      + '<a href="javascript:sort_by(cmp_total)">Total</a>)';
    tr.appendChild(th);
    tbody.appendChild(tr);

    for (var i = 0; i < data.length; i++)
    {
        var tr_class = i & 1 ? "tro" : "tre";
        tr = document.createElement('tr');
        tr.className = tr_class;
        td = document.createElement('td');
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerHTML = data[i].problem_id;
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerHTML = '<a href="{$web_root}/problem/detail?problem_id=' 
                     + data[i].problem_id + '">'
                     + htmlspecialchars(data[i].title) + '</a>';
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerHTML = data[i].ratio + 
            ' (' + data[i].accepted + '/' + data[i].submitted + ')';
        tr.appendChild(td);
        tbody.appendChild(tr);
    }

    tbl.appendChild(tbody);
    problems.appendChild(tbl);
}
catch (e)
{
    alert(e);
}
}


var fuck_cmp_flag = false;

function cmp_id(a, b)
{
    var result = (a.problem_id < b.problem_id);
    return fuck_cmp_flag ? result : !result;
}

function cmp_ratio(a, b)
{
    var result = (a.ratio < b.ratio);
    return fuck_cmp_flag ? result : !result;
}

function cmp_accepted(a, b)
{
    var result = (a.accepted < b.accepted);
    return fuck_cmp_flag ? result : !result;
}

function cmp_total(a, b)
{
    var result = (a.submitted < b.submitted);
    return fuck_cmp_flag ? result : !result;
}

function sort_by(cmp)
{
    try
    {
        qsort(problem_data, 0, problem_data.length - 1, cmp);
        show_problem_data(problem_data);
        
        fuck_cmp_flag = !fuck_cmp_flag;
    }
    catch (e)
    {
        alert(e);
    }
}
</script>
  <div id="tt">Problems Volume {$p['volume']}</div> 
  <div id="main"> 
  <div id="problems"></div>
  <br> 
  <span class="bt"><a href="{$web_root}/problem/volume">Back to Volumes List</a></span> 
  <br><br> 
  </div> 
<script language="javascript">

show_problem_data(problem_data);
</script>
eot;
        return true;
    }
}

?>
