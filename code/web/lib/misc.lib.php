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
        FM_LOG_WARNING2("fail_test: %s", print_r($cond));
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

function in_solved_list($problem_id, $solved_list)
{
    $pid = (int) $problem_id;
    return preg_match("/\\b$pid\\b/", $solved_list);
}

function get_privileges_by_groups($group_ids)
{
    $priv = array();
    foreach (land_conf::$priv_fields as $pf)
    {
        $priv[$pf] = false;
    }

    $arr_groups = explode("|", $group_ids);
    $arr_groups = array_filter($arr_groups, create_function('$a', 'return !empty($a);'));
    foreach ($arr_groups as &$g) $g = (int)$g;

//    FM_LOG_DEBUG("group_ids: %s", $group_ids);
//    FM_LOG_DEBUG("groups: %s", print_r($arr_groups, true));

    if (count($arr_groups) == 0)
    {
        return $priv;
    }

    $group_ids  = implode(",", $arr_groups);

    $sql = "SELECT * FROM `groups` WHERE `group_id` IN ($group_ids)";
    $conn = db_connect();
    fail_test($conn, false);

    //取出所有组的信息 TODO cache
    $groups = db_fetch_lines($conn, $sql, count($arr_groups));
    //FM_LOG_DEBUG("groups: %s", print_r($groups, true));
    fail_test($groups, false);

    db_close($conn);

    foreach ($groups as $group)
    {
        foreach (land_conf::$priv_fields as $pf)
        {
            //采用 OR 来决定最终的权限
            if ($priv[$pf] != true)
            {
                if ($group[$pf] == 1)
                {
                    $priv[$pf] = true;
                }
            }
        }
    }

    return $priv;
}

function land_err_handler($errno, $errstr, $errfile, $errline)
{
    if (logger::$log_opened)
    {
        FM_LOG_FATAL("PHP_ERROR: [%s:%s] %d: %s",
            $errfile, $errline, $errno, $errstr);
        response::set_redirect(land_conf::$web_root . '/error.html');
        return true;
    }
    else
    {
        printf("PHP_ERROR: [%s:%s] %d: %s",
            $errfile, $errline, $errno, $errstr);
        return false;
    }
}

?>
