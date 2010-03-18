#ifndef __RF_TABLE__
#define __RF_TABLE__

#include "logger.h"

/*
 * RF_table 每个值对应的是该syscall可被调用的次数
 *    取值有3种:
 *      正值: 表示可被调用的次数, 每次调用后会减一(比如fork)
 *      零值: 表示禁止调用(比如open)
 *      负值: 表示不限制该syscall(比如write)
 * 
 * RF_table的初始化由init_RF_table函数完成
 */
short RF_table[1024] = {0};

/*
 * LANG_*V/LANG_*C数组对是用于初始化RF_table的数据来源
 *      LANG_*V数组的每个单元存放syscall的编号
 *      LANG_*C数组的对应单元存放该syscall可被调用的次数
 *
 * p.s. LANG_*V数组的最后一个单元存放的是非正值，表示结束
 */
//c or c++
int LANG_CV[256]={SYS_execve, SYS_read, SYS_uname, SYS_write, SYS_open, SYS_close, SYS_access, SYS_brk, SYS_munmap, SYS_mprotect, SYS_mmap2, SYS_fstat64, SYS_set_thread_area, SYS_exit_group, SYS_exit, 0};
int LANG_CC[256]={1,          -1,       -1,        -1,        -1,       -1,        -1,         -1,      -1,         -1,           -1,        -1,          -1,                  -1,             -1,       0};
//Pascal
int LANG_PV[256]={SYS_execve, SYS_open, SYS_set_thread_area, SYS_brk, SYS_read, SYS_uname, SYS_write, SYS_ioctl, SYS_readlink, SYS_mmap, SYS_rt_sigaction, SYS_getrlimit, SYS_exit_group, SYS_exit, SYS_ugetrlimit, 0};
int LANG_PC[256]={1,          -1,       -1,                  -1,      -1,       -1,        -1,        -1,        -1,           -1,       -1,               -1,            -1,             -1,       -1,             0};
//Java
int LANG_JV[256]={SYS_execve, SYS_ugetrlimit, SYS_rt_sigprocmask, SYS_futex, SYS_read, SYS_mmap2, SYS_stat64, SYS_open, SYS_close, SYS_access, SYS_brk, SYS_readlink, SYS_munmap, SYS_close, SYS_uname, SYS_clone, SYS_uname, SYS_mprotect, SYS_rt_sigaction, SYS_sigprocmask, SYS_getrlimit, SYS_fstat64, SYS_getuid32, SYS_getgid32, SYS_geteuid32, SYS_getegid32, SYS_set_thread_area, SYS_set_tid_address, SYS_set_robust_list, SYS_exit_group, 0};
int LANG_JC[256]={2,          -1,            -1,                 -1,        -1,        -1,        -1,         -1,       -1,        -1,         -1,      -1,           -1,         -1,        -1,        1,         -1,        -1,           -1,               -1,              -1,            -1,          -1,           -1,           -1,            -1,            -1,                  -1,                  -1,                  -1,              0};

//根据LANG_*V/LANG_*C数组来初始化RF_table
void init_RF_table(int lang)
{
    int *pv = NULL, *pc = NULL;
    switch (lang)
    {
        case judge_conf::LANG_C:
        case judge_conf::LANG_CPP:
            pv = LANG_CV, pc = LANG_CC;
            break;
        case judge_conf::LANG_JAVA:
            pv = LANG_JV, pc = LANG_JC;
            break;
        case judge_conf::LANG_PASCAL:
            pv = LANG_PV, pc = LANG_PC;
            break;
        default:
            FM_LOG_WARNING("unknown lang: %d", lang);
            break;
    }
    memset(RF_table, 0, sizeof(RF_table));
    for (int i = 0; pv[i] > 0; i++)
    {
        RF_table[pv[i]] = pc[i];
    }
}

#endif
