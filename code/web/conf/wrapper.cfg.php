<?php

final class wrapper_conf
{
    const LOG_PATH      = "/home/www-data/starter/woj/log/wrapper.log";
    const DATA_PATH     = "/home/www-data/starter/woj/data";
    const TEMP_PATH     = "/home/www-data/starter/woj/temp";
    const JUDGE_PATH_ROOT    = "/home/www-data/starter/learn/code/judge/";

    public static $judge_path = 'judge_all.exe';
    public static $extension = array(
        land_conf::LANG_C       => 'c',
        land_conf::LANG_CPP     => 'cpp',
        land_conf::LANG_JAVA    => 'java',
        land_conf::LANG_PASCAL  => 'pas',
        );
}

?>
