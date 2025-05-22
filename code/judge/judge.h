#ifndef __JUDGE_H__
#define __JUDGE_H__

#include <iostream>
#include <string>
#include <cstdio>
#include <cstdlib>
#include <cstring>
#include <cctype>
extern "C" 
{
#include <unistd.h>
#include <sys/time.h>
#include <sys/resource.h>
#include <sys/signal.h>
#include <sys/wait.h>
#include <errno.h>
#include <pwd.h>
#include <sys/types.h>
#include <grp.h>
#include <fcntl.h>      // For open
#include <sys/stat.h>   // For fstat, struct stat
#include <sys/sendfile.h> // For sendfile
#include <strings.h>      // For strncasecmp
#include "logger.h"
}

namespace judge_conf
{
    //配置文件名
    const std::string config_file   = "config.ini";

    //日志文件路径
    std::string log_file;

    //judge本身的时限(ms)           
    int judge_time_limit            = 15000;

    //编译限制(ms)
    int compile_time_limit          = 5000;

    //SPJ时间限制(ms)
    int spj_time_limit              = 5000;

    //程序运行的栈空间大小(KB)
    int stack_size_limit            = 8192;

    //参照Oak的设置，附加一段时间到time_limit里，不把运行时间限制得太死
    int time_limit_addtion          = 314;
    
    int java_time_factor            = 2;
    
    int java_memory_factor          = 2;
    
    void load()
    {
        int n, i, j;

        //获得judge所在的目录
        char buf[1024] = {0};
        n = readlink("/proc/self/exe", buf, sizeof(buf));
        if (n < 0)
        {
            // Note: FM_LOG_FATAL might not be initialized if log_file is in config.
            // So, using fprintf for this very early error.
            fprintf(stderr, "FATAL: Can't read /proc/self/exe to determine judge directory: %s\n", strerror(errno));
            exit(judge_conf::EXIT_VERY_FIRST); // Or a more specific code
        }
        for (i = strlen(buf) - 1; i >= 0 && buf[i] != '/'; i--);
        buf[i + 1] = '\0';

        //拼出config文件的目录
        strncat(buf, judge_conf::config_file.c_str(), sizeof(buf));

        FILE *fp = fopen(buf, "r");
        if (fp == NULL)
        {
            // Note: FM_LOG_FATAL might not be initialized. Using fprintf.
            fprintf(stderr, "FATAL: Can't open configuration file %s: %s\n", buf, strerror(errno));
            exit(judge_conf::EXIT_BAD_PARAM); // Or EXIT_VERY_FIRST
        }
        char line[1024];
        while (true)
        {
            (void) fgets(line, 1023, fp);
            if (feof(fp)) break;
            for (i = 0; line[i] != '\0'; i++)
            {
                if (line[i] == '=') break;
            }

            std::string key;
            char *value = NULL;
            if (line[i] == '=')
            {
                line[i] = 0;
                key = std::string(line);
                for (j = i + 1; line[j] != '\0' && line[j] != '\n'; j++);
                if (line[j] == '\n') line[j] = '\0';
                value = line + i + 1;

                if (key == "log_file")
                {
                    judge_conf::log_file = std::string(value);
                }
                else if (key == "spj_time_limit")
                {
                    judge_conf::spj_time_limit = atoi(value);
                    judge_conf::judge_time_limit += judge_conf::spj_time_limit;
                }
                else
                {
                    // Log will be available after log_file is read from config.
                    // If log_file itself is the unknown param, this won't be logged to file yet.
                    FM_LOG_WARNING("Unknown parameter in config file: %s = %s", key.c_str(), value);
                }
            }
        }
        fclose(fp);
    }

    //--------------以下是常量-------------

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
    const int OJ_RE_JAVA        = 15;//JAVA Run Time Exception
    const int OJ_TLE_COMPILE    = 16;//compiler TLE

    //一些常量
    const int KILO              = 1024;         // 1K
    const int MEGA              = KILO * KILO;  // 1M
    const int GIGA              = KILO * MEGA;  // 1G

    const int GCC_COMPILE_ERROR = 1;

    //退出原因
    const int EXIT_OK               = 0;
    const int EXIT_UNPRIVILEGED     = 1;
    const int EXIT_BAD_PARAM        = 3;
    const int EXIT_VERY_FIRST       = 4;
    const int EXIT_COMPILE          = 6;
    const int EXIT_PRE_JUDGE        = 9;
    const int EXIT_PRE_JUDGE_PTRACE = 10;
    const int EXIT_PRE_JUDGE_EXECLP = 11;
    const int EXIT_SET_LIMIT        = 15;
    const int EXIT_SET_SECURITY     = 17;
    const int EXIT_JUDGE            = 21;
    const int EXIT_COMPARE          = 27;
    const int EXIT_COMPARE_SPJ      = 30;
    const int EXIT_COMPARE_SPJ_FORK = 31;
    const int EXIT_TIMEOUT          = 36;
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
    std::string spj_exe_file;

    std::string data_file;
    std::string input_file;
    std::string output_file_std;

    std::string stdout_file_executive;
    std::string stderr_file_executive;

    std::string stdout_file_spj;

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

    while ((opt = getopt(argc, argv, "l:u:s:n:D:d:t:m:o:S")) != -1) {
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
            case 'l': problem::lang         = atoi(optarg); break;
            default:
                FM_LOG_WARNING("unknown option provided: -%c %s", opt, optarg);
                exit(judge_conf::EXIT_BAD_PARAM);
        }
    }
    switch (problem::lang)
    {
        case judge_conf::LANG_C:
        case judge_conf::LANG_CPP:
        case judge_conf::LANG_PASCAL:
        case judge_conf::LANG_JAVA: 
            break;
        default:
            FM_LOG_WARNING("Bad language specified: %d", problem::lang);
            exit(judge_conf::EXIT_BAD_PARAM);
    }
    problem::data_file              = problem::data_dir + "/" + judge_conf::data_filename;
    problem::exec_file              = problem::temp_dir + "/" + "a.out";
    if(problem::lang == judge_conf::LANG_JAVA) {
        problem::exec_file          = problem::temp_dir + "/" + "Main";
        problem::memory_limit      *= judge_conf::java_memory_factor;
        problem::time_limit        *= judge_conf::java_time_factor;
    }
    problem::stdout_file_compiler   = problem::temp_dir + "/" + "stdout_compiler.txt";
    problem::stderr_file_compiler   = problem::temp_dir + "/" + "stderr_compiler.txt";
    problem::stdout_file_executive  = problem::temp_dir + "/" + "stdout_executive.txt";
    problem::stderr_file_executive  = problem::temp_dir + "/" + "stderr_executive.txt";
    if (problem::spj == true)
    {
        problem::spj_exe_file       = problem::data_dir + "/" + "spj.exe";
        problem::stdout_file_spj    = problem::temp_dir + "/" + "stdout_spj.txt";
    }
    if (false == problem::uid.empty())
    {
        //在log中自动记录uid
        log_add_info(("uid:" + problem::uid).c_str());
    }
    problem::dump_to_log();
}

// Forward declarations of global PIDs from judge_all.cpp for the timeout handler
extern pid_t current_compiler_pid;
extern pid_t current_executive_pid;
extern pid_t current_spj_pid;

void timeout(int signo)
{
    if (signo == SIGALRM)
    {
        FM_LOG_WARNING("Main judge timeout (SIGALRM received). Cleaning up child processes.");

        if (current_compiler_pid > 0)
        {
            FM_LOG_WARNING("Timeout: Killing active compiler process (PID: %d)", current_compiler_pid);
            kill(current_compiler_pid, SIGKILL);
            waitpid(current_compiler_pid, NULL, WNOHANG); // Try to reap
        }
        if (current_executive_pid > 0)
        {
            FM_LOG_WARNING("Timeout: Killing active executive process (PID: %d)", current_executive_pid);
            kill(current_executive_pid, SIGKILL);
            waitpid(current_executive_pid, NULL, WNOHANG); // Try to reap
        }
        if (current_spj_pid > 0)
        {
            FM_LOG_WARNING("Timeout: Killing active SPJ process (PID: %d)", current_spj_pid);
            kill(current_spj_pid, SIGKILL);
            waitpid(current_spj_pid, NULL, WNOHANG); // Try to reap
        }
        
        // It's important to log before exiting, if possible, or ensure logs are flushed.
        // The FM_LOG macros handle this.
        output_result(judge_conf::OJ_TLE, 0, problem::time_limit); // Report TLE for the overall judge
        FM_LOG_FATAL("Judge overall time limit exceeded. Exiting with EXIT_TIMEOUT.");
        exit(judge_conf::EXIT_TIMEOUT);
    }
}

//a simpler interface for setitimer
//which can be ITIMER_REAL, ITIMER_VIRTUAL, ITIMER_PROF
int malarm(int which, int milliseconds)
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
        FM_LOG_FATAL("setrlimit RLIMIT_AS failed: %s", strerror(errno));
        // This part is commented out, but if it were active, it should use FM_LOG_FATAL
        // perror("setrlimit");
        exit(judge_conf::EXIT_SET_LIMIT);
    }
*/
    // Attempt to set RLIMIT_AS (virtual memory limit)
    // This is the primary mechanism to prevent overallocation.
    // If malloc() fails due to this limit, it might return NULL.
    // The program might handle this and exit, or it might crash (e.g. SIGSEGV if it dereferences NULL).
    // The existing page fault counter (ru_minflt) acts as a secondary check,
    // especially if the program doesn't crash but exceeds memory usage patterns.
    lim.rlim_max = (rlim_t)problem::memory_limit * judge_conf::KILO;
    lim.rlim_cur = lim.rlim_max;
    if (setrlimit(RLIMIT_AS, &lim) < 0)
    {
        FM_LOG_WARNING("setrlimit RLIMIT_AS failed for %d KB: %s. MLE might not be strictly enforced by OS.", problem::memory_limit, strerror(errno));
        // Continue without RLIMIT_AS, relying on page fault counting.
        // Consider this a non-fatal error for judge operation, but a warning for enforcement.
    } else {
        FM_LOG_DEBUG("setrlimit RLIMIT_AS succeeded for %d KB.", problem::memory_limit);
    }

    //堆栈空间限制
    getrlimit(RLIMIT_STACK, &lim);
    FM_LOG_DEBUG("Current RLIMIT_STACK: max(%d) cur(%d)",
            lim.rlim_max, lim.rlim_cur);

    int rlim = judge_conf::stack_size_limit * judge_conf::KILO;
    if (lim.rlim_max <= rlim)
    {
        FM_LOG_WARNING("can't set stack size to higher(%d <= %d)",
                lim.rlim_max, rlim);
    }
    else
    {
        lim.rlim_max = rlim;
        lim.rlim_cur = rlim;

        if (setrlimit(RLIMIT_STACK, &lim) < 0)
        {
            FM_LOG_WARNING("setrlimit RLIMIT_STACK failed: %s", strerror(errno));
            exit(judge_conf::EXIT_SET_LIMIT);
        }
    }

    //输出文件大小限制
    lim.rlim_max = problem::output_limit * judge_conf::KILO;
    lim.rlim_cur = lim.rlim_max;
    if (setrlimit(RLIMIT_FSIZE, &lim) < 0)
    {
        // log_close() was called before this, so this message will go to stderr if logger is file-based
        // and has been closed. If logger also logs to stderr, it will appear there.
        FM_LOG_FATAL("setrlimit RLIMIT_FSIZE failed: %s", strerror(errno));
        exit(judge_conf::EXIT_SET_LIMIT);
    }

    //FM_LOG_TRACE("set limit ok");
}

/*
 * 设置安全相关 for spj.exe
 */
void set_security_option_spj()
{
    //chdir + chroot
    if (EXIT_SUCCESS != chdir(problem::temp_dir.c_str()))
    {
        FM_LOG_FATAL("SPJ: chdir(%s) failed, %d: %s",
                problem::temp_dir.c_str(), errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }

    // Note: getcwd() after chdir, before chroot, to get the path for chroot.
    char cwd[1024], *tmp = getcwd(cwd, 1024);
    if (tmp == NULL)
    {
        FM_LOG_FATAL("SPJ: getcwd failed, %d: %s", errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }
    FM_LOG_DEBUG("SPJ cwd for chroot: %s", cwd);

    if (EXIT_SUCCESS != chroot(cwd)) // chroot to current dir which is temp_dir
    {
        FM_LOG_FATAL("SPJ: chroot(%s) failed, %d: %s. CRITICAL: SPJ running without chroot.",
                cwd, errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }
    FM_LOG_TRACE("SPJ chroot to %s successful", cwd);

    // setgid and setuid AFTER chroot
    // For SPJ, we typically want to run as the current user, not 'nobody',
    // as SPJ might need some specific (but limited) permissions.
    // However, the original code uses getgid()/getuid().
    // This implies the judge process itself might already be running as a non-root user
    // OR it intends to drop to the *original* user's privileges, not 'nobody'.
    // For maximum security, if SPJ doesn't need special user privileges,
    // using 'nobody' (like in set_security_option) would be safer.
    // Sticking to original getgid/getuid for now as per existing logic.
    int ret_gid = setgid(getgid());
    if(ret_gid)
    {
        FM_LOG_FATAL("SPJ: setgid(%d) failed, %d: %s. CRITICAL: SPJ failed to set GID.",
                getgid(), errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }

    int ret_uid = setuid(getuid());
    if(ret_uid)
    {
        FM_LOG_FATAL("SPJ: setuid(%d) failed, %d: %s. CRITICAL: SPJ failed to set UID.",
                getuid(), errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }

    FM_LOG_TRACE("set_security_option_spj ok");
}

/*
 * 设置安全相关，比如chroot和setuid
 */
void set_security_option()
{
    //必须先getpwnam, 然后chroot, 然后再setuid
    //先setuid就没法getpwnam, 先setuid就没法chroot了, 真囧
    struct passwd *nobody = getpwnam("nobody");
    if (nobody == NULL)
    {
        FM_LOG_WARNING("no user named 'nobody'? %d: %s", errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }

    //chdir + chroot
    if (EXIT_SUCCESS != chdir(problem::temp_dir.c_str()))
    {
        FM_LOG_FATAL("chdir(%s) failed, %d: %s",
                problem::temp_dir.c_str(), errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }

    char cwd[1024], *tmp = getcwd(cwd, 1024);
    if (tmp == NULL)
    {
        FM_LOG_FATAL("getcwd failed, %d: %s", errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }
    FM_LOG_DEBUG("cwd: %s", cwd);

    // For Java, chroot is currently skipped.
    // KNOWN SECURITY CONCERN: The JVM requires broader file system access.
    // This means Java submissions run with less filesystem isolation than other languages.
    // This risk needs to be accepted or mitigated externally (e.g., containerization)
    // if Java submissions are enabled.
    if(problem::lang != judge_conf::LANG_JAVA) {
        if (EXIT_SUCCESS != chroot(cwd))
        {
            FM_LOG_FATAL("chroot(%s) failed, %d: %s. CRITICAL: Running without chroot.",
                    cwd, errno, strerror(errno));
            exit(judge_conf::EXIT_SET_SECURITY);
        }
    }

    //setuid
    if (EXIT_SUCCESS != setuid(nobody->pw_uid))
    {
        FM_LOG_FATAL("setuid(%d) failed, %d: %s. CRITICAL: Failed to drop root privileges.",
                nobody->pw_uid, errno, strerror(errno));
        exit(judge_conf::EXIT_SET_SECURITY);
    }

    FM_LOG_TRACE("set_security_option ok");
}

//使用spj.exe来判断
            //spj.exe  ans_stdout  ans_stdin  user_stdout  source_code
int oj_compare_output_spj(
        std::string ans_stdout, //标准答案.out
        std::string ans_stdin, //标准答案.in
        std::string user_stdout, //用户程序的输出文件
        std::string source_code, //源代码路径
        std::string spj_exec,  //spj.exe的路径
        std::string spj_stdout)  //spj.exe的输出文件
{
    FM_LOG_TRACE("start compare spj");
    FM_LOG_TRACE("start compare spj");

    // Construct paths for SPJ executable
    std::string spj_original_path = spj_exec; // This is problem::data_dir + "/spj.exe"
    std::string spj_temp_path = problem::temp_dir + "/spj.exe";

    // Copy spj.exe from data_dir to temp_dir
    // so it's accessible after chroot in set_security_option_spj()
    int source_fd = open(spj_original_path.c_str(), O_RDONLY);
    if (source_fd == -1) {
        FM_LOG_FATAL("Failed to open SPJ source executable %s: %s", spj_original_path.c_str(), strerror(errno));
        exit(judge_conf::EXIT_COMPARE_SPJ);
    }

    struct stat stat_source;
    if (fstat(source_fd, &stat_source) == -1) {
        FM_LOG_FATAL("Failed to fstat SPJ source executable %s: %s", spj_original_path.c_str(), strerror(errno));
        close(source_fd);
        exit(judge_conf::EXIT_COMPARE_SPJ);
    }

    int dest_fd = open(spj_temp_path.c_str(), O_WRONLY | O_CREAT | O_TRUNC, stat_source.st_mode);
    if (dest_fd == -1) {
        FM_LOG_FATAL("Failed to open SPJ destination executable %s: %s", spj_temp_path.c_str(), strerror(errno));
        close(source_fd);
        exit(judge_conf::EXIT_COMPARE_SPJ);
    }

    off_t offset = 0;
    ssize_t bytes_copied = sendfile(dest_fd, source_fd, &offset, stat_source.st_size);
    close(source_fd);
    close(dest_fd);

    if (bytes_copied != stat_source.st_size) {
        FM_LOG_FATAL("Failed to copy SPJ executable from %s to %s. Copied %ld, expected %ld. Error: %s",
                     spj_original_path.c_str(), spj_temp_path.c_str(), bytes_copied, stat_source.st_size, strerror(errno));
        // Attempt to remove partially copied file
        unlink(spj_temp_path.c_str());
        exit(judge_conf::EXIT_COMPARE_SPJ);
    }
    FM_LOG_TRACE("SPJ executable copied from %s to %s", spj_original_path.c_str(), spj_temp_path.c_str());

    // current_spj_pid is declared extern (visible from judge_all.cpp's global scope)
    current_spj_pid = fork();
    int status = 0;
    if (current_spj_pid < 0)
    {
        FM_LOG_FATAL("fork for SPJ process failed: %s", strerror(errno));
        current_spj_pid = 0; // Reset on failure
        exit(judge_conf::EXIT_COMPARE_SPJ);
    }
    else if (current_spj_pid == 0)
    {
        // Child process (SPJ)
        log_add_info("spj_child"); // Differentiate from parent log
        stdin  = freopen(user_stdout.c_str(), "r", stdin);
        stdout = freopen(spj_stdout.c_str(),  "w", stdout);
        if (stdin == NULL || stdout == NULL)
        {
            FM_LOG_FATAL("SPJ child: failed to freopen files: stdin(%p), stdout(%p). Error: %s", stdin, stdout, strerror(errno));
            exit(judge_conf::EXIT_COMPARE_SPJ); // Use a distinct exit code if possible, or ensure log is flushed.
        }
        
        // Apply security options (chdir, chroot, setuid/gid)
        // This must happen *before* execlp
        set_security_option_spj(); // This will chdir and chroot to problem::temp_dir

        //给spj.exe限制时间
        if (EXIT_SUCCESS == malarm(ITIMER_REAL, judge_conf::spj_time_limit))
        {
            FM_LOG_TRACE("SPJ child: load ./spj.exe"); // Path is now relative to chrooted temp_dir
            // Note: spj_temp_path is "./spj.exe" if CWD is temp_dir after chroot
            FM_LOG_TRACE("SPJ child cmd: ./spj.exe %s %s",
                    ans_stdout.c_str(), // argv[1]: standard output data
                    ans_stdin.c_str()   // argv[2]: standard input data (for the problem)
                                        // User's output is redirected to SPJ's stdin
            );
            log_close(); // Close log file before exec, especially important after chroot

            // Execute spj.exe from within the chrooted temp_dir
            // argv[0] = path to spj executable (e.g. "./spj.exe")
            // argv[1] = path to standard answer file
            // argv[2] = path to standard input file (for the problem)
            // User's output is provided via stdin redirection.
            execlp("./spj.exe", "spj.exe", // Path to SPJ executable, name for argv[0]
                    ans_stdout.c_str(),   // argv[1]
                    ans_stdin.c_str(),    // argv[2]
                    NULL);
            // If execlp returns, it's an error
            FM_LOG_FATAL("SPJ child: execlp(\"./spj.exe\") failed: %s", strerror(errno)); // Log won't write if log_close worked
            exit(judge_conf::EXIT_COMPARE_SPJ_FORK);
        }
        else
        {
            FM_LOG_WARNING("malarm failed");
            exit(judge_conf::EXIT_COMPARE_SPJ);
        }
    }
    else
    {
        // Parent (judge) process waiting for SPJ child
        if (wait4(current_spj_pid, &status, 0, NULL) < 0)
        {
            FM_LOG_WARNING("wait4 for SPJ process (PID: %d) failed: %s", current_spj_pid, strerror(errno));
            // If wait4 fails, current_spj_pid might still be valid if error is EINTR.
            // However, if ECHILD, it's already gone.
            // The timeout handler will try to kill it if it's still set and judge times out.
            current_spj_pid = 0; // Reset as we can't be sure of its state / it might be gone
            exit(judge_conf::EXIT_COMPARE_SPJ);
        }
        current_spj_pid = 0; // Reset SPJ PID after it has been waited for

        if (WIFEXITED(status))
        {
            //调用exit退出了
            if (WEXITSTATUS(status) == EXIT_SUCCESS)
            {
                //返回值是0, 正常结束
                FILE *fp = fopen(spj_stdout.c_str(), "r");
                if (fp == NULL)
                {
                    FM_LOG_WARNING("open stdout_file_spj failed");
                    exit(judge_conf::EXIT_COMPARE_SPJ);
                }
                char buff[20];
                int ignored __attribute__((unused)); // Mark as unused
                ignored = fscanf(fp, "%19s", buff); // fscanf result check might be useful
                FM_LOG_TRACE("spj.exe result: %s", buff);
                fclose(fp); // Close the file pointer
                if (strncasecmp(buff, "AC", 2) == 0)
                {
                    return judge_conf::OJ_AC;
                }
                else if (strncasecmp(buff, "PE", 2) == 0)
                {
                    return judge_conf::OJ_PE;
                }
                else if (strncasecmp(buff, "WA", 2) == 0)
                {
                    return judge_conf::OJ_WA;
                }
                else
                {
                    FM_LOG_WARNING("Unknown SPJ output: %s", buff);
                    // Defaulting to System Error or specific SPJ error code might be better
                    // exit(judge_conf::EXIT_COMPARE_SPJ); // Original exit
                    return judge_conf::OJ_SE; // Or a new OJ_SPJ_ERROR
                }
            }
            else
            {
                // SPJ process exited with non-zero status
                FM_LOG_WARNING("SPJ process abnormal termination, exit code: %d", WEXITSTATUS(status));
                // Defaulting to System Error or specific SPJ error code
                return judge_conf::OJ_SE; // Or a new OJ_SPJ_ERROR
            }
        }
        else if (WIFSIGNALED(status))
        {
            // SPJ process terminated by a signal
            if (WTERMSIG(status) == SIGALRM) {
                 FM_LOG_WARNING("SPJ process: Time Limit Exceeded (SIGALRM)");
            } else {
                 FM_LOG_WARNING("SPJ process: Terminated by signal %d: %s", WTERMSIG(status), strsignal(WTERMSIG(status)));
            }
            // Defaulting to System Error or specific SPJ error code
            return judge_conf::OJ_SE; // Or a new OJ_SPJ_ERROR / OJ_TLE_SPJ
        }
        else
        {
            // Unknown SPJ termination reason
            FM_LOG_WARNING("SPJ process: Unknown termination, status = %d", status);
            // Defaulting to System Error
            return judge_conf::OJ_SE;
        }
    }
    // Fallthrough implies an issue not covered above, or SPJ logic error
    FM_LOG_FATAL("oj_compare_output_spj: Logic fallthrough or unexpected SPJ state. Exiting.");
    exit(judge_conf::EXIT_COMPARE_SPJ); // Should ideally not be reached if all cases return/exit.
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
    int a, b, Na = 0, Nb = 0;
    enum {
        AC = judge_conf::OJ_AC,
        PE = judge_conf::OJ_PE,
        WA = judge_conf::OJ_WA
    } status = AC;
    while (true)
    {
        a = fgetc(fp_std);
        b = fgetc(fp_exe);
        Na++, Nb++;

        //统一\r和\n之间的区别
        if (a == '\r') a = '\n';
        if (b == '\r') b = '\n';
#define is_space_char(a) ((a == ' ') || (a == '\t') || (a == '\n'))

        if (feof(fp_std) && feof(fp_exe))
        {
            //如果两个文件都已经结束, 退出循环
            break;
        } 
        else if (feof(fp_std) || feof(fp_exe))
        {
            //如果只有一个文件结束,
            //但是另一个文件的末尾是回车
            //那么也当做AC来进行处理
            FM_LOG_TRACE("one file ended");
            FILE *fp_tmp;
            if (feof(fp_std))
            {
                if (!is_space_char(b))
                {
                    FM_LOG_TRACE("WA exe['%c':0x%x @%d]", b, b, Nb);
                    status = WA;
                    break;
                }
                fp_tmp = fp_exe;
            }
            else /* feof(fp_exe) */
            {
                if (!is_space_char(a))
                {
                    FM_LOG_TRACE("WA std['%c':0x%x @%d]", a, a, Na);
                    status = WA;
                    break;
                }
                fp_tmp = fp_std;
            }
            int c;
            while (c = fgetc(fp_tmp), c != EOF)
            {
                if (c == '\r') c = '\n';
                if (!is_space_char(c))
                {
                    FM_LOG_TRACE("WA ['%c':0x%x]", c, c);
                    status = WA;
                    break;
                }
            }
            break;
        }

        //如果两个字符不同，
        if (a != b)
        {
            status = PE; //可能是PE，再继续检测是否是WA
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
                Nb--;
            }
            else if (is_space_char(b))
            {
                //b是空白字符, 过滤, 退回a以便下一轮循环
                ungetc(a, fp_std);
                Na--;
            }
            else
            {
                //如果两个都不是空白字符且不相等, 就是WA
                FM_LOG_TRACE("WA ['%c':0x%x @%d] : ['%c':0x%x @%d]", a, a, Na, b, b, Nb);
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

#include "rf_table.h"
//系统调用在进和出的时候都会暂停, 把控制权交给judge
static bool in_syscall = true;
bool is_valid_syscall(int lang, int syscall_id, pid_t child, user_regs_struct regs)
{
    in_syscall = !in_syscall;
    //FM_LOG_DEBUG("syscall: %d, %s, count: %d", syscall_id, in_syscall?"in":"out", RF_table[syscall_id]);
    if (RF_table[syscall_id] == 0)
    {
        //如果RF_table中对应的syscall_id可以被调用的次数为0, 则为RF
        long addr;
        if(syscall_id == SYS_open)
        {
#if __WORDSIZE == 32
            addr = regs.ebx;
#else
            addr = regs.rdi;
#endif
#define LONGSIZE sizeof(long)
            union u{ unsigned long val; char chars[LONGSIZE]; }data;
            unsigned long i = 0, j = 0, k = 0;
            char filename[300];
            while (true)
            {
                data.val = ptrace(PTRACE_PEEKDATA, child, addr + i,  NULL);
                i += LONGSIZE;
                for (j = 0; j < LONGSIZE && data.chars[j] > 0 && k < 256; j++) 
                {
                    filename[k++] = data.chars[j];
                }
                if (j < LONGSIZE && data.chars[j] == 0)
                    break;
            }
            filename[k] = 0;
            FM_LOG_TRACE("syscall open: filename: %s", filename);

            // Security Check 1: Disallow absolute paths after chroot.
            // Absolute paths should not be valid as the process is chrooted.
            // Allowing them might indicate an attempt to bypass chroot or misconfiguration.
            if (filename[0] == '/')
            {
                FM_LOG_WARNING("RF: syscall open: Absolute path denied: %s", filename);
                return false;
            }

            // Security Check 2: Disallow ".." in paths to prevent traversal.
            // Even within chroot, ".." can lead to accessing unexpected locations if complex directory structures exist.
            if (strstr(filename, "..") != NULL)
            {
                FM_LOG_WARNING("RF: syscall open: Path traversal '..' denied: %s", filename);
                return false;
            }

            // Security Check 3: /proc/ access is now implicitly denied if RF_table[SYS_open] is 0.
            // The previous blanket allowance "if (strstr(filename, "/proc/") == filename) { return true; }" has been removed.
            // Specific /proc files, if essential, would need explicit entries in RF_table (e.g. RF_table[SYS_open] > 0 and specific path checks).

            // Security Check 4: Specific check for /dev/tty (existing)
            if (strstr(filename, "/dev/tty") == filename)
            {
                FM_LOG_WARNING("RF: syscall open: /dev/tty access denied explicitly, leading to OJ_RE_SEGV.");
                // This leads to a specific result, not just RF. This behavior is preserved.
                output_result(judge_conf::OJ_RE_SEGV);
                exit(judge_conf::EXIT_OK);
            }
        }
        return false;
    }
    else if (RF_table[syscall_id] > 0)
    {
        //如果RF_table中对应的syscall_id可被调用的次数>0
        //且是在退出syscall的时候, 那么次数减一
        if (in_syscall == false)
            RF_table[syscall_id]--;
    }
    else
    {
        //RF_table中syscall_id对应的指<0, 表示是不限制调用的
        ;
    }
    return true;
    // NOTE: If SYS_openat (syscall number typically __NR_openat or 257 for x86_64, 295 for i386)
    // is enabled in rf_table.h (i.e., RF_table[SYS_openat] is not -1),
    // similar path validation logic (absolute path check, '..' check) should be applied
    // for its filename argument. The filename for SYS_openat is obtained similarly from registers
    // (typically the second argument, e.g., rsi for x86_64),
    // but it's interpreted relative to a directory file descriptor (dirfd, the first argument).
    // Careful consideration of dirfd's meaning and validation within a chroot environment is crucial.
}
#endif
