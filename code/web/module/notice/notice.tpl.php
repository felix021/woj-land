<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $notice = htmlspecialchars($p['notice']);
        echo <<<eot
    <style>td{text-align:center;}</style>
    <div id="tt">Set the Notice</div>
    <div id="main"> 
        <form method="post" action="$web_root/notice">
            <table>
            <tr id="tro">
                <td>Type in the notice. Character '\\n' will be replaced by a space, and if the notice is empty after trim, it won't be shown.</td>
            </tr>
            <tr id="tre">
                <td><textarea tabindex="1" cols="100" rows="4" name="notice">{$notice}</textarea></td>
            </tr>
            <tr id="tro">
                <td>
                    <input type="submit" tabindex="2" value="submit"/>
                    <input type="reset" tabindex="3" value="reset"/>
                </td>
            </tr>
        </table>
        </form> 
    </div>
eot;
        return true;
    }
}

?>
