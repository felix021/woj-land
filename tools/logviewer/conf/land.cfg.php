<?php

final class log_conf {

    static $cmd       = "tail -f";

    static $watch_arr = array(); //Ĭ�ϵ�watch�б�

    //preg_replace ����
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

    //preg_replace_callback����
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

    //Ĭ�������ļ�·��
    static $log_files = array(
            '/home/felix021/woj/log/php.log',
            '/home/felix021/woj/log/judge.log',
            );

    //hook��������
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
	//�ڸ�������������ļ���ʱ��ִ��
}

function hook_begin() {
	//�����ö���ʼ����֮��ִ��
}

function hook_pre_main() {
	//�ڿ�ʼѭ����������֮ǰ
}

function hook_pre_process() {
	//�ڶ���һ�����ݿ�ʼ����֮ǰ
	//runtime::$buf = '';
}

function hook_pre_output() {
	//�����һ������֮ǰ
	//runtime::$buf = '';
}

function hook_post_output() {
	//�����һ������֮��
	//runtime::$buf = '';
}

function hook_end() {
	//��ѭ������֮��,�����˳�֮ǰ
	//do sth you want before program exits
}

?>
