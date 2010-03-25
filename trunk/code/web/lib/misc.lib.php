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

function fail_test($variable, $cond = false)
{
    if ($cond === $variable)
    {
        throw new Exception("");
    }
}

function force_read($arr, $key)
{
    if (isset($arr[$key]))
    {
        return $arr[$key];
    }
    return null;
}

function dump_var($var)
{
    ob_start();
    var_dump($var);
    $d = ob_get_contents();
    ob_clean();
    return $d;
}

function notify_daemon_java($src_id)
{
    $retry = 3;
    while ($retry--)
    {
        if ($retry < 2)
        {
            FM_LOG_WARNING("Retrying...");
        }
        $host   = land_conf::DAEMON_HOST;
        $port   = land_conf::DAEMON_PORT;
        $timeout= land_conf::DAEMON_TIME_OUT;
        $errno  = 0;
        $errstr = '';
        $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$fp)
        {
            FM_LOG_WARNING("Notify daemon failed, %d:%s", $errno, $errstr);
        }
        else
        {
            FM_LOG_TRACE("connected to daemon");
            fwrite($fp, "$src_id\n");
            $ret = fgets($fp);
            fclose($fp);
            FM_LOG_TRACE("daemon returned: %s", $ret);
            if ($ret == $src_id)
            {
                FM_LOG_TRACE("notify succeeded");
                return true;
            }
            else
            {
                FM_LOG_WARNING("bad return value");
            }
        }
    }
    FM_LOG_FATAL("Retried 3 times. Aborted");
    return false;
}

?>
