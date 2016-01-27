<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        echo <<<eot
  <div id="tt">Admin: 批量导出成绩</div> 
<script language="javascript">
function fillSettingForm()
{
    return true;
}

</script>
   
  <div id="main"> 
    <form action="{$this->web_root}/user/export" method="post" onsubmit="return fillSettingForm();">
    <input type="hidden" name="group_ids" id="group_ids" value=""/>
    <input type="hidden" name="seed" id="seed" value="{$p['seed']}"/>
    <table><tbody> 
      <tr class="tre"> <td align="center"> One username per line.  </td></tr> 
      <tr class="tro"> <td align="center"> <textarea cols="100" rows="20" id="userdata" name="userdata" tabindex="1"></textarea> </td> </tr> 
      <tr class="tre"> <td align="center"> <input  tabindex="2" type="submit" value="导出"/> </td> </tr> 
    </tbody></table> 
    </form> 
  </div> 
<script language="javascript">
document.getElementById('userdata').focus();
</script>
eot;
    }
}

?>
