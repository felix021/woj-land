<?php

//针对多维数组
function apply_func_recursive($user_func, &$data)
{
    if (is_array($data))
    {
        foreach ($data as $key => &$value)
        {
            apply_func_recursive($user_func, $value);
        }
    }
    else
    {
        $value = call_user_func($user_func, $value);
    }
}

?>
