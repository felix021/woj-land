<?php
/* vim: set cindent filetype=php: */
if (!defined("ROOT")) {
    define("ROOT", dirname(dirname(__FILE__)));
}

require_once (ROOT . "/inc/util.inc.php");

final class conf {

    static $watch_mode  = false;
    static $watch_arr   = array();

    static $userconf    = "";
    static $log_type    = "land"; //默认类型
    static $default_cmd = "tail -f";

    static $opt         = array();
    static $shortopt    = "Ww:ht:c:"; //watch, help, type, cmd
    static $argc_start  = 1;
    static $argc_end    = 1;
    static $log_files   = array();
    static $argc        = 0;
    static $argv        = array();

    static $hook_func   = array(
            'very_begin'    => array(),
            'begin'         => array(),
            'pre_main'      => array(),
            'pre_process'   => array(),
            'pre_output'    => array(),
            'post_output'   => array(),
            'end'           => array(),
            );

    static function init() {
        global $argc, $argv;

        //个人配置文件所在目录
        self::$userconf = "/home/" . get_current_user() . "/.logviewer/";
        if (!file_exists(self::$userconf)) {
            $dir = self::$userconf;
            @`mkdir -p "$dir"`;
        }

        self::$argc = $argc;
        self::$argv = $argv;

        //全部opt都转为数组
        $opt = getopt(self::$shortopt);
        if (false === $opt || !is_array($opt)) {
            util::fatal("getopt failed.");
        }
        self::$opt = $opt;

        if (isset($opt['h'])) {
            util::help();
            exit;
        }

        if (isset($opt['W'])) {
            self::$watch_mode = true;
        }

        foreach($opt as $key => $value) {
            if (!is_array($value)) {
                $opt[$key] = array($value);
            }
            if (is_bool($value)) {
                self::$argc_start++; //不需要参数的
            }
            else {
                self::$argc_start += count($opt[$key]) * 2; //带参数的
            }
        }
        self::$argc_end = $argc;

        //----
        //日志类型
        if (isset($opt['t'])) {
            $log_type = $opt['t'][0];
        }
        else {
            $log_type = self::$log_type;
            util::trace("log_type not specified, use default value $log_type.");
        }
        $fullpath = ROOT . '/conf/' . $log_type . '.cfg.php';

        if (is_readable($fullpath)) {
            include_once ($fullpath);
        }
        else {
            util::fatal("default config file $fullpath is not readable, either.");
        }

        if (!class_exists("log_conf")) {
            util::fatal("class log_conf not exists.");
        }

		util::process_hook("very_begin");

        //默认命令
        if (isset(log_conf::$cmd) && !empty(log_conf::$cmd)) {
            self::$default_cmd = log_conf::$cmd;
        }

		if (isset($opt['c'])) {
			self::$default_cmd = $opt['c'][0];
		}

        //----
        //日志文件列表
        //如果当前没有给出列表，则使用配置中的默认设置
        if (self::$argc_start >= self::$argc_end && is_array(log_conf::$log_files)) {
            self::$argv = array_merge(self::$argv, log_conf::$log_files);
            self::$argc_end += count(log_conf::$log_files);
        }
        //收集可以读取的文件列表
        for ($i = self::$argc_start; $i < self::$argc_end; $i++) {
            $fn = self::$argv[$i];
            if (!is_readable($fn)) {
                util::warning("file $fn is not readable.");
                continue;
            }
            self::$log_files[] = self::$argv[$i];
        }
        if (count(self::$log_files) == 0) {
            util::fatal("no readable log file specified");
        }

        //----
        //配置文件中的watch_arr
        if (isset(log_conf::$watch_arr)) {
            if (is_array(log_conf::$watch_arr) && count(log_conf::$watch_arr) > 0) {
                self::$watch_arr = array_merge(self::$watch_arr, log_conf::$watch_arr);
            }
        }

        //watch_arr in argv
        if (isset($opt['w'])) {
            self::$watch_mode = true;
            self::$watch_arr = array_merge(self::$watch_arr, array_unique($opt['w']));
        }

        if (!is_array(self::$watch_arr) || count(self::$watch_arr) == 0) {
            if (self::$watch_mode == true) {
                util::warning("no watch specified, watch_mode turned off.");
            }
            self::$watch_mode = false;
        }

        if (is_array(log_conf::$hook_func)) {
            foreach (log_conf::$hook_func as $key => $value) {
                if (isset(self::$hook_func[$key]) && is_array($value)) {
                    self::$hook_func[$key] = array_merge(self::$hook_func[$key], $value);
                }
            }
        }
    }
}

?>
