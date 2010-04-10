<?php

class TPL_Main implements itemplate
{
    public function display($p)
    {
        echo htmlspecialchars($p['msg']);
        return true;
    }
}

?>
