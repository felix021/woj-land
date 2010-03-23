<?php

final class land_conf
{
    const LOG_FILE              = "/home/felix021/woj/log/php.log";
    const ERROR_REPORT_LEVEL    = E_ALL;
    const DEFAULT_CFRAME_CLASS  = "Main";
    const DEFAULT_TPL_CLASS     = "TPL_Main";
    const DEBUG                 = true;

    public static $web_root     = "/land";

    const LANG_UNKNOWN          = 0;
    const LANG_C                = 1;
    const LANG_CPP              = 2;
    const LANG_JAVA             = 3;
    const LANG_PASCAL           = 4;
    public static $lang         = array(
        self::LANG_C        => 'C',
        self::LANG_CPP      => 'C++',
        self::LANG_JAVA     => 'Java',
        self::LANG_PASCAL   => 'Pascal',
        );

    //problems
    const PROBLEMS_PER_VOLUME   = 100;
    const MIN_PROBLEM_ID        = 1001;
}
?>
