<?php

require_once("ctemplate.lib.php");

class ctemplate_loader
{
    public static $tpl_file;
    public static $arr_data;

    public static function run($filename, $classname)
    {
        self::$tpl_file = $filename;
        self::$arr_data = response::$arr_data;

        if (!file_exists(self::$tpl_file))
        {
            self::$tpl_file = TPL_ROOT . $filename;
        }
        if (!file_exists(self::$tpl_file))
        {
            self::$tpl_file = ROOT . $filename;
        }
        
        if (!is_readable(self::$tpl_file))
        {
            FM_LOG_WARNING("tpl file: %s is not readable", self::$tpl_file);
            throw Exception("bad tpl");
        }
        FM_LOG_TRACE("load template: %s", self::$tpl_file);
        require_once(self::$tpl_file);
        if (!class_exists($classname))
        {
            FM_LOG_WARNING("class: %s missing", $classname);
            throw Exception("bad tpl");
        }
        $tpl = new $classname();
        if (!($tpl  instanceof itemplate))
        {
            FM_LOG_WARNINIG("tpl class not implemented itemplate");
            throw Exception("bad tpl");
        }
        $tpl->display(self::$arr_data);
    }
}

?>
