#include <stdio.h>
#include <sys/syscall.h>

int main()
{
#ifdef SYS__sysctl
    printf("%-30s %d\n", "SYS__sysctl", SYS__sysctl);
#endif
#ifdef SYS_access
    printf("%-30s %d\n", "SYS_access", SYS_access);
#endif
#ifdef SYS_acct
    printf("%-30s %d\n", "SYS_acct", SYS_acct);
#endif
#ifdef SYS_add_key
    printf("%-30s %d\n", "SYS_add_key", SYS_add_key);
#endif
#ifdef SYS_adjtimex
    printf("%-30s %d\n", "SYS_adjtimex", SYS_adjtimex);
#endif
#ifdef SYS_afs_syscall
    printf("%-30s %d\n", "SYS_afs_syscall", SYS_afs_syscall);
#endif
#ifdef SYS_alarm
    printf("%-30s %d\n", "SYS_alarm", SYS_alarm);
#endif
#ifdef SYS_brk
    printf("%-30s %d\n", "SYS_brk", SYS_brk);
#endif
#ifdef SYS_capget
    printf("%-30s %d\n", "SYS_capget", SYS_capget);
#endif
#ifdef SYS_capset
    printf("%-30s %d\n", "SYS_capset", SYS_capset);
#endif
#ifdef SYS_chdir
    printf("%-30s %d\n", "SYS_chdir", SYS_chdir);
#endif
#ifdef SYS_chmod
    printf("%-30s %d\n", "SYS_chmod", SYS_chmod);
#endif
#ifdef SYS_chown
    printf("%-30s %d\n", "SYS_chown", SYS_chown);
#endif
#ifdef SYS_chroot
    printf("%-30s %d\n", "SYS_chroot", SYS_chroot);
#endif
#ifdef SYS_clock_getres
    printf("%-30s %d\n", "SYS_clock_getres", SYS_clock_getres);
#endif
#ifdef SYS_clock_gettime
    printf("%-30s %d\n", "SYS_clock_gettime", SYS_clock_gettime);
#endif
#ifdef SYS_clock_nanosleep
    printf("%-30s %d\n", "SYS_clock_nanosleep", SYS_clock_nanosleep);
#endif
#ifdef SYS_clock_settime
    printf("%-30s %d\n", "SYS_clock_settime", SYS_clock_settime);
#endif
#ifdef SYS_clone
    printf("%-30s %d\n", "SYS_clone", SYS_clone);
#endif
#ifdef SYS_close
    printf("%-30s %d\n", "SYS_close", SYS_close);
#endif
#ifdef SYS_creat
    printf("%-30s %d\n", "SYS_creat", SYS_creat);
#endif
#ifdef SYS_create_module
    printf("%-30s %d\n", "SYS_create_module", SYS_create_module);
#endif
#ifdef SYS_delete_module
    printf("%-30s %d\n", "SYS_delete_module", SYS_delete_module);
#endif
#ifdef SYS_dup
    printf("%-30s %d\n", "SYS_dup", SYS_dup);
#endif
#ifdef SYS_dup2
    printf("%-30s %d\n", "SYS_dup2", SYS_dup2);
#endif
#ifdef SYS_dup3
    printf("%-30s %d\n", "SYS_dup3", SYS_dup3);
#endif
#ifdef SYS_epoll_create
    printf("%-30s %d\n", "SYS_epoll_create", SYS_epoll_create);
#endif
#ifdef SYS_epoll_create1
    printf("%-30s %d\n", "SYS_epoll_create1", SYS_epoll_create1);
#endif
#ifdef SYS_epoll_ctl
    printf("%-30s %d\n", "SYS_epoll_ctl", SYS_epoll_ctl);
#endif
#ifdef SYS_epoll_pwait
    printf("%-30s %d\n", "SYS_epoll_pwait", SYS_epoll_pwait);
#endif
#ifdef SYS_epoll_wait
    printf("%-30s %d\n", "SYS_epoll_wait", SYS_epoll_wait);
#endif
#ifdef SYS_eventfd
    printf("%-30s %d\n", "SYS_eventfd", SYS_eventfd);
#endif
#ifdef SYS_eventfd2
    printf("%-30s %d\n", "SYS_eventfd2", SYS_eventfd2);
#endif
#ifdef SYS_execve
    printf("%-30s %d\n", "SYS_execve", SYS_execve);
#endif
#ifdef SYS_exit
    printf("%-30s %d\n", "SYS_exit", SYS_exit);
#endif
#ifdef SYS_exit_group
    printf("%-30s %d\n", "SYS_exit_group", SYS_exit_group);
#endif
#ifdef SYS_faccessat
    printf("%-30s %d\n", "SYS_faccessat", SYS_faccessat);
#endif
#ifdef SYS_fadvise64
    printf("%-30s %d\n", "SYS_fadvise64", SYS_fadvise64);
#endif
#ifdef SYS_fallocate
    printf("%-30s %d\n", "SYS_fallocate", SYS_fallocate);
#endif
#ifdef SYS_fchdir
    printf("%-30s %d\n", "SYS_fchdir", SYS_fchdir);
#endif
#ifdef SYS_fchmod
    printf("%-30s %d\n", "SYS_fchmod", SYS_fchmod);
#endif
#ifdef SYS_fchmodat
    printf("%-30s %d\n", "SYS_fchmodat", SYS_fchmodat);
#endif
#ifdef SYS_fchown
    printf("%-30s %d\n", "SYS_fchown", SYS_fchown);
#endif
#ifdef SYS_fchownat
    printf("%-30s %d\n", "SYS_fchownat", SYS_fchownat);
#endif
#ifdef SYS_fcntl
    printf("%-30s %d\n", "SYS_fcntl", SYS_fcntl);
#endif
#ifdef SYS_fdatasync
    printf("%-30s %d\n", "SYS_fdatasync", SYS_fdatasync);
#endif
#ifdef SYS_fgetxattr
    printf("%-30s %d\n", "SYS_fgetxattr", SYS_fgetxattr);
#endif
#ifdef SYS_flistxattr
    printf("%-30s %d\n", "SYS_flistxattr", SYS_flistxattr);
#endif
#ifdef SYS_flock
    printf("%-30s %d\n", "SYS_flock", SYS_flock);
#endif
#ifdef SYS_fork
    printf("%-30s %d\n", "SYS_fork", SYS_fork);
#endif
#ifdef SYS_fremovexattr
    printf("%-30s %d\n", "SYS_fremovexattr", SYS_fremovexattr);
#endif
#ifdef SYS_fsetxattr
    printf("%-30s %d\n", "SYS_fsetxattr", SYS_fsetxattr);
#endif
#ifdef SYS_fstat
    printf("%-30s %d\n", "SYS_fstat", SYS_fstat);
#endif
#ifdef SYS_fstatfs
    printf("%-30s %d\n", "SYS_fstatfs", SYS_fstatfs);
#endif
#ifdef SYS_fsync
    printf("%-30s %d\n", "SYS_fsync", SYS_fsync);
#endif
#ifdef SYS_ftruncate
    printf("%-30s %d\n", "SYS_ftruncate", SYS_ftruncate);
#endif
#ifdef SYS_futex
    printf("%-30s %d\n", "SYS_futex", SYS_futex);
#endif
#ifdef SYS_futimesat
    printf("%-30s %d\n", "SYS_futimesat", SYS_futimesat);
#endif
#ifdef SYS_get_kernel_syms
    printf("%-30s %d\n", "SYS_get_kernel_syms", SYS_get_kernel_syms);
#endif
#ifdef SYS_get_mempolicy
    printf("%-30s %d\n", "SYS_get_mempolicy", SYS_get_mempolicy);
#endif
#ifdef SYS_get_robust_list
    printf("%-30s %d\n", "SYS_get_robust_list", SYS_get_robust_list);
#endif
#ifdef SYS_get_thread_area
    printf("%-30s %d\n", "SYS_get_thread_area", SYS_get_thread_area);
#endif
#ifdef SYS_getcwd
    printf("%-30s %d\n", "SYS_getcwd", SYS_getcwd);
#endif
#ifdef SYS_getdents
    printf("%-30s %d\n", "SYS_getdents", SYS_getdents);
#endif
#ifdef SYS_getdents64
    printf("%-30s %d\n", "SYS_getdents64", SYS_getdents64);
#endif
#ifdef SYS_getegid
    printf("%-30s %d\n", "SYS_getegid", SYS_getegid);
#endif
#ifdef SYS_geteuid
    printf("%-30s %d\n", "SYS_geteuid", SYS_geteuid);
#endif
#ifdef SYS_getgid
    printf("%-30s %d\n", "SYS_getgid", SYS_getgid);
#endif
#ifdef SYS_getgroups
    printf("%-30s %d\n", "SYS_getgroups", SYS_getgroups);
#endif
#ifdef SYS_getitimer
    printf("%-30s %d\n", "SYS_getitimer", SYS_getitimer);
#endif
#ifdef SYS_getpgid
    printf("%-30s %d\n", "SYS_getpgid", SYS_getpgid);
#endif
#ifdef SYS_getpgrp
    printf("%-30s %d\n", "SYS_getpgrp", SYS_getpgrp);
#endif
#ifdef SYS_getpid
    printf("%-30s %d\n", "SYS_getpid", SYS_getpid);
#endif
#ifdef SYS_getpmsg
    printf("%-30s %d\n", "SYS_getpmsg", SYS_getpmsg);
#endif
#ifdef SYS_getppid
    printf("%-30s %d\n", "SYS_getppid", SYS_getppid);
#endif
#ifdef SYS_getpriority
    printf("%-30s %d\n", "SYS_getpriority", SYS_getpriority);
#endif
#ifdef SYS_getresgid
    printf("%-30s %d\n", "SYS_getresgid", SYS_getresgid);
#endif
#ifdef SYS_getresuid
    printf("%-30s %d\n", "SYS_getresuid", SYS_getresuid);
#endif
#ifdef SYS_getrlimit
    printf("%-30s %d\n", "SYS_getrlimit", SYS_getrlimit);
#endif
#ifdef SYS_getrusage
    printf("%-30s %d\n", "SYS_getrusage", SYS_getrusage);
#endif
#ifdef SYS_getsid
    printf("%-30s %d\n", "SYS_getsid", SYS_getsid);
#endif
#ifdef SYS_gettid
    printf("%-30s %d\n", "SYS_gettid", SYS_gettid);
#endif
#ifdef SYS_gettimeofday
    printf("%-30s %d\n", "SYS_gettimeofday", SYS_gettimeofday);
#endif
#ifdef SYS_getuid
    printf("%-30s %d\n", "SYS_getuid", SYS_getuid);
#endif
#ifdef SYS_getxattr
    printf("%-30s %d\n", "SYS_getxattr", SYS_getxattr);
#endif
#ifdef SYS_init_module
    printf("%-30s %d\n", "SYS_init_module", SYS_init_module);
#endif
#ifdef SYS_inotify_add_watch
    printf("%-30s %d\n", "SYS_inotify_add_watch", SYS_inotify_add_watch);
#endif
#ifdef SYS_inotify_init
    printf("%-30s %d\n", "SYS_inotify_init", SYS_inotify_init);
#endif
#ifdef SYS_inotify_init1
    printf("%-30s %d\n", "SYS_inotify_init1", SYS_inotify_init1);
#endif
#ifdef SYS_inotify_rm_watch
    printf("%-30s %d\n", "SYS_inotify_rm_watch", SYS_inotify_rm_watch);
#endif
#ifdef SYS_io_cancel
    printf("%-30s %d\n", "SYS_io_cancel", SYS_io_cancel);
#endif
#ifdef SYS_io_destroy
    printf("%-30s %d\n", "SYS_io_destroy", SYS_io_destroy);
#endif
#ifdef SYS_io_getevents
    printf("%-30s %d\n", "SYS_io_getevents", SYS_io_getevents);
#endif
#ifdef SYS_io_setup
    printf("%-30s %d\n", "SYS_io_setup", SYS_io_setup);
#endif
#ifdef SYS_io_submit
    printf("%-30s %d\n", "SYS_io_submit", SYS_io_submit);
#endif
#ifdef SYS_ioctl
    printf("%-30s %d\n", "SYS_ioctl", SYS_ioctl);
#endif
#ifdef SYS_ioperm
    printf("%-30s %d\n", "SYS_ioperm", SYS_ioperm);
#endif
#ifdef SYS_iopl
    printf("%-30s %d\n", "SYS_iopl", SYS_iopl);
#endif
#ifdef SYS_ioprio_get
    printf("%-30s %d\n", "SYS_ioprio_get", SYS_ioprio_get);
#endif
#ifdef SYS_ioprio_set
    printf("%-30s %d\n", "SYS_ioprio_set", SYS_ioprio_set);
#endif
#ifdef SYS_kexec_load
    printf("%-30s %d\n", "SYS_kexec_load", SYS_kexec_load);
#endif
#ifdef SYS_keyctl
    printf("%-30s %d\n", "SYS_keyctl", SYS_keyctl);
#endif
#ifdef SYS_kill
    printf("%-30s %d\n", "SYS_kill", SYS_kill);
#endif
#ifdef SYS_lchown
    printf("%-30s %d\n", "SYS_lchown", SYS_lchown);
#endif
#ifdef SYS_lgetxattr
    printf("%-30s %d\n", "SYS_lgetxattr", SYS_lgetxattr);
#endif
#ifdef SYS_link
    printf("%-30s %d\n", "SYS_link", SYS_link);
#endif
#ifdef SYS_linkat
    printf("%-30s %d\n", "SYS_linkat", SYS_linkat);
#endif
#ifdef SYS_listxattr
    printf("%-30s %d\n", "SYS_listxattr", SYS_listxattr);
#endif
#ifdef SYS_llistxattr
    printf("%-30s %d\n", "SYS_llistxattr", SYS_llistxattr);
#endif
#ifdef SYS_lookup_dcookie
    printf("%-30s %d\n", "SYS_lookup_dcookie", SYS_lookup_dcookie);
#endif
#ifdef SYS_lremovexattr
    printf("%-30s %d\n", "SYS_lremovexattr", SYS_lremovexattr);
#endif
#ifdef SYS_lseek
    printf("%-30s %d\n", "SYS_lseek", SYS_lseek);
#endif
#ifdef SYS_lsetxattr
    printf("%-30s %d\n", "SYS_lsetxattr", SYS_lsetxattr);
#endif
#ifdef SYS_lstat
    printf("%-30s %d\n", "SYS_lstat", SYS_lstat);
#endif
#ifdef SYS_madvise
    printf("%-30s %d\n", "SYS_madvise", SYS_madvise);
#endif
#ifdef SYS_mbind
    printf("%-30s %d\n", "SYS_mbind", SYS_mbind);
#endif
#ifdef SYS_migrate_pages
    printf("%-30s %d\n", "SYS_migrate_pages", SYS_migrate_pages);
#endif
#ifdef SYS_mincore
    printf("%-30s %d\n", "SYS_mincore", SYS_mincore);
#endif
#ifdef SYS_mkdir
    printf("%-30s %d\n", "SYS_mkdir", SYS_mkdir);
#endif
#ifdef SYS_mkdirat
    printf("%-30s %d\n", "SYS_mkdirat", SYS_mkdirat);
#endif
#ifdef SYS_mknod
    printf("%-30s %d\n", "SYS_mknod", SYS_mknod);
#endif
#ifdef SYS_mknodat
    printf("%-30s %d\n", "SYS_mknodat", SYS_mknodat);
#endif
#ifdef SYS_mlock
    printf("%-30s %d\n", "SYS_mlock", SYS_mlock);
#endif
#ifdef SYS_mlockall
    printf("%-30s %d\n", "SYS_mlockall", SYS_mlockall);
#endif
#ifdef SYS_mmap
    printf("%-30s %d\n", "SYS_mmap", SYS_mmap);
#endif
#ifdef SYS_modify_ldt
    printf("%-30s %d\n", "SYS_modify_ldt", SYS_modify_ldt);
#endif
#ifdef SYS_mount
    printf("%-30s %d\n", "SYS_mount", SYS_mount);
#endif
#ifdef SYS_move_pages
    printf("%-30s %d\n", "SYS_move_pages", SYS_move_pages);
#endif
#ifdef SYS_mprotect
    printf("%-30s %d\n", "SYS_mprotect", SYS_mprotect);
#endif
#ifdef SYS_mq_getsetattr
    printf("%-30s %d\n", "SYS_mq_getsetattr", SYS_mq_getsetattr);
#endif
#ifdef SYS_mq_notify
    printf("%-30s %d\n", "SYS_mq_notify", SYS_mq_notify);
#endif
#ifdef SYS_mq_open
    printf("%-30s %d\n", "SYS_mq_open", SYS_mq_open);
#endif
#ifdef SYS_mq_timedreceive
    printf("%-30s %d\n", "SYS_mq_timedreceive", SYS_mq_timedreceive);
#endif
#ifdef SYS_mq_timedsend
    printf("%-30s %d\n", "SYS_mq_timedsend", SYS_mq_timedsend);
#endif
#ifdef SYS_mq_unlink
    printf("%-30s %d\n", "SYS_mq_unlink", SYS_mq_unlink);
#endif
#ifdef SYS_mremap
    printf("%-30s %d\n", "SYS_mremap", SYS_mremap);
#endif
#ifdef SYS_msync
    printf("%-30s %d\n", "SYS_msync", SYS_msync);
#endif
#ifdef SYS_munlock
    printf("%-30s %d\n", "SYS_munlock", SYS_munlock);
#endif
#ifdef SYS_munlockall
    printf("%-30s %d\n", "SYS_munlockall", SYS_munlockall);
#endif
#ifdef SYS_munmap
    printf("%-30s %d\n", "SYS_munmap", SYS_munmap);
#endif
#ifdef SYS_nanosleep
    printf("%-30s %d\n", "SYS_nanosleep", SYS_nanosleep);
#endif
#ifdef SYS_nfsservctl
    printf("%-30s %d\n", "SYS_nfsservctl", SYS_nfsservctl);
#endif
#ifdef SYS_open
    printf("%-30s %d\n", "SYS_open", SYS_open);
#endif
#ifdef SYS_openat
    printf("%-30s %d\n", "SYS_openat", SYS_openat);
#endif
#ifdef SYS_pause
    printf("%-30s %d\n", "SYS_pause", SYS_pause);
#endif
#ifdef SYS_perf_event_open
    printf("%-30s %d\n", "SYS_perf_event_open", SYS_perf_event_open);
#endif
#ifdef SYS_personality
    printf("%-30s %d\n", "SYS_personality", SYS_personality);
#endif
#ifdef SYS_pipe
    printf("%-30s %d\n", "SYS_pipe", SYS_pipe);
#endif
#ifdef SYS_pipe2
    printf("%-30s %d\n", "SYS_pipe2", SYS_pipe2);
#endif
#ifdef SYS_pivot_root
    printf("%-30s %d\n", "SYS_pivot_root", SYS_pivot_root);
#endif
#ifdef SYS_poll
    printf("%-30s %d\n", "SYS_poll", SYS_poll);
#endif
#ifdef SYS_ppoll
    printf("%-30s %d\n", "SYS_ppoll", SYS_ppoll);
#endif
#ifdef SYS_prctl
    printf("%-30s %d\n", "SYS_prctl", SYS_prctl);
#endif
#ifdef SYS_pread64
    printf("%-30s %d\n", "SYS_pread64", SYS_pread64);
#endif
#ifdef SYS_preadv
    printf("%-30s %d\n", "SYS_preadv", SYS_preadv);
#endif
#ifdef SYS_pselect6
    printf("%-30s %d\n", "SYS_pselect6", SYS_pselect6);
#endif
#ifdef SYS_ptrace
    printf("%-30s %d\n", "SYS_ptrace", SYS_ptrace);
#endif
#ifdef SYS_putpmsg
    printf("%-30s %d\n", "SYS_putpmsg", SYS_putpmsg);
#endif
#ifdef SYS_pwrite64
    printf("%-30s %d\n", "SYS_pwrite64", SYS_pwrite64);
#endif
#ifdef SYS_pwritev
    printf("%-30s %d\n", "SYS_pwritev", SYS_pwritev);
#endif
#ifdef SYS_query_module
    printf("%-30s %d\n", "SYS_query_module", SYS_query_module);
#endif
#ifdef SYS_quotactl
    printf("%-30s %d\n", "SYS_quotactl", SYS_quotactl);
#endif
#ifdef SYS_read
    printf("%-30s %d\n", "SYS_read", SYS_read);
#endif
#ifdef SYS_readahead
    printf("%-30s %d\n", "SYS_readahead", SYS_readahead);
#endif
#ifdef SYS_readlink
    printf("%-30s %d\n", "SYS_readlink", SYS_readlink);
#endif
#ifdef SYS_readlinkat
    printf("%-30s %d\n", "SYS_readlinkat", SYS_readlinkat);
#endif
#ifdef SYS_readv
    printf("%-30s %d\n", "SYS_readv", SYS_readv);
#endif
#ifdef SYS_reboot
    printf("%-30s %d\n", "SYS_reboot", SYS_reboot);
#endif
#ifdef SYS_remap_file_pages
    printf("%-30s %d\n", "SYS_remap_file_pages", SYS_remap_file_pages);
#endif
#ifdef SYS_removexattr
    printf("%-30s %d\n", "SYS_removexattr", SYS_removexattr);
#endif
#ifdef SYS_rename
    printf("%-30s %d\n", "SYS_rename", SYS_rename);
#endif
#ifdef SYS_renameat
    printf("%-30s %d\n", "SYS_renameat", SYS_renameat);
#endif
#ifdef SYS_request_key
    printf("%-30s %d\n", "SYS_request_key", SYS_request_key);
#endif
#ifdef SYS_restart_syscall
    printf("%-30s %d\n", "SYS_restart_syscall", SYS_restart_syscall);
#endif
#ifdef SYS_rmdir
    printf("%-30s %d\n", "SYS_rmdir", SYS_rmdir);
#endif
#ifdef SYS_rt_sigaction
    printf("%-30s %d\n", "SYS_rt_sigaction", SYS_rt_sigaction);
#endif
#ifdef SYS_rt_sigpending
    printf("%-30s %d\n", "SYS_rt_sigpending", SYS_rt_sigpending);
#endif
#ifdef SYS_rt_sigprocmask
    printf("%-30s %d\n", "SYS_rt_sigprocmask", SYS_rt_sigprocmask);
#endif
#ifdef SYS_rt_sigqueueinfo
    printf("%-30s %d\n", "SYS_rt_sigqueueinfo", SYS_rt_sigqueueinfo);
#endif
#ifdef SYS_rt_sigreturn
    printf("%-30s %d\n", "SYS_rt_sigreturn", SYS_rt_sigreturn);
#endif
#ifdef SYS_rt_sigsuspend
    printf("%-30s %d\n", "SYS_rt_sigsuspend", SYS_rt_sigsuspend);
#endif
#ifdef SYS_rt_sigtimedwait
    printf("%-30s %d\n", "SYS_rt_sigtimedwait", SYS_rt_sigtimedwait);
#endif
#ifdef SYS_rt_tgsigqueueinfo
    printf("%-30s %d\n", "SYS_rt_tgsigqueueinfo", SYS_rt_tgsigqueueinfo);
#endif
#ifdef SYS_sched_get_priority_max
    printf("%-30s %d\n", "SYS_sched_get_priority_max", SYS_sched_get_priority_max);
#endif
#ifdef SYS_sched_get_priority_min
    printf("%-30s %d\n", "SYS_sched_get_priority_min", SYS_sched_get_priority_min);
#endif
#ifdef SYS_sched_getaffinity
    printf("%-30s %d\n", "SYS_sched_getaffinity", SYS_sched_getaffinity);
#endif
#ifdef SYS_sched_getparam
    printf("%-30s %d\n", "SYS_sched_getparam", SYS_sched_getparam);
#endif
#ifdef SYS_sched_getscheduler
    printf("%-30s %d\n", "SYS_sched_getscheduler", SYS_sched_getscheduler);
#endif
#ifdef SYS_sched_rr_get_interval
    printf("%-30s %d\n", "SYS_sched_rr_get_interval", SYS_sched_rr_get_interval);
#endif
#ifdef SYS_sched_setaffinity
    printf("%-30s %d\n", "SYS_sched_setaffinity", SYS_sched_setaffinity);
#endif
#ifdef SYS_sched_setparam
    printf("%-30s %d\n", "SYS_sched_setparam", SYS_sched_setparam);
#endif
#ifdef SYS_sched_setscheduler
    printf("%-30s %d\n", "SYS_sched_setscheduler", SYS_sched_setscheduler);
#endif
#ifdef SYS_sched_yield
    printf("%-30s %d\n", "SYS_sched_yield", SYS_sched_yield);
#endif
#ifdef SYS_select
    printf("%-30s %d\n", "SYS_select", SYS_select);
#endif
#ifdef SYS_sendfile
    printf("%-30s %d\n", "SYS_sendfile", SYS_sendfile);
#endif
#ifdef SYS_set_mempolicy
    printf("%-30s %d\n", "SYS_set_mempolicy", SYS_set_mempolicy);
#endif
#ifdef SYS_set_robust_list
    printf("%-30s %d\n", "SYS_set_robust_list", SYS_set_robust_list);
#endif
#ifdef SYS_set_thread_area
    printf("%-30s %d\n", "SYS_set_thread_area", SYS_set_thread_area);
#endif
#ifdef SYS_set_tid_address
    printf("%-30s %d\n", "SYS_set_tid_address", SYS_set_tid_address);
#endif
#ifdef SYS_setdomainname
    printf("%-30s %d\n", "SYS_setdomainname", SYS_setdomainname);
#endif
#ifdef SYS_setfsgid
    printf("%-30s %d\n", "SYS_setfsgid", SYS_setfsgid);
#endif
#ifdef SYS_setfsuid
    printf("%-30s %d\n", "SYS_setfsuid", SYS_setfsuid);
#endif
#ifdef SYS_setgid
    printf("%-30s %d\n", "SYS_setgid", SYS_setgid);
#endif
#ifdef SYS_setgroups
    printf("%-30s %d\n", "SYS_setgroups", SYS_setgroups);
#endif
#ifdef SYS_sethostname
    printf("%-30s %d\n", "SYS_sethostname", SYS_sethostname);
#endif
#ifdef SYS_setitimer
    printf("%-30s %d\n", "SYS_setitimer", SYS_setitimer);
#endif
#ifdef SYS_setpgid
    printf("%-30s %d\n", "SYS_setpgid", SYS_setpgid);
#endif
#ifdef SYS_setpriority
    printf("%-30s %d\n", "SYS_setpriority", SYS_setpriority);
#endif
#ifdef SYS_setregid
    printf("%-30s %d\n", "SYS_setregid", SYS_setregid);
#endif
#ifdef SYS_setresgid
    printf("%-30s %d\n", "SYS_setresgid", SYS_setresgid);
#endif
#ifdef SYS_setresuid
    printf("%-30s %d\n", "SYS_setresuid", SYS_setresuid);
#endif
#ifdef SYS_setreuid
    printf("%-30s %d\n", "SYS_setreuid", SYS_setreuid);
#endif
#ifdef SYS_setrlimit
    printf("%-30s %d\n", "SYS_setrlimit", SYS_setrlimit);
#endif
#ifdef SYS_setsid
    printf("%-30s %d\n", "SYS_setsid", SYS_setsid);
#endif
#ifdef SYS_settimeofday
    printf("%-30s %d\n", "SYS_settimeofday", SYS_settimeofday);
#endif
#ifdef SYS_setuid
    printf("%-30s %d\n", "SYS_setuid", SYS_setuid);
#endif
#ifdef SYS_setxattr
    printf("%-30s %d\n", "SYS_setxattr", SYS_setxattr);
#endif
#ifdef SYS_sigaltstack
    printf("%-30s %d\n", "SYS_sigaltstack", SYS_sigaltstack);
#endif
#ifdef SYS_signalfd
    printf("%-30s %d\n", "SYS_signalfd", SYS_signalfd);
#endif
#ifdef SYS_signalfd4
    printf("%-30s %d\n", "SYS_signalfd4", SYS_signalfd4);
#endif
#ifdef SYS_splice
    printf("%-30s %d\n", "SYS_splice", SYS_splice);
#endif
#ifdef SYS_stat
    printf("%-30s %d\n", "SYS_stat", SYS_stat);
#endif
#ifdef SYS_statfs
    printf("%-30s %d\n", "SYS_statfs", SYS_statfs);
#endif
#ifdef SYS_swapoff
    printf("%-30s %d\n", "SYS_swapoff", SYS_swapoff);
#endif
#ifdef SYS_swapon
    printf("%-30s %d\n", "SYS_swapon", SYS_swapon);
#endif
#ifdef SYS_symlink
    printf("%-30s %d\n", "SYS_symlink", SYS_symlink);
#endif
#ifdef SYS_symlinkat
    printf("%-30s %d\n", "SYS_symlinkat", SYS_symlinkat);
#endif
#ifdef SYS_sync
    printf("%-30s %d\n", "SYS_sync", SYS_sync);
#endif
#ifdef SYS_sync_file_range
    printf("%-30s %d\n", "SYS_sync_file_range", SYS_sync_file_range);
#endif
#ifdef SYS_sysfs
    printf("%-30s %d\n", "SYS_sysfs", SYS_sysfs);
#endif
#ifdef SYS_sysinfo
    printf("%-30s %d\n", "SYS_sysinfo", SYS_sysinfo);
#endif
#ifdef SYS_syslog
    printf("%-30s %d\n", "SYS_syslog", SYS_syslog);
#endif
#ifdef SYS_tee
    printf("%-30s %d\n", "SYS_tee", SYS_tee);
#endif
#ifdef SYS_tgkill
    printf("%-30s %d\n", "SYS_tgkill", SYS_tgkill);
#endif
#ifdef SYS_time
    printf("%-30s %d\n", "SYS_time", SYS_time);
#endif
#ifdef SYS_timer_create
    printf("%-30s %d\n", "SYS_timer_create", SYS_timer_create);
#endif
#ifdef SYS_timer_delete
    printf("%-30s %d\n", "SYS_timer_delete", SYS_timer_delete);
#endif
#ifdef SYS_timer_getoverrun
    printf("%-30s %d\n", "SYS_timer_getoverrun", SYS_timer_getoverrun);
#endif
#ifdef SYS_timer_gettime
    printf("%-30s %d\n", "SYS_timer_gettime", SYS_timer_gettime);
#endif
#ifdef SYS_timer_settime
    printf("%-30s %d\n", "SYS_timer_settime", SYS_timer_settime);
#endif
#ifdef SYS_timerfd_create
    printf("%-30s %d\n", "SYS_timerfd_create", SYS_timerfd_create);
#endif
#ifdef SYS_timerfd_gettime
    printf("%-30s %d\n", "SYS_timerfd_gettime", SYS_timerfd_gettime);
#endif
#ifdef SYS_timerfd_settime
    printf("%-30s %d\n", "SYS_timerfd_settime", SYS_timerfd_settime);
#endif
#ifdef SYS_times
    printf("%-30s %d\n", "SYS_times", SYS_times);
#endif
#ifdef SYS_tkill
    printf("%-30s %d\n", "SYS_tkill", SYS_tkill);
#endif
#ifdef SYS_truncate
    printf("%-30s %d\n", "SYS_truncate", SYS_truncate);
#endif
#ifdef SYS_umask
    printf("%-30s %d\n", "SYS_umask", SYS_umask);
#endif
#ifdef SYS_umount2
    printf("%-30s %d\n", "SYS_umount2", SYS_umount2);
#endif
#ifdef SYS_uname
    printf("%-30s %d\n", "SYS_uname", SYS_uname);
#endif
#ifdef SYS_unlink
    printf("%-30s %d\n", "SYS_unlink", SYS_unlink);
#endif
#ifdef SYS_unlinkat
    printf("%-30s %d\n", "SYS_unlinkat", SYS_unlinkat);
#endif
#ifdef SYS_unshare
    printf("%-30s %d\n", "SYS_unshare", SYS_unshare);
#endif
#ifdef SYS_uselib
    printf("%-30s %d\n", "SYS_uselib", SYS_uselib);
#endif
#ifdef SYS_ustat
    printf("%-30s %d\n", "SYS_ustat", SYS_ustat);
#endif
#ifdef SYS_utime
    printf("%-30s %d\n", "SYS_utime", SYS_utime);
#endif
#ifdef SYS_utimensat
    printf("%-30s %d\n", "SYS_utimensat", SYS_utimensat);
#endif
#ifdef SYS_utimes
    printf("%-30s %d\n", "SYS_utimes", SYS_utimes);
#endif
#ifdef SYS_vfork
    printf("%-30s %d\n", "SYS_vfork", SYS_vfork);
#endif
#ifdef SYS_vhangup
    printf("%-30s %d\n", "SYS_vhangup", SYS_vhangup);
#endif
#ifdef SYS_vmsplice
    printf("%-30s %d\n", "SYS_vmsplice", SYS_vmsplice);
#endif
#ifdef SYS_vserver
    printf("%-30s %d\n", "SYS_vserver", SYS_vserver);
#endif
#ifdef SYS_wait4
    printf("%-30s %d\n", "SYS_wait4", SYS_wait4);
#endif
#ifdef SYS_waitid
    printf("%-30s %d\n", "SYS_waitid", SYS_waitid);
#endif
#ifdef SYS_write
    printf("%-30s %d\n", "SYS_write", SYS_write);
#endif
#ifdef SYS_writev
    printf("%-30s %d\n", "SYS_writev", SYS_writev);
#endif

#if __WORDSIZE == 64

#ifdef SYS_accept
    printf("%-30s %d\n", "SYS_accept", SYS_accept);
#endif
#ifdef SYS_accept4
    printf("%-30s %d\n", "SYS_accept4", SYS_accept4);
#endif
#ifdef SYS_arch_prctl
    printf("%-30s %d\n", "SYS_arch_prctl", SYS_arch_prctl);
#endif
#ifdef SYS_bind
    printf("%-30s %d\n", "SYS_bind", SYS_bind);
#endif
#ifdef SYS_connect
    printf("%-30s %d\n", "SYS_connect", SYS_connect);
#endif
#ifdef SYS_epoll_ctl_old
    printf("%-30s %d\n", "SYS_epoll_ctl_old", SYS_epoll_ctl_old);
#endif
#ifdef SYS_epoll_wait_old
    printf("%-30s %d\n", "SYS_epoll_wait_old", SYS_epoll_wait_old);
#endif
#ifdef SYS_getpeername
    printf("%-30s %d\n", "SYS_getpeername", SYS_getpeername);
#endif
#ifdef SYS_getsockname
    printf("%-30s %d\n", "SYS_getsockname", SYS_getsockname);
#endif
#ifdef SYS_getsockopt
    printf("%-30s %d\n", "SYS_getsockopt", SYS_getsockopt);
#endif
#ifdef SYS_listen
    printf("%-30s %d\n", "SYS_listen", SYS_listen);
#endif
#ifdef SYS_msgctl
    printf("%-30s %d\n", "SYS_msgctl", SYS_msgctl);
#endif
#ifdef SYS_msgget
    printf("%-30s %d\n", "SYS_msgget", SYS_msgget);
#endif
#ifdef SYS_msgrcv
    printf("%-30s %d\n", "SYS_msgrcv", SYS_msgrcv);
#endif
#ifdef SYS_msgsnd
    printf("%-30s %d\n", "SYS_msgsnd", SYS_msgsnd);
#endif
#ifdef SYS_newfstatat
    printf("%-30s %d\n", "SYS_newfstatat", SYS_newfstatat);
#endif
#ifdef SYS_recvfrom
    printf("%-30s %d\n", "SYS_recvfrom", SYS_recvfrom);
#endif
#ifdef SYS_recvmsg
    printf("%-30s %d\n", "SYS_recvmsg", SYS_recvmsg);
#endif
#ifdef SYS_security
    printf("%-30s %d\n", "SYS_security", SYS_security);
#endif
#ifdef SYS_semctl
    printf("%-30s %d\n", "SYS_semctl", SYS_semctl);
#endif
#ifdef SYS_semget
    printf("%-30s %d\n", "SYS_semget", SYS_semget);
#endif
#ifdef SYS_semop
    printf("%-30s %d\n", "SYS_semop", SYS_semop);
#endif
#ifdef SYS_semtimedop
    printf("%-30s %d\n", "SYS_semtimedop", SYS_semtimedop);
#endif
#ifdef SYS_sendmsg
    printf("%-30s %d\n", "SYS_sendmsg", SYS_sendmsg);
#endif
#ifdef SYS_sendto
    printf("%-30s %d\n", "SYS_sendto", SYS_sendto);
#endif
#ifdef SYS_setsockopt
    printf("%-30s %d\n", "SYS_setsockopt", SYS_setsockopt);
#endif
#ifdef SYS_shmat
    printf("%-30s %d\n", "SYS_shmat", SYS_shmat);
#endif
#ifdef SYS_shmctl
    printf("%-30s %d\n", "SYS_shmctl", SYS_shmctl);
#endif
#ifdef SYS_shmdt
    printf("%-30s %d\n", "SYS_shmdt", SYS_shmdt);
#endif
#ifdef SYS_shmget
    printf("%-30s %d\n", "SYS_shmget", SYS_shmget);
#endif
#ifdef SYS_shutdown
    printf("%-30s %d\n", "SYS_shutdown", SYS_shutdown);
#endif
#ifdef SYS_socket
    printf("%-30s %d\n", "SYS_socket", SYS_socket);
#endif
#ifdef SYS_socketpair
    printf("%-30s %d\n", "SYS_socketpair", SYS_socketpair);
#endif
#ifdef SYS_tuxcall
    printf("%-30s %d\n", "SYS_tuxcall", SYS_tuxcall);
#endif

#ifdef SYS__llseek
    printf("%-30s %d\n", "SYS__llseek", SYS__llseek);
#endif
#ifdef SYS__newselect
    printf("%-30s %d\n", "SYS__newselect", SYS__newselect);
#endif
#ifdef SYS_bdflush
    printf("%-30s %d\n", "SYS_bdflush", SYS_bdflush);
#endif
#ifdef SYS_break
    printf("%-30s %d\n", "SYS_break", SYS_break);
#endif
#ifdef SYS_chown32
    printf("%-30s %d\n", "SYS_chown32", SYS_chown32);
#endif
#ifdef SYS_fadvise64_64
    printf("%-30s %d\n", "SYS_fadvise64_64", SYS_fadvise64_64);
#endif
#ifdef SYS_fchown32
    printf("%-30s %d\n", "SYS_fchown32", SYS_fchown32);
#endif
#ifdef SYS_fcntl64
    printf("%-30s %d\n", "SYS_fcntl64", SYS_fcntl64);
#endif
#ifdef SYS_fstat64
    printf("%-30s %d\n", "SYS_fstat64", SYS_fstat64);
#endif
#ifdef SYS_fstatat64
    printf("%-30s %d\n", "SYS_fstatat64", SYS_fstatat64);
#endif
#ifdef SYS_fstatfs64
    printf("%-30s %d\n", "SYS_fstatfs64", SYS_fstatfs64);
#endif
#ifdef SYS_ftime
    printf("%-30s %d\n", "SYS_ftime", SYS_ftime);
#endif
#ifdef SYS_ftruncate64
    printf("%-30s %d\n", "SYS_ftruncate64", SYS_ftruncate64);
#endif
#ifdef SYS_getcpu
    printf("%-30s %d\n", "SYS_getcpu", SYS_getcpu);
#endif
#ifdef SYS_getegid32
    printf("%-30s %d\n", "SYS_getegid32", SYS_getegid32);
#endif
#ifdef SYS_geteuid32
    printf("%-30s %d\n", "SYS_geteuid32", SYS_geteuid32);
#endif
#ifdef SYS_getgid32
    printf("%-30s %d\n", "SYS_getgid32", SYS_getgid32);
#endif
#ifdef SYS_getgroups32
    printf("%-30s %d\n", "SYS_getgroups32", SYS_getgroups32);
#endif
#ifdef SYS_getresgid32
    printf("%-30s %d\n", "SYS_getresgid32", SYS_getresgid32);
#endif
#ifdef SYS_getresuid32
    printf("%-30s %d\n", "SYS_getresuid32", SYS_getresuid32);
#endif
#ifdef SYS_getuid32
    printf("%-30s %d\n", "SYS_getuid32", SYS_getuid32);
#endif
#ifdef SYS_gtty
    printf("%-30s %d\n", "SYS_gtty", SYS_gtty);
#endif
#ifdef SYS_idle
    printf("%-30s %d\n", "SYS_idle", SYS_idle);
#endif
#ifdef SYS_ipc
    printf("%-30s %d\n", "SYS_ipc", SYS_ipc);
#endif
#ifdef SYS_lchown32
    printf("%-30s %d\n", "SYS_lchown32", SYS_lchown32);
#endif
#ifdef SYS_lock
    printf("%-30s %d\n", "SYS_lock", SYS_lock);
#endif
#ifdef SYS_lstat64
    printf("%-30s %d\n", "SYS_lstat64", SYS_lstat64);
#endif
#ifdef SYS_madvise1
    printf("%-30s %d\n", "SYS_madvise1", SYS_madvise1);
#endif
#ifdef SYS_mmap2
    printf("%-30s %d\n", "SYS_mmap2", SYS_mmap2);
#endif
#ifdef SYS_mpx
    printf("%-30s %d\n", "SYS_mpx", SYS_mpx);
#endif
#ifdef SYS_nice
    printf("%-30s %d\n", "SYS_nice", SYS_nice);
#endif
#ifdef SYS_oldfstat
    printf("%-30s %d\n", "SYS_oldfstat", SYS_oldfstat);
#endif
#ifdef SYS_oldlstat
    printf("%-30s %d\n", "SYS_oldlstat", SYS_oldlstat);
#endif
#ifdef SYS_oldolduname
    printf("%-30s %d\n", "SYS_oldolduname", SYS_oldolduname);
#endif
#ifdef SYS_oldstat
    printf("%-30s %d\n", "SYS_oldstat", SYS_oldstat);
#endif
#ifdef SYS_olduname
    printf("%-30s %d\n", "SYS_olduname", SYS_olduname);
#endif
#ifdef SYS_prof
    printf("%-30s %d\n", "SYS_prof", SYS_prof);
#endif
#ifdef SYS_profil
    printf("%-30s %d\n", "SYS_profil", SYS_profil);
#endif
#ifdef SYS_readdir
    printf("%-30s %d\n", "SYS_readdir", SYS_readdir);
#endif
#ifdef SYS_sendfile64
    printf("%-30s %d\n", "SYS_sendfile64", SYS_sendfile64);
#endif
#ifdef SYS_setfsgid32
    printf("%-30s %d\n", "SYS_setfsgid32", SYS_setfsgid32);
#endif
#ifdef SYS_setfsuid32
    printf("%-30s %d\n", "SYS_setfsuid32", SYS_setfsuid32);
#endif
#ifdef SYS_setgid32
    printf("%-30s %d\n", "SYS_setgid32", SYS_setgid32);
#endif
#ifdef SYS_setgroups32
    printf("%-30s %d\n", "SYS_setgroups32", SYS_setgroups32);
#endif
#ifdef SYS_setregid32
    printf("%-30s %d\n", "SYS_setregid32", SYS_setregid32);
#endif
#ifdef SYS_setresgid32
    printf("%-30s %d\n", "SYS_setresgid32", SYS_setresgid32);
#endif
#ifdef SYS_setresuid32
    printf("%-30s %d\n", "SYS_setresuid32", SYS_setresuid32);
#endif
#ifdef SYS_setreuid32
    printf("%-30s %d\n", "SYS_setreuid32", SYS_setreuid32);
#endif
#ifdef SYS_setuid32
    printf("%-30s %d\n", "SYS_setuid32", SYS_setuid32);
#endif
#ifdef SYS_sgetmask
    printf("%-30s %d\n", "SYS_sgetmask", SYS_sgetmask);
#endif
#ifdef SYS_sigaction
    printf("%-30s %d\n", "SYS_sigaction", SYS_sigaction);
#endif
#ifdef SYS_signal
    printf("%-30s %d\n", "SYS_signal", SYS_signal);
#endif
#ifdef SYS_sigpending
    printf("%-30s %d\n", "SYS_sigpending", SYS_sigpending);
#endif
#ifdef SYS_sigprocmask
    printf("%-30s %d\n", "SYS_sigprocmask", SYS_sigprocmask);
#endif
#ifdef SYS_sigreturn
    printf("%-30s %d\n", "SYS_sigreturn", SYS_sigreturn);
#endif
#ifdef SYS_sigsuspend
    printf("%-30s %d\n", "SYS_sigsuspend", SYS_sigsuspend);
#endif
#ifdef SYS_socketcall
    printf("%-30s %d\n", "SYS_socketcall", SYS_socketcall);
#endif
#ifdef SYS_ssetmask
    printf("%-30s %d\n", "SYS_ssetmask", SYS_ssetmask);
#endif
#ifdef SYS_stat64
    printf("%-30s %d\n", "SYS_stat64", SYS_stat64);
#endif
#ifdef SYS_statfs64
    printf("%-30s %d\n", "SYS_statfs64", SYS_statfs64);
#endif
#ifdef SYS_stime
    printf("%-30s %d\n", "SYS_stime", SYS_stime);
#endif
#ifdef SYS_stty
    printf("%-30s %d\n", "SYS_stty", SYS_stty);
#endif
#ifdef SYS_truncate64
    printf("%-30s %d\n", "SYS_truncate64", SYS_truncate64);
#endif
#ifdef SYS_ugetrlimit
    printf("%-30s %d\n", "SYS_ugetrlimit", SYS_ugetrlimit);
#endif
#ifdef SYS_ulimit
    printf("%-30s %d\n", "SYS_ulimit", SYS_ulimit);
#endif
#ifdef SYS_umount
    printf("%-30s %d\n", "SYS_umount", SYS_umount);
#endif
#ifdef SYS_vm86
    printf("%-30s %d\n", "SYS_vm86", SYS_vm86);
#endif
#ifdef SYS_vm86old
    printf("%-30s %d\n", "SYS_vm86old", SYS_vm86old);
#endif
#ifdef SYS_waitpid
    printf("%-30s %d\n", "SYS_waitpid", SYS_waitpid);
#endif
#endif
    return 0;
}
