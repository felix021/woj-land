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

function display_err($errmsg, $links = array())
{
    ob_clean();
    $errmsg = htmlspecialchars($errmsg);
    echo $errmsg, "<br/>\n";
    if (is_array($links))
    {
        foreach ($links as $key => $link)
        {
            echo "<a href=\"$link\">$key</a> <br\>\n";
        }
    }
}

?>
