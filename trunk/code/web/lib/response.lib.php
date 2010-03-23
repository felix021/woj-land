<?php

class response
{
    public static $arr_headers = array(
        "Content-Type: text/html; charset=utf-8",
        );
    public static $arr_data    = array();

    public static $tpl_file;

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
        self::send_headers();
        if (land_conf::DEBUG)
        {
            FM_LOG_DEBUG("arr_data: %s", print_r(self::$arr_data, true));
        }
        if (empty(self::$tpl_file))
        {
            self::$tpl_file = LIB_ROOT . "/template/default_tpl.lib.php";
        }
        ctemplate_run::run(self::$tpl_file, land_conf::DEFAULT_TPL_CLASS);
    }

    public static function display_msg($msg)
    {
        self::add_data('msg', $msg);
        self::set_tpl(TPL_ROOT . '/msg.tpl.php');
    }
}

?>
