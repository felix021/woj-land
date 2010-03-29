<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        echo <<<eot
    <div id="tt"> User Ranklist </div> 

    <div id="main"> 

        <table> 
            <tbody> 
                <tr> 
                    <th width="80"> No.  </th> 
                    <th width="120"> User ID </th> 
                    <th width="450"> Nick Name </th> 
                    <th width="100"> Solved </th> 
                    <th width="100"> Submit </th> 
                    <th width="100"> Ratio </th> 
                </tr> 
eot;
        $i = $p['start'];
        foreach ($p['users'] as $user)
        {
            $tr_class = $i++ & 1 ? 'tre' : 'tro';
            $username = htmlspecialchars($user['username']);
            $nickname = htmlspecialchars($user['nickname']);
            echo <<<eot
                <tr class="$tr_class"> 
                    <td height="26" style="text-align:center;"> $i </td> 
                    <td style="text-align:center;"> <a href="$web_root/user/detail?user_id={$user['user_id']}">$username</a> </td> 
                    <td style="text-align:center;"> {$nickname} </td> 
                    <td style="text-align:center;"> {$user['solved']} </td> 
                    <td style="text-align:center;"> {$user['submit']} </td> 
                    <td style="text-align:center;"> {$user['ratio']}% </td> 
                </tr> 
eot;
        }

        $page = $p['page'];
        $prev = $page - 1;
        $next = $page + 1;
        echo <<<eot
        </tbody> 
            </table> 

            <br/> 
            <div> 
            <span class="bt"><a href="$web_root/ranklist"> Top </a></span> &nbsp;
            <span class="bt"><a href="$web_root/ranklist?page=$prev"> Prev Page </a></span> &nbsp;
            <span class="bt"><a href="$web_root/ranklist?page=$next"> Next Page </a></span> &nbsp;
            </div> 
            <br/> 
            </div> 

eot;
            return true;
    }
}

?>
