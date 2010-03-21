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

    static $log_buff;
    static $log_extra_info;

    static $log_filename;
    static $log_fp;

    static $log_opened  = false;

    static $errno;

    static $LOG_LEVEL = array(
            self::LOG_FATAL     => "FATAL",
            self::LOG_WARNING   => "WARNING",
            self::LOG_MONITOR   => "MONITOR",
            self::LOG_NOTICE   => "NOTICE",
            self::LOG_TRACE   => "TRACE",
            self::LOG_DEBUG   => "DEBUG",
        );

    static $err_info = array(
            0   => "ok",
            1   => "log_open: log already opened",
            2   => "log_open: open log file failed",
            3   => "log_write: log not opened yet",
            4   => "log_write: unknown log_level",
            );

    static function log_open ($filename)
    {
        self::$errno = 0;
        if (true == self::$log_opened)
        {
            self::$errno = 1;
            return false;
        }
        self::$log_filename = $filename;
        self::$log_fp = fopen($filename, "a");
        if (!self::$log_fp)
        {
            self::$errno = 2;
            return false;
        }
        register_shutdown_function("logger::log_close");
        self::$log_opened = true;
        FM_LOG_NOTICE("log_open");
        return true;
    }

    static function log_close()
    {
        if (true == self::$log_opened)
        {
            FM_LOG_TRACE("log_close");
            if (strlen(self::$log_buff) > 0)
            {
                fwrite(self::$log_fp, self::$log_buff);
            }
            fclose(self::$log_fp);
            self::$log_fp           = false;
            self::$log_filename     = "";
            self::$log_opened       = false;
        }
    }

    static function log_write($level)
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
        $str_common = sprintf("--%s--\x7 [%s]\x7 [%s:%d]%s\x7 ",
                self::$LOG_LEVEL[$level], $now, $info['file'], $info['line'], self::$log_extra_info);
        $params = func_get_args();
        array_shift($params);
        $str_user   = call_user_func_array(sprintf, $params);
        self::$log_buff .= sprintf("%s%s\x7\n", $str_common, $str_user);
        if (strlen(self::$log_buff) > self::BUFF_SIZE)
        {
            //fwrite in php is atomic
            fwrite(self::$log_fp, self::$log_buff);
            self::$log_buff = "";
        }
        return true;
    }

    static function log_add_info($info)
    {
        $str_tmp = sprintf("\x7 [%s]", $info);
        self::$log_extra_info .= $str_tmp;
    }
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

?>
