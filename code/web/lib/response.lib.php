<?php

class response
{
    public static $arr_headers = array(
        "Content-Type: text/html; charset=utf-8",
        );
    public static $arr_data    = array();

    public static $tpl_file    = "/lib/template/default_tpl.lib.php";

    public static function add_header($head_str)
    {
        array_push(self::$arr_headers, $head_str);
    }

    public static function send_headers()
    {
        foreach (self::$arr_headers as $head_str)
        {
            $headstr = trim($head_str);
            header($head_str);
        }
    }

    public static function set_data_arr($arr_data)
    {
        if (is_array($arr_data))
        {
            self::$arr_data = $arr_data;
        }
    }

    public static function add_data($key, $value)
    {
        self::$arr_data[$key] = $value;
    }

    public static function add_data_arr($arr_data)
    {
        if (is_array($arr_data))
        {
            self::$arr_data = array_merge(self::$arr_data, $arr_data);
        }
    }

    public static function set_redirect($url)
    {
        ob_clean();
        header("HTTP/1.1 301 Moved Permanently");
        header("location: " . $url);
        exit();
    }

    public static function set_tpl($tpl_file)
    {
        self::$tpl_file = $tpl_file;
    }

    public static function display()
    {
        if (!file_exists(self::$tpl_file))
        {
            self::$tpl_file = ROOT . self::$tpl_file;
        }
        if (!is_readable(self::$tpl_file))
        {
            FM_LOG_WARNING("tpl file: %s is not readable", self::$tpl_file);
            throw Exception("bad tpl");
        }
        FM_LOG_TRACE("load template: %s", self::$tpl_file);
        require_once(self::$tpl_file);
        if (!class_exists(land_conf::DEFAULT_TPL_CLASS))
        {
            FM_LOG_WARNING("DEFAULT_TPL_CLASS missing");
            throw Exception("bad tpl");
        }
        $class_name = land_conf::DEFAULT_TPL_CLASS;
        $tpl = new $class_name();
        if (!($tpl  instanceof itemplate))
        {
            FM_LOG_WARNINIG("tpl class not implemented itemplate");
            throw Exception("bad tpl");
        }
        $tpl->display(self::$arr_data);
    }
}

?>
