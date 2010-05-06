<?php

class logger
{
    const LOG_FATAL     = 0;
    const LOG_WARNING   = 1;
    const LOG_MONITOR   = 2;
    const LOG_NOTICE    = 3;
    const LOG_TRACE     = 4;
    const LOG_DEBUG     = 5;

    const BUFF_SIZE     = 4096;

    protected static $log_buff;
    protected static $log_buff_wf;
    protected static $log_extra_info;

    protected static $log_filename;
    protected static $log_filename_wf;
    protected static $log_fp;
    protected static $log_fp_wf;

    protected static $log_opened  = false;

    public static $errno;

    public static $LOG_LEVEL = array(
            self::LOG_FATAL    => "FATAL",
            self::LOG_WARNING  => "WARNING",
            self::LOG_MONITOR  => "MONITOR",
            self::LOG_NOTICE   => "NOTICE",
            self::LOG_TRACE   => "TRACE",
            self::LOG_DEBUG   => "DEBUG",
        );

    public static $err_info = array(
            0   => "ok",
            1   => "log_open: log already opened",
            2   => "log_open: open log file failed",
            3   => "log_write: log not opened yet",
            4   => "log_write: unknown log_level",
            );

    public static function log_opened()
    {
        return self::$log_opened;
    }

    public static function log_open ($filename)
    {
        self::$errno = 0;
        if (true == self::$log_opened)
        {
            self::$errno = 1;
            return false;
        }
        self::$log_filename     = $filename;
        self::$log_filename_wf  = $filename . ".wf";
        self::$log_fp           = fopen($filename, "a");
        self::$log_fp_wf        = fopen(self::$log_filename_wf, "a");
        if (!self::$log_fp || !self::$log_fp_wf) 
        {
            self::$errno = 2;
            return false;
        }
        register_shutdown_function("logger::log_close");
        self::$log_opened = true;
        FM_LOG_NOTICE("log_open");
        return true;
    }

    public static function log_close()
    {
        if (true == self::$log_opened)
        {
            FM_LOG_TRACE("log_close");
            self::flush();
            self::flush(true);
            fclose(self::$log_fp);
            fclose(self::$log_fp_wf);
            self::$log_fp           = false;
            self::$log_fp_wf        = false;
            self::$log_filename     = "";
            self::$log_filename_wf  = "";
            self::$log_opened       = false;
        }
    }

    public static function flush($wf = false)
    {
        if (!$wf)
        {
            if (strlen(self::$log_buff) > 0)
            {
                fwrite(self::$log_fp, self::$log_buff);
                self::$log_buff = '';
            }
        }
        else 
        {
            if (strlen(self::$log_buff_wf) > 0)
            {
                fwrite(self::$log_fp_wf, self::$log_buff_wf);
                self::$log_buff_wf = '';
            }
        }
    }

    public static function log_write($level)
    {
        self::$errno = 0;
        if (false == self::$log_opened)
        {
            self::$errno = 3;
            return false;
        }
        if (!isset(self::$LOG_LEVEL[$level]))
        {
            self::$errno = 4;
            return false;
        }
        $now = date("Y-m-d H:i:s", time());
        $data = debug_backtrace();
        for ($i = 2; $i >= 0; $i--)
        {
            if (isset($data[$i]))
            {
                $info = $data[$i];
                break;
            }
        }
        $str_common = sprintf("%s\x6 [%s]\x6 [%s:%d]%s\x6 ",
                self::$LOG_LEVEL[$level], $now, $info['file'], $info['line'], self::$log_extra_info);
        $params = func_get_args();
        array_shift($params);
        $str_user   = call_user_func_array('sprintf', $params);
        if ($level == self::LOG_WARNING || $level == self::LOG_FATAL)
        {
            self::$log_buff_wf .= sprintf("%s%s\x6\n", $str_common, $str_user);
        }
        else
        {
            self::$log_buff .= sprintf("%s%s\x6\n", $str_common, $str_user);
        }
        //echo self::$log_buff, "\n", self::$log_buff_wf;

        if (strlen(self::$log_buff) > self::BUFF_SIZE)
        {
            self::flush();
        }
        if (strlen(self::$log_buff_wf) > self::BUFF_SIZE)
        {
            self::flush(true);
        }
        return true;
    }

    static function log_add_info($info)
    {
        $str_tmp = sprintf("\x6 [%s]", $info);
        self::$log_extra_info .= $str_tmp;
    }
}

function backtrace($layer = 1)
{
    $info = debug_backtrace();
    while ($layer > 0 && !isset($info[$layer]))
        $layer--;
    return array($info[$layer]['file'], $info[$layer]['line']);
}

function FM_LOG_DEBUG()
{
    $args = func_get_args();
    array_unshift($args, logger::LOG_DEBUG);
    call_user_func_array("logger::log_write", $args);
}

function FM_LOG_TRACE()
{
    $args = func_get_args();
    array_unshift($args, logger::LOG_TRACE);
    call_user_func_array("logger::log_write", $args);
}

function FM_LOG_NOTICE()
{
    $args = func_get_args();
    array_unshift($args, logger::LOG_NOTICE);
    call_user_func_array("logger::log_write", $args);
}

function FM_LOG_WARNING()
{
    $args = func_get_args();
    array_unshift($args, logger::LOG_WARNING);
    call_user_func_array("logger::log_write", $args);
}

function FM_LOG_WARNING2()
{
    $args = func_get_args();
    list($file, $line) = backtrace(2);
    $args[0] = sprintf("[%s:%d]", $file, $line) . $args[0];
    array_unshift($args, logger::LOG_WARNING);
    call_user_func_array("logger::log_write", $args);
}

function FM_LOG_MONITOR()
{
    $args = func_get_args();
    array_unshift($args, logger::LOG_MONITOR);
    call_user_func_array("logger::log_write", $args);
}

function FM_LOG_FATAL()
{
    $args = func_get_args();
    array_unshift($args, logger::LOG_FATAL);
    call_user_func_array("logger::log_write", $args);
}

/*
logger::log_open("/tmp/test.log");
if (logger::$errno)
{
    echo logger::$err_info[logger::$errno];
    exit;
}
FM_LOG_DEBUG("debug");
FM_LOG_WARNING("debug");
FM_LOG_TRACE("debug");
FM_LOG_FATAL("debug");
FM_LOG_MONITOR("debug");
*/
?>
