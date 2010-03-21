<?php

require_once("iframe.lib.php");
require_once("cframe.lib.php");

class cframe_loader
{
    public static $c;
    
    public static function run()
    {
        $args       = func_get_args();
        self::$c    = self::load($args);
        if (self::$c instanceof iframe)
        {
            try
            {
                FM_LOG_DEBUG("pre_process");
                if (false == self::$c->pre_process())
                {
                    throw new Exception_frame("pre_process");
                }
                FM_LOG_DEBUG("process");
                if (false == self::$c->process())
                {
                    throw new Exception_frame("process");
                }
                FM_LOG_DEBUG("post_process");
                if (false == self::$c->post_process())
                {
                    throw new Exception_frame("post_process");
                }

                FM_LOG_DEBUG("display");
                if (false == self::$c->display())
                {
                    throw new Exception_frame("display");
                }

                FM_LOG_TRACE("cframe_loader finished succussfully");
            }
            catch(Exception_frame $e)
            {
                FM_LOG_WARNING('error generated at ' . $e->getMessage());
                if (false == self::$c->err_handler())
                {
                    FM_LOG_WARNING("err_handler returned false");
                }
            }
        }
        else
        {
            FM_LOG_WARNING("unknown class");
        }
    }

    protected function load($args)
    {
        $class_name = array_shift($args);
        if (count($args) == 0)
        {
            $c = new $class_name();
        }
        else
        {
            $count = array_shift($args);
            switch ($count)
            {
            case 0:
                $c = new $class_name();
            case 1:
                $c = new $class_name($args[0]);
                break;
            case 2:
                $c = new $class_name($args[0], $args[1]);
                break;
            default:
                FM_LOG_WARNING("unsupported args_number: %s", $count);
            }
        }
        return $c;
    }
}

?>
