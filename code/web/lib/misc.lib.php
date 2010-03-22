<?php

//针对多维数组
function apply_func_recursive($user_func, &$data){
    if (is_array($data))
    {
        foreach ($data as $key => &$value)
        {
            apply_func_recursive($user_func, $value);
        }
    }
    else
    {
        $data = call_user_func($user_func, $data);
    }
}

function rndstr($len = 4)
{
    $char_tbl = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str = "";
    for ($i = 0; $i < $len; $i++)
    {
        $str .= $char_tbl{mt_rand(0, 25)};
    }
    return $str;
}
?>
