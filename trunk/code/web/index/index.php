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
error_reporting(land_conf::ERROR_REPORT_LEVEL);

require_once(LIB_ROOT . "/logger.lib.php");
require_once(LIB_ROOT . "/misc.lib.php");
require_once(LIB_ROOT . "/request.lib.php");
require_once(LIB_ROOT . "/session.lib.php");
require_once(LIB_ROOT . "/response.lib.php");
require_once(LIB_ROOT . "/cache_util.lib.php");
require_once(LIB_ROOT . "/frame/cframe_loader.lib.php");
require_once(LIB_ROOT . "/template/ctemplate.lib.php");
require_once(LIB_ROOT . "/template/ctemplate_run.lib.php");

try
{
    if (false === logger::log_open(land_conf::LOG_FILE))
    {
        throw Exception();
    }

    request::init();
    session::init();

    logger::log_add_info('logid:' . request::$logid);
    logger::log_add_info('ip:' . $_SERVER['REMOTE_ADDR']);
    logger::log_add_info('uri:' . request::$uri);

    $dispatch_filename = MODULE_ROOT . request::$uri .
        '/' . strtolower(request::$method) . '.php';
    FM_LOG_TRACE('after dispatch: %s', $dispatch_filename);

    if (!is_readable($dispatch_filename))
    {
        FM_LOG_WARNING("$dispatch_filename is not readable");
        throw new Exception('This page does not exists in Land.');
    }
    require_once($dispatch_filename);
    $cf       = cframe_loader::run(land_conf::DEFAULT_CFRAME_CLASS);

    response::display();
}
catch (Exception $e)
{
    response::add_header("HTTP/1.1 403 Not Permitted");
    $p = array(
        'errmsg'    => $e->getMessage(),
        'links'     => array(
                'Go Back'  =>  'javascript:history.back(1)',
            ),
        );
    response::set_data_arr($p);
    response::set_tpl(TPL_ROOT . "/error.tpl.php");
    response::display();
}

?>
