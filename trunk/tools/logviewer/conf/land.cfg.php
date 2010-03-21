<?php

final class log_conf {

    static $cmd       = "tail -f";

    static $watch_arr = array(); //默认的watch列表

    //preg_replace 配置
    static $pattern   = array(
            '/^(DEBUG)/',
            '/^(TRACE)/',
            '/^(NOTICE)/',
            '/^(WARNING)/',
            '/^(FATAL)/',
            '/^(MONITOR)/',
            '/^(==\>.*\<==)$/',
            '/logid:\d*/',
            '/\[(uid:.*?)\]/',
            );
    static $replace   = array( 
            "\x1b[31m\\1\x1b[0m",
            "\x1b[32m\\1\x1b[0m",
            "\x1b[33m\\1\x1b[0m",
            "\x1b[34m\\1\x1b[0m",
            "\x1b[35m\\1\x1b[0m",
            "\x1b[36m\\1\x1b[0m",
            "\x1b[41m\\1\x1b[0m",
            "\x1b[32m\\0\x1b[0m",
            "[\x1b[32m\\1\x1b[0m]",
            );

    //preg_replace_callback配置
    static $callback = array( 
            array(
                'pattern'   => '/\[([^:]*?):(\d*?)\]/',
                'replace'   => 'filepath',
                ),
            array(
                'pattern'   => '/\[ \x7uri:(\S*?) \x7\]/',
                'replace'   => 'hl_uri',
                ),
            );

    //默认配置文件路径
    static $log_files = array(
            '/home/felix021/woj/log/php.log',
            '/home/felix021/woj/log/judge.log',
            );

    //hook函数配置
    static $hook_func   = array(
            'very_first'    => array(),
            'begin'         => array(),
            'pre_main'      => array(),
            'pre_process'   => array(),
            'pre_output'    => array(),
            'post_output'   => array(),
            'end'           => array(),
            );
}

function filepath($x) {
    $ext = strrchr(basename($x[1]), ".");
    if (is_file($x[1]) || $ext == ".h" || $ext == ".cpp" || $ext == ".php") {
        $x[1] = preg_replace("/^.*?web\//", "", $x[1]);
        return "[" . util::color($x[1], 33) . ":" . util::color($x[2], 33) . "]";
    }
    return $x[0];
}

function hl_uri($x) {
    return "[ \x7" . util::color("uri", 35) . ":" . util::color($x[1], 35) . " \x7]";
}

function hook_very_begin() {
	//在刚载入这个配置文件的时候执行
}

function hook_begin() {
	//在配置都初始化完之后执行
}

function hook_pre_main() {
	//在开始循环读入数据之前
}

function hook_pre_process() {
	//在读入一行数据开始处理之前
	//runtime::$buf = '';
}

function hook_pre_output() {
	//在输出一行数据之前
	//runtime::$buf = '';
}

function hook_post_output() {
	//在输出一行数据之后
	//runtime::$buf = '';
}

function hook_end() {
	//在循环结束之后,程序退出之前
	//do sth you want before program exits
}

?>
