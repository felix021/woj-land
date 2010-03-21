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

    //�ȴ��û�����
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

felix����־�鿴��

ʹ�÷���: 
$cmd [-W] [-w WATCH_STR] [-t LOG_TYPE] [-c CMD] [-h] [log_file_list]
    -W
       ����WATCHģʽ��WATCH_STRʹ�������ļ��е�Ĭ�����á�
    -w WATCH_STR
       ��ĳһ������WATCH_STRʱ��ͣ����������ж��-wѡ�
       ���ָ����-w�������ʡ��-W
    -t LOG_TYPE
       ��־�ļ����ͣ���Ӧ��ROOT_DIR/conf/LOG_TYPE.cfg.php�ļ�������
       ��ǰ��ROOT_DIRΪ��$root
	-c CMD
	   ָ��logviewer��װ�ĳ���(���Դ�����)
    -h 
       ��ʾ�˰�����
    log_file_list
       ��־�ļ��б�����ʹ��ͨ����������ָ������ʹ�������е����á�

ע�⣬�ļ��б����������ѡ��֮�󣬷�����������Ԥ��֮�е������������롣
       
�����ļ���php�������ʽ�����conf/Ŀ¼�£�����־���ͷ��ļ���ţ������ļ�
�ĸ�ʽ���Ĭ�ϸ�ʽ����land.cfg.php��


eot;
        exit;
    }

}



?>
