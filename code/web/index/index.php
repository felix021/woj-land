<?php
/*
 * 所有请求从这里开始
 */
ob_start();
session_start();

if (!defined("ROOT"))
{
    define("ROOT",          dirname(dirname(__FILE__)));
    define("CONF_ROOT",     ROOT . "/conf");
    define("MODULE_ROOT",   ROOT . "/module");
    define("LIB_ROOT",      ROOT . "/lib");
    define("TPL_ROOT",      ROOT . "/tpl");
    define("CACHE_ROOT",    ROOT . "/cache");
}

require_once(CONF_ROOT . "/land.cfg.php");
require_once(CONF_ROOT . "/wrapper.cfg.php");
error_reporting(land_conf::ERROR_REPORT_LEVEL);
date_default_timezone_set(land_conf::TIMEZONE);

require_once(LIB_ROOT . "/logger.lib.php");
require_once(LIB_ROOT . "/misc.lib.php");
require_once(LIB_ROOT . "/db.lib.php");
require_once(LIB_ROOT . "/request.lib.php");
require_once(LIB_ROOT . "/session.lib.php");
require_once(LIB_ROOT . "/response.lib.php");
require_once(LIB_ROOT . "/cache_util.lib.php");
require_once(LIB_ROOT . "/frame/cframe_loader.lib.php");
require_once(LIB_ROOT . "/template/ctemplate.lib.php");
require_once(LIB_ROOT . "/template/ctemplate_run.lib.php");

set_error_handler('land_err_handler');

try
{
    if (false === logger::log_open(land_conf::LOG_FILE))
    {
        throw Exception();
    }

    request::init();

    logger::log_add_info('logid:' . request::$logid);
    logger::log_add_info('ip:' . request::$client_ip);
    logger::log_add_info('uri:' . request::$uri);

    session::init(session::DO_UPDATE);

    $dispatch_filename = MODULE_ROOT . request::$uri .
        '/' . strtolower(request::$method) . '.php';
    FM_LOG_TRACE('after dispatch: %s', $dispatch_filename);

    if (!is_readable($dispatch_filename))
    {
        FM_LOG_WARNING("$dispatch_filename is not readable");
        throw new Exception('This page does not exist in Land. Maybe it\'s still on noah\'s ark?');
    }
    require_once($dispatch_filename);
    $cf       = cframe_loader::run(land_conf::DEFAULT_CFRAME_CLASS);

    response::display();
}
catch (Exception $e)
{
    if (logger::log_opened())
    {   
        FM_LOG_WARNING('Exception [%s:%d]: (%d)%s',
            $e->getFile(), $e->getLine(), $e->getCode(), $e->getMessage());
    }   

    response::display_err($e->getMessage());
}

?>
