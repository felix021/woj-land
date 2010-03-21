<?php

class response
{
    public static $arr_headers = array(
        "Content-Type: text/html; charset=utf-8",
        );
    public static $arr_data    = array(
        );

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
}

?>
