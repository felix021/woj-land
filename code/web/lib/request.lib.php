<?php

class request
{
    public static $uri;
    public static $method;
    public static $arr_get_raw;
    public static $arr_get;
    public static $arr_post_raw;
    public static $arr_post;
    public static $arr_cookie_raw;
    public static $arr_cookie;
    public static $logid;

    public static function init()
    {
        self::$uri  = $_SERVER['REQUEST_URI'];
        self::$uri  = str_replace(land_conf::INSTALL_DIR, "", self::$uri);
        self::$uri  = preg_replace("/\?.*/", "", self::$uri);
        if (self::$uri == "/") //主页模块为index
        {
            self::$uri = "/index";
        }
        self::$method           = $_SERVER['REQUEST_METHOD'];
        self::$arr_get_raw      = $_GET;
        self::$arr_get          = $_GET;
        self::$arr_post_raw     = $_POST;
        self::$arr_post         = $_POST;
        self::$arr_cookie_raw   = $_COOKIE;
        self::$arr_cookie       = $_COOKIE;
        if (get_magic_quotes_gpc())
        {
            apply_func_recursive("stripslashes", self::$arr_get);
            apply_func_recursive("stripslashes", self::$arr_post);
            apply_func_recursive("stripslashes", self::$arr_cookie);
        }
        self::$logid = crc32(time() + ip2long($_SERVER['REMOTE_ADDR'])) & 0x7FFFFFFF;
    }
}

?>
