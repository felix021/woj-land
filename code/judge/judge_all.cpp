/*
 * judge_all.cpp
 *
 * by felix021 http://www.felix021.com
 *
 * 此judge整合了C/C++/Java/Pascal的judge
 *
 */
#include <iostream>
#include <string>
#include <cstdio>
#include <cstdlib>
#include <cstring>
extern "C"
{
#include <unistd.h>
#include <errno.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <sys/reg.h>
#include <sys/user.h>
#include <sys/syscall.h>
#include <sys/resource.h>
#include <sys/ptrace.h>
}
#include "judge.h"

using namespace std;

// Global PIDs for cleanup in case of main judge timeout
static pid_t current_compiler_pid = 0;
static pid_t current_executive_pid = 0;
static pid_t current_spj_pid = 0;

extern int errno;
int int_ignored; //用来应付"warn_if_unused"的返回值, GCC真麻烦..

// Forward declaration for functions to be defined after main
static int run_compiler();
// static int judge_test_case(const char* current_data_file_base_name); // Will define later
static int judge_test_case(const char* current_data_file_base_name);

int main(int argc, char *argv[], char *envp[])
{
    judge_conf::load();
    log_open(judge_conf::log_file.c_str());
    FM_LOG_DEBUG("\n\x1b[31m-----a new start-----\x1b[0m");
    if (geteuid() != 0)
    {
        FM_LOG_FATAL("euid != 0, please run as root, or set suid bit(chmod +4755)");
        exit(judge_conf::EXIT_UNPRIVILEGED);
    }
    parse_arguments(argc, argv);
    judge_conf::judge_time_limit += problem::time_limit;
    if (EXIT_SUCCESS != malarm(ITIMER_REAL, judge_conf::judge_time_limit))
    {
        FM_LOG_WARNING("set alarm for judge failed, %d: %s", errno, strerror(errno));
        exit(judge_conf::EXIT_VERY_FIRST);
    }
    signal(SIGALRM, timeout);

    // Compile the source code
    int compile_result_status = run_compiler();
    if (compile_result_status != EXIT_SUCCESS) {
        // If compilation failed (OJ_CE, OJ_TLE_COMPILE, or other EXIT_COMPILE),
        // run_compiler already called output_result and exited or returned a status.
        // If it returned (meaning output_result was called), we should terminate.
        log_close();
        return 0; 
    }
    FM_LOG_TRACE("Compilation successful. Proceeding to judge test cases.");

//Judge----------------------------------------------------------------------
    //打开输入输出文件
    FILE *fp = fopen(problem::data_file.c_str(), "r");
    if (fp == NULL)
    {
        FM_LOG_WARNING("error opening data_file");
        return judge_conf::EXIT_PRE_JUDGE;
    }

    FM_LOG_TRACE("start reading data.txt");
    
    std::string line_str;
    char buffer[1024]; // Buffer for fgets

    while (fgets(buffer, sizeof(buffer), fp) != NULL) {
        line_str = buffer;

        // Trim trailing newline characters (\r, \n)
        size_t first_newline = line_str.find_first_of("\r\n");
        if (first_newline != std::string::npos) {
            line_str.erase(first_newline);
        }

        // Trim leading and trailing whitespace (space, tab)
        const std::string whitespace = " \t";
        size_t start = line_str.find_first_not_of(whitespace);
        if (start == std::string::npos) { // Line is empty or all whitespace
            FM_LOG_TRACE("Skipping empty or whitespace-only line in data.txt: [%s]", buffer); // Log original buffer content
            continue;
        }
        line_str = line_str.substr(start);
        size_t end = line_str.find_last_not_of(whitespace);
        // substr(0, end + 1) is safe because end is guaranteed to be valid due to previous check
        line_str = line_str.substr(0, end + 1);

        if (line_str.empty()) { // Should be caught by the start == std::string::npos check, but as a safeguard.
            FM_LOG_TRACE("Skipping line that became empty after trimming in data.txt: [%s]", buffer);
            continue;
        }
        
        std::string base_name = line_str;
        const std::string suffix = ".in";
        if (base_name.length() >= suffix.length() &&
            base_name.compare(base_name.length() - suffix.length(), suffix.length(), suffix) == 0) {
            base_name.erase(base_name.length() - suffix.length());
            FM_LOG_TRACE("Removed '.in' suffix from '%s', base name: '%s'", line_str.c_str(), base_name.c_str());
        } else {
            FM_LOG_TRACE("No '.in' suffix found in '%s', using as base name: '%s'", line_str.c_str(), base_name.c_str());
        }

        if (base_name.empty()) {
            FM_LOG_WARNING("Empty base name after processing line: [%s] (original: [%s]). Skipping.", 
                           line_str.c_str(), buffer);
            continue;
        }

        FM_LOG_DEBUG("--- Starting Test Case for: %s ---", base_name.c_str());
        int test_case_status = judge_test_case(base_name.c_str());
        // problem::result is updated globally by judge_test_case.
        // problem::time_usage and problem::memory_usage are also updated globally within judge_test_case.

        if (test_case_status != judge_conf::OJ_AC && test_case_status != judge_conf::OJ_PE) {
            FM_LOG_INFO("Test case for '%s' resulted in %d (not AC/PE), stopping further test cases.",
                        base_name.c_str(), test_case_status);
            if (test_case_status == judge_conf::OJ_TLE) { 
                problem::time_usage = problem::time_limit; // Ensure time_usage reflects TLE
            }
            break; // Stop processing further test cases
        }
        FM_LOG_DEBUG("--- Finished Test Case for: %s --- Result so far: %d", base_name.c_str(), problem::result);
    }

    if (ferror(fp)) {
        FM_LOG_WARNING("Error occurred while reading data.txt: %s", strerror(errno));
    }
    FM_LOG_TRACE("Finished reading data.txt.");
    fclose(fp); // Close data_file after loop

    output_result(problem::result, problem::memory_usage, problem::time_usage);
    FM_LOG_DEBUG("Judge finished. Result: %d, Memory: %ld KB, Time: %d ms.",
                 problem::result, problem::memory_usage, problem::time_usage);
    log_close(); // Close log file at the very end of execution
    return 0;
}


// Handles the compilation phase.
// Returns EXIT_SUCCESS if compilation is successful.
// Returns judge_conf::OJ_CE or judge_conf::OJ_TLE_COMPILE if specific errors occur and result is outputted.
// Exits directly for critical errors (e.g., fork failure, waitpid failure).
static int run_compiler() {
// ... (run_compiler implementation from previous successful diff - unchanged)
    FM_LOG_DEBUG("--- Starting Compilation Phase ---");
    int status = 0;
    current_compiler_pid = fork(); // Uses global current_compiler_pid

    if (current_compiler_pid < 0) {
        FM_LOG_FATAL("fork for compiler failed: %s", strerror(errno));
        current_compiler_pid = 0; // Reset global
        exit(judge_conf::EXIT_COMPILE); 
    } else if (current_compiler_pid == 0) {
        // Child process (compiler)
        log_add_info("compiler_child"); // Differentiate logs
        stdout = freopen(problem::stdout_file_compiler.c_str(), "w", stdout);
        stderr = freopen(problem::stderr_file_compiler.c_str(), "w", stderr);
        if (stdout == NULL || stderr == NULL) {
            FM_LOG_FATAL("Compiler child: freopen for stdout/stderr failed: %s", strerror(errno));
            // Using FATAL as this is critical for compiler's operation.
            exit(judge_conf::EXIT_COMPILE);
        }

        if (malarm(ITIMER_REAL, judge_conf::compile_time_limit) != 0) {
             FM_LOG_FATAL("Compiler child: malarm failed: %s", strerror(errno));
             exit(judge_conf::EXIT_COMPILE);
        }
        
        switch (problem::lang) {
            case judge_conf::LANG_C:
                FM_LOG_TRACE("Compiler child: exec gcc ...");
                execlp("gcc", "gcc", "-o", problem::exec_file.c_str(), problem::source_file.c_str(),
                       /* -static for static linking, -w to suppress warnings */ "-static", "-w",
                       "-lm", "-std=c99", "-O2", "-DOJ", NULL);
                break;
            case judge_conf::LANG_CPP:
                FM_LOG_TRACE("Compiler child: exec g++ ...");
                execlp("g++", "g++", "-o", problem::exec_file.c_str(), problem::source_file.c_str(),
                       /* -static for static linking, -w to suppress warnings */ "-static", "-w",
                       "-O2", "-DOJ", NULL);
                break;
            case judge_conf::LANG_JAVA:
                 FM_LOG_TRACE("Compiler child: exec javac ...");
                 // Note: Java compilation doesn't use problem::exec_file directly for output,
                 // it uses -d problem::temp_dir. problem::exec_file for Java is "Main".
                 execlp("javac", "javac", problem::source_file.c_str(), "-d", problem::temp_dir.c_str(), NULL);
                break;
            case judge_conf::LANG_PASCAL:
                FM_LOG_TRACE("Compiler child: exec fpc ...");
                execlp("fpc", "fpc", problem::source_file.c_str(),
                       ("-o" + problem::exec_file).c_str(), "-Co", "-Cr", "-Ct", "-Ci", NULL);
                break;
            default: 
                FM_LOG_FATAL("Compiler child: Unknown language %d in run_compiler", problem::lang);
                exit(judge_conf::EXIT_COMPILE);
        }
        // If execlp returns, it's an error
        FM_LOG_FATAL("Compiler child: execlp failed for lang %d: %s", problem::lang, strerror(errno));
        exit(judge_conf::EXIT_COMPILE);
    } else {
        // Parent process (judge)
        pid_t w = waitpid(current_compiler_pid, &status, WUNTRACED);
        // Important: Reset global current_compiler_pid after waitpid returns, regardless of outcome.
        // This ensures the timeout handler doesn't try to kill an already terminated/waited-for process.
        current_compiler_pid = 0; 

        if (w == -1) {
            FM_LOG_FATAL("waitpid for compiler failed: %s", strerror(errno));
            exit(judge_conf::EXIT_COMPILE); 
        }

        FM_LOG_DEBUG("Compiler process finished.");
        if (WIFEXITED(status)) {
            if (WEXITSTATUS(status) == EXIT_SUCCESS) {
                FM_LOG_TRACE("Compilation successful.");
                return EXIT_SUCCESS; // Success
            } else if (WEXITSTATUS(status) == judge_conf::GCC_COMPILE_ERROR) {
                FM_LOG_TRACE("Compilation error (CE).");
                output_result(judge_conf::OJ_CE); 
                return judge_conf::OJ_CE;         
            } else {
                FM_LOG_WARNING("Compiler exited with unknown status: %d", WEXITSTATUS(status));
                output_result(judge_conf::OJ_SE); // Treat as System Error
                return judge_conf::EXIT_COMPILE;  // Indicate general compile error for main to terminate
            }
        } else if (WIFSIGNALED(status)) {
            if (WTERMSIG(status) == SIGALRM) {
                FM_LOG_WARNING("Compiler Time Limit Exceeded (SIGALRM).");
                output_result(judge_conf::OJ_TLE_COMPILE); 
                return judge_conf::OJ_TLE_COMPILE;        
            } else {
                FM_LOG_WARNING("Compiler terminated by signal: %d (%s)", WTERMSIG(status), strsignal(WTERMSIG(status)));
                output_result(judge_conf::OJ_SE); 
                return judge_conf::EXIT_COMPILE;  
            }
        } else if (WIFSTOPPED(status)) { // Should not happen with WUNTRACED unless something else sends SIGSTOP
             FM_LOG_WARNING("Compiler stopped by signal: %d (%s). Treating as System Error.", WSTOPSIG(status), strsignal(WSTOPSIG(status)));
             output_result(judge_conf::OJ_SE);
             return judge_conf::EXIT_COMPILE;
        } else {
            FM_LOG_WARNING("Compiler ended with unknown reason, status: %d. Treating as System Error.", status);
            output_result(judge_conf::OJ_SE);
            return judge_conf::EXIT_COMPILE;
        }
    }
}

