#ifndef __JUDGE_H__
#define __JUDGE_H__

#include <iostream>
#include <string>
extern "C" 
{
#include "logger.h"
#include <unistd.h>
}

using namespace std;

namespace judge_conf
{
    //编译限制5s
    int compile_time_limit          = 5; 

    //程序的主目录(考虑做成配置)
    string  root_dir                = "/home/user/felix021/woj";

    const std::string log_dir       = "/log";

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

    //退出原因
    const int EXIT_OK           = 0;
    const int EXIT_BAD_PARAM    = 2;
    const int EXIT_UNKNOWN      = 127;

    const string languages[]    = {"unknown", "c", "c++", "java", "pascal"};
};

namespace problem
{
    int id                  = 0;
    int lang                = 0;
    int time_limit          = 1000;
    int memory_limit        = 65536;
    int output_limit        = 8192;
    int result              = 0;
    int status;

    bool spj                = false;

    std::string temp_dir;
    std::string data_dir;
    std::string source_file;
    std::string data_file;
    std::string input_file;
    std::string output_file;

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

    while ((opt = getopt(argc, argv, "s:n:D:d:t:m:o:S")) != -1) {
        switch (opt) {
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
    problem::data_file = problem::data_dir + judge_conf::data_filename;
    problem::dump_to_log();
}

#endif
