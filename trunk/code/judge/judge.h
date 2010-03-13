#ifndef __JUDGE_H__
#define __JUDGE_H__

#include <iostream>
#include <string>
#include <cstdio>
#include <cstdlib>
#include <cstring>
extern "C" 
{
#include <unistd.h>
#include <sys/time.h>
#include <sys/resource.h>
#include <sys/signal.h>
#include "logger.h"
}

namespace judge_conf
{
    //编译限制(ms)
    int compile_time_limit          = 5000;

    //程序运行的栈空间大小(KB)
    int stack_size_limit            = 4096;

    //参照Oak的设置，附加一段时间到time_limit里，不把运行时间限制得太死
    int time_limit_addtion          = 314;

    //程序的主目录(考虑做成配置)
    std::string root_dir             = "/home/felix021/woj";

    const std::string log_file       = "/log/judge.log";

    //临时文件夹
    const std::string temp_dir      = "/temp";

    //输入文件列表文件名
    const std::string data_filename = "data.txt"; 


    //OJ结果代码
    const int OJ_WAIT           = 0; //Queue
    const int OJ_AC             = 1; //Accepted
    const int OJ_PE             = 2; //Presentation Error
    const int OJ_TLE            = 3; //Time Limit Exceeded
    const int OJ_MLE            = 4; //Memory Limit Exceeded
    const int OJ_WA             = 5; //Wrong Answer
    const int OJ_OLE            = 6; //Output Limit Exceeded
    const int OJ_CE             = 7; //Compilation Error
    const int OJ_RE_SEGV        = 8; //Segment Violation
    const int OJ_RE_FPE         = 9; //FPU Error
    const int OJ_RE_BUS         = 10;//Bus Error
    const int OJ_RE_ABRT        = 11;//Abort
    const int OJ_RE_UNKNOWN     = 12;//Unknow
    const int OJ_RF             = 13;//Restricted Function
    const int OJ_SE             = 14;//System Error

    //一些常量
    const int KILO              = 1024;         // 1K
    const int MEGA              = KILO * KILO;  // 1M
    const int GIGA              = KILO * MEGA;  // 1G

    const int GCC_COMPILE_ERROR = 1;

    //退出原因
    const int EXIT_OK               = 0;
    const int EXIT_BAD_PARAM        = 3;
    const int EXIT_COMPILE          = 6;
    const int EXIT_PRE_JUDGE        = 9;
    const int EXIT_PRE_JUDGE_PTRACE = 10;
    const int EXIT_PRE_JUDGE_EXECLP = 11;
    const int EXIT_SET_LIMIT        = 15;
    const int EXIT_JUDGE            = 21;
    const int EXIT_COMPARE          = 27;
    const int EXIT_UNKNOWN          = 127;

    const std::string languages[]    = {"unknown", "c", "c++", "java", "pascal"};
    const int LANG_UNKNOWN      = 0;
    const int LANG_C            = 1;
    const int LANG_CPP          = 2;
    const int LANG_JAVA         = 3;
    const int LANG_PASCAL       = 4;
};

namespace problem
{
    int id                  = 0;
    int lang                = 0;
    int time_limit          = 1000;
    int memory_limit        = 65536;
    int output_limit        = 8192;
    int result              = 0; //初始化为0比较好, 嗯
    int status;

    long memory_usage       = 0;
    int time_usage          = 0;

    bool spj                = false;

    std::string uid; //会追加到日志中的唯一编号，可选

    std::string temp_dir;
    std::string data_dir;

    std::string stdout_file_compiler;
    std::string stderr_file_compiler;

    std::string source_file;
    std::string exec_file;

    std::string data_file;
    std::string input_file;
    std::string output_file_std;

    std::string stdout_file_executive;
    std::string stderr_file_executive;

    void dump_to_log()
    {
        FM_LOG_DEBUG("--problem information--");
        FM_LOG_DEBUG("id            %d", id);
        FM_LOG_DEBUG("lang          %s", judge_conf::languages[lang].c_str());
        FM_LOG_DEBUG("time_limit    %d", time_limit);
        FM_LOG_DEBUG("memory_limit  %d", memory_limit);
        FM_LOG_DEBUG("output_limit  %d", output_limit);
        FM_LOG_DEBUG("spj           %s", spj ? "true" : "false");
        FM_LOG_DEBUG("temp_dir      %s", temp_dir.c_str());
        FM_LOG_DEBUG("data_dir      %s", data_dir.c_str());
        FM_LOG_DEBUG("source_file   %s", source_file.c_str());
        FM_LOG_DEBUG("data_file     %s", data_file.c_str());
        FM_LOG_DEBUG("");
    }
};

void parse_arguments(int argc, char *argv[])
{
    int opt;
    extern char *optarg;

    while ((opt = getopt(argc, argv, "u:s:n:D:d:t:m:o:S")) != -1) {
        switch (opt) {
            case 'u': problem::uid          = optarg;       break;
            case 's': problem::source_file  = optarg;       break;
            case 'n': problem::id           = atoi(optarg); break;
            case 'D': problem::data_dir     = optarg;       break;
            case 'd': problem::temp_dir     = optarg;       break;
            case 't': problem::time_limit   = atoi(optarg); break;
            case 'm': problem::memory_limit = atoi(optarg); break;
            case 'o': problem::output_limit = atoi(optarg); break;
            case 'S': problem::spj          = true;         break;
            default:
                FM_LOG_WARNING("unknown option provided: -%c %s", opt, optarg);
                exit(judge_conf::EXIT_BAD_PARAM);
        }
    }
    problem::data_file              = problem::data_dir + "/" + judge_conf::data_filename;
    problem::exec_file              = problem::temp_dir + "/" + "a.out";
    problem::stdout_file_compiler   = problem::temp_dir + "/" + "stdout_compiler.txt";
    problem::stderr_file_compiler   = problem::temp_dir + "/" + "stderr_compiler.txt";
    problem::stdout_file_executive  = problem::temp_dir + "/" + "stdout_executive.txt";
    problem::stderr_file_executive  = problem::temp_dir + "/" + "stderr_executive.txt";
    if (false == problem::uid.empty())
    {
        //在log中自动记录uid
        log_add_info(("uid:" + problem::uid).c_str());
    }
    problem::dump_to_log();
}

//a simpler interface for setitimer
//which can be ITIMER_REAL, ITIMER_VIRTUAL, ITIMER_PROF
bool malarm(int which, int milliseconds)
{
    struct itimerval t;
    FM_LOG_TRACE("malarm: %d", milliseconds);
    t.it_value.tv_sec       = milliseconds / 1000;
    t.it_value.tv_usec      = milliseconds % 1000 * 1000; //微秒
    t.it_interval.tv_sec    = 0;
    t.it_interval.tv_usec   = 0;
    return setitimer(which, &t, NULL);
}

void io_redirect()
{
    //io_redirect
    stdin  = freopen(problem::input_file.c_str(), "r", stdin);
    stdout = freopen(problem::stdout_file_executive.c_str(), "w", stdout);
    stderr = freopen(problem::stderr_file_executive.c_str(), "w", stderr);
    if (stdin == NULL || stdout == NULL || stderr == NULL)
    {
        FM_LOG_WARNING("error freopen: stdin(%p) stdout(%p), stderr(%p)",
                stdin, stdout, stderr);
        exit(judge_conf::EXIT_PRE_JUDGE);
    }
    FM_LOG_TRACE("io redirect ok!");
}


void set_limit()
{

    rlimit lim;

    //时间限制, 秒, 向上取整 
    lim.rlim_max = (problem::time_limit - problem::time_usage + 999) / 1000 + 1; //硬限制 
    lim.rlim_cur = lim.rlim_max; //软限制
    if (setrlimit(RLIMIT_CPU, &lim) < 0)
    {
        FM_LOG_WARNING("error setrlimit for RLIMIT_CPU");
        exit(judge_conf::EXIT_SET_LIMIT);
    }

/*
    //内存限制
    //在这里进行内存限制可能导致MLE被判成RE
    //所以改成在每次wait以后计算缺页中断的次数
    lim.rlim_max = memlimit * judge_conf::KILO;
    lim.rlim_cur = memlimit * judge_conf::KILO;
    if (setrlimit(RLIMIT_AS, &lim) < 0)  
    {
        perror("setrlimit");
        exit(judge_conf::EXIT_SET_LIMIT);
    }
*/

    //堆栈空间限制
    lim.rlim_max = judge_conf::stack_size_limit * judge_conf::KILO;
    lim.rlim_cur = lim.rlim_max;
    if (setrlimit(RLIMIT_STACK, &lim) < 0)
    {
        FM_LOG_WARNING("setrlimit RLIMIT_STACK failed");
        exit(judge_conf::EXIT_SET_LIMIT);
    }

    //输出文件大小限制
    lim.rlim_max = problem::output_limit * judge_conf::KILO;
    lim.rlim_cur = lim.rlim_max;
    if (setrlimit(RLIMIT_FSIZE, &lim) < 0)
    {
        FM_LOG_WARNING("setrlimit RLIMIT_FSIZE failed");
        exit(judge_conf::EXIT_SET_LIMIT);
    }

    FM_LOG_TRACE("set limit ok");
}

int oj_compare_output(std::string file_std, std::string file_exec)
{
    FM_LOG_TRACE("start compare");
    FILE *fp_std = fopen(file_std.c_str(), "r");
    if (fp_std == NULL)
    {
        FM_LOG_WARNING("open standard output failed");
        exit(judge_conf::EXIT_COMPARE);
    }
    FILE *fp_exe = fopen(file_exec.c_str(), "r");
    if (fp_exe == NULL)
    {
        FM_LOG_WARNING("open executive's output failed");
        exit(judge_conf::EXIT_COMPARE);
    }
    int a, b;
    enum {
        AC = judge_conf::OJ_AC,
        PE = judge_conf::OJ_PE,
        WA = judge_conf::OJ_WA
    } status = AC;
    while (true)
    {
        a = fgetc(fp_std);
        b = fgetc(fp_exe);
        if (feof(fp_std) && feof(fp_exe))
        {
            //如果两个文件都已经结束, 退出循环
            break;
        }

        //如果两个字符不同，
        if (a != b)
        {
            status = PE; //可能是PE，再继续检测是否是WA
#define is_space_char(a) ((a == ' ') || (a == '\t') || (a == '\r') || (a == '\n'))
            //过滤空白字符
            if (is_space_char(a) && is_space_char(b))
            {
                //两个都是空白字符, 都过滤
                continue;
            }
            if (is_space_char(a))
            {
                //a是空白字符, 过滤, 退回b以便下一轮循环
                ungetc(b, fp_exe);
            }
            else if (is_space_char(b))
            {
                //b是空白字符, 过滤, 退回a以便下一轮循环
                ungetc(a, fp_std);
            }
            else
            {
                //如果两个都不是空白字符且不相等, 就是WA
                status = WA;
                break;
            }
        }
    }
    fclose(fp_std);
    fclose(fp_exe);
    FM_LOG_TRACE("compare over, result = %s",
            status == AC ? "AC" : (status == PE ? "PE" : "WA"));
    return status;
}

//输出最终结果
void output_result(int result, int memory_usage = 0, int time_usage = 0)
{
    FM_LOG_TRACE("result: %d, %dKB, %dms", result, memory_usage, time_usage);
    printf("%d %d %d", result, memory_usage, time_usage);
}
#endif
