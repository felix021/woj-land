<?php

class TPL_Main implements itemplate
{
    public function display($p)
    {
        ob_clean();

        $filename = sprintf("score_%s.csv", date("Y-m-d_H-i-s"));
        header("Content-Type: application/octec-stream; charset=utf-8");
        header("Content-Disposition: attachment; filename=$filename");

        echo "username,score", PHP_EOL;
        foreach ($p['result'] as $result) {
            echo "{$result['username']},{$result['score']}", PHP_EOL;
        }
    }
}

?>
