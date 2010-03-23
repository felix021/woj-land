<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        echo "<pre>\n";
        var_dump($p);
        echo "</pre>\n";
        return true;
    }
}

?>
