<?php
/*
 * 所有请求从这里开始
 */

if (!defined("ROOT"))
{
    define("ROOT",          dirname(dirname(__FILE__)));
    define("CONF_ROOT",     ROOT . "/conf");
    define("MODULE_ROOT",   ROOT . "/module");
    define("LIB_ROOT",      ROOT . "/lib");
}

ob_start();
session_start();
error_reporting(E_WARNING | E_ERROR | E_ALL);

require_once(LIB_ROOT . "/log/logger.lib.php");
require_once(LIB_ROOT . "/misc.lib.php");
require_once(LIB_ROOT . "/request.lib.php");

request::init();

if (false === logger::log_open("/home/acm/woj/log/php.log"))
{
    echo "errno: ", logger::$err_info[logger::$errno], "\n";
}

logger::log_add_info("ip: " . $_SERVER['REMOTE_ADDR']);
logger::log_add_info("logid: " . request::$logid);

FM_LOG_TRACE("ooxx");

?>
