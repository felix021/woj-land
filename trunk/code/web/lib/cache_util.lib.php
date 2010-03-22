<?php

class cache_util
{

    public static $name_to_func = array(
        'diligent'  =>  'generate_diligent',
    );

    public static function load($name)
    {
        if (!isset(self::$name_to_func[$name]))
        {
            FM_LOG_WARNING("unknown cache name");
            throw new Exception("");
        }

        $filename = self::name_to_file($name);

        FM_LOG_TRACE("cache file: %s", $filename);

        $data = null;
        if (!file_exists($filename))
        {
            if (function_exists(self::$name_to_func[$name]))
            {
                $data = call_user_func(self::$name_to_func[$name]);
                self::save($name, $data);
            }
            else
            {
                FM_LOG_WARNING("bad func for cache $name");
                throw new Exception("");
            }
        }
        else
        {
            $str = file_get_contents($filename);
            FM_LOG_DEBUG("read: %s", $str);
            $data = json_decode($str);
        }
        FM_LOG_DEBUG("get data: $name = %s", print_r($data, true));
        return $data;
    }

    public static function save($name, $data)
    {
        $filename = self::name_to_file($name);
        $str = json_encode($data);
        file_put_contents($filename, $data);
    }

    private static function name_to_file($name)
    {
        $filename = CACHE_ROOT . "/" . $name . ".cache.php";
        return $filename;
    }
}

?>
