<?php

//this function requires "indent"
function format_code($code)
{
    $code = str_replace("\r\n", "\n", $code);
    $code = escapeshellarg($code);
    exec ("/bin/echo $code | indent -linux -l120 -bl -nce -bls -bli0", $arr_lines, $ret);
    if ($ret > 0)
        throw new Exception("error while formatting...");
    return join("\n", $arr_lines);
}

?>
