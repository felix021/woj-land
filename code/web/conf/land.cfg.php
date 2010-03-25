<?php

final class land_conf
{
    const DAEMON_HOST           = '127.0.0.1';
    const DAEMON_PORT           = 9528;
    const DAEMON_TIME_OUT       = 5; //seconds

    const LOG_FILE              = "/home/felix021/woj/log/php.log";

    const ERROR_REPORT_LEVEL    = E_ALL;

    const DEFAULT_CFRAME_CLASS  = "Main";
    const DEFAULT_TPL_CLASS     = "TPL_Main";

    const DEBUG                 = true;

    const STAY_TIME             = 3; //seconds before refresh

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

    //status
    const STATUS_PER_PAGE       = 20;
    const OJ_WAIT               = 0; //Queue
    const OJ_AC                 = 1; //Accepted
    const OJ_PE                 = 2; //Presentation Error
    const OJ_TLE                = 3; //Time Limit Exceeded
    const OJ_MLE                = 4; //Memory Limit Exceeded
    const OJ_WA                 = 5; //Wrong Answer
    const OJ_OLE                = 6; //Output Limit Exceeded
    const OJ_CE                 = 7; //Compilation Error
    const OJ_RE_SEGV            = 8; //Segment Violation
    const OJ_RE_FPE             = 9; //FPU Error
    const OJ_RE_BUS             = 10;//Bus Error
    const OJ_RE_ABRT            = 11;//Abort
    const OJ_RE_UNKNOWN         = 12;//Unknow
    const OJ_RF                 = 13;//Restricted Function
    const OJ_SE                 = 14;//System Error
    public static $result_name  = array(
        self::OJ_WAIT               => "Queuing",
        self::OJ_AC                 => "Accepted",
        self::OJ_PE                 => "Presentation Error",
        self::OJ_TLE                => "Time Limit Exceeded",
        self::OJ_MLE                => "Memory Limit Exceeded",
        self::OJ_WA                 => "Wrong Answer",
        self::OJ_OLE                => "Output Limit Exceeded",
        self::OJ_CE                 => "Compilation Error",
        self::OJ_RE_SEGV            => "Runtime Error(Segment Violation)",
        self::OJ_RE_FPE             => "Runtime Error(FPU Error)",
        self::OJ_RE_BUS             => "Runtime Error(Bus Error)",
        self::OJ_RE_ABRT            => "Runtime Error(Aborted)",
        self::OJ_RE_UNKNOWN         => "Runtime Error(Unknown)",
        self::OJ_RF                 => "Restricted Function",
        self::OJ_SE                 => "System Error",
        );

    public static $result_color = array(
        self::OJ_WAIT               => "black",
        self::OJ_AC                 => "red",
        self::OJ_PE                 => "green",
        self::OJ_TLE                => "green",
        self::OJ_MLE                => "green",
        self::OJ_WA                 => "green",
        self::OJ_OLE                => "green",
        self::OJ_CE                 => "green",
        self::OJ_RE_SEGV            => "green",
        self::OJ_RE_FPE             => "green",
        self::OJ_RE_BUS             => "green",
        self::OJ_RE_ABRT            => "green",
        self::OJ_RE_UNKNOWN         => "green",
        self::OJ_RF                 => "green",
        self::OJ_SE                 => "green",
        );

}
?>
