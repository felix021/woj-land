<?php
/* vim: set cindent filetype=php: */
if (!defined("ROOT")) {
    define("ROOT", dirname(dirname(__FILE__)));
}
require_once (ROOT . "/conf/conf.php");

final class util {

    static function color($str, $color = "32") {
        return "\x1b[{$color}m{$str}\x1b[0m";
    }

    static function trace($str) {
        echo self::color("logviewer trace", 31) . ": " . $str;
        if (substr($str, -1) != "\n") echo "\n";
    }
    static function warning($str) {
        echo self::color("logviewer warning", 32) . ": " . $str;
        if (substr($str, -1) != "\n") echo "\n";
    }
    static function fatal($str) {
        echo self::color("logviewer fatal", 33) . ": " . $str;
        if (substr($str, -1) != "\n") echo "\n";
        exit;
    }

    static function process_hook($stage) {
        if (!is_array(conf::$hook_func[$stage])) {
            self::warning("hook $stage is not an array");
            return;
        }
        foreach (conf::$hook_func[$stage] as $func) {
            if (function_exists($func)) {
                call_user_func($func);
            }
            else {
                self::warning("function $func does not exist.");
            }
        }
    }

    //等待用户按键
    static function wait_user() {
        stream_set_blocking(STDIN, 0);
        while(true) {
            $x = fread(STDIN, 1);
            if (empty($x)) break;
        }
        stream_set_blocking(STDIN, 1);
        echo self::color("Press 'Enter' to continue...\n", 36);
        fgets(STDIN);
    }

    static function help() {
        $argv = conf::$argv;
        $root = ROOT;
        $cmd = $argv[0];
        if (dirname(realpath($cmd)) != $root) {
            $cmd = basename($cmd);
        }
        echo <<<eot

felix的日志查看器

使用方法: 
$cmd [-W] [-w WATCH_STR] [-t LOG_TYPE] [-c CMD] [-h] [log_file_list]
    -W
       开启WATCH模式，WATCH_STR使用配置文件中的默认设置。
    -w WATCH_STR
       当某一行中有WATCH_STR时暂停输出。可以有多个-w选项。
       如果指定了-w，则可以省略-W
    -t LOG_TYPE
       日志文件类型，对应于ROOT_DIR/conf/LOG_TYPE.cfg.php文件的配置
       当前的ROOT_DIR为：$root
	-c CMD
	   指定logviewer包装的程序(可以带参数)
    -h 
       显示此帮助。
    log_file_list
       日志文件列表，可以使用通配符。如果不指定，则使用配置中的设置。

注意，文件列表必须在所有选项之后，否则会产生不在预期之中的情况，详见代码。
       
配置文件以php代码的形式存放在conf/目录下，按日志类型分文件存放，配置文件
的格式详见默认格式范例land.cfg.php。


eot;
        exit;
    }

}



?>
