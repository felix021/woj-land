<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        echo <<<eot
  <div id="tt">Admin: batch user import</div> 
<script language="javascript">
function fillSettingForm()
{
    return true;
}

</script>
   
  <div id="main"> 
    <form action="{$this->web_root}/user/import" method="post" onsubmit="return fillSettingForm();">
    <input type="hidden" name="group_ids" id="group_ids" value=""/>
    <input type="hidden" name="seed" id="seed" value="{$p['seed']}"/>
    <table><tbody> 
      <tr class="tre"> 
<td align="center"> Username* | Password* | Nickname | School | Email <br/>
     e.g. 2010325300001 | 123456 | Nickname | School | a@b.com <br/>
    p.s. Nickname, School, Email are alternative.
</td></tr> 
      <tr class="tro"> <td align="center"> <textarea cols="100" rows="20" name="userdata"></textarea> </td> </tr> 
      <tr class="tre"> <td align="center"> <input type="submit" value="import"/> </td> </tr> 
    </tbody></table> 
    </form> 
  </div> 
eot;
    }
}

?>
