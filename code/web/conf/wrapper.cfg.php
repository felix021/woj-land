<?php

final class wrapper_conf
{
    const LOG_PATH      = "/home/felix021/woj/log/wrapper.log";
    const DATA_PATH     = "/home/felix021/woj/data";
    const TEMP_PATH     = "/home/felix021/woj/temp";

    public static $extension = array(
        land_conf::LANG_C       => 'c',
        land_conf::LANG_CPP     => 'cpp',
        land_conf::LANG_JAVA    => 'java',
        land_conf::LANG_PASCAL  => 'pas',
        );

    const JUDGE_PATH_ROOT    = "/home/felix021/svn/woj-land/code/judge/";
    public static $judge_path = array(
        land_conf::LANG_C       => 'judge_c.exe',
        land_conf::LANG_CPP     => 'judge_cpp.exe',
        land_conf::LANG_JAVA    => 'judge_java.exe',
        land_conf::LANG_PASCAL  => 'judge_pascal.exe',
        _);
}

?>
