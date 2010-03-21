#include <stdio.h>
#include <unistd.h>
#include <signal.h>
#include <stdlib.h>
#include <fcntl.h>

void sig_handler(int signo)
{
    return;
}



int cmp(void *a, void *b)
{
    int x = *(int *)a, y = *(int*)b;
    return x == y ? 0 : x > y ? 1 : -1;
}

int main()
{
    int a, b, fd;
    FILE *fp = NULL;
    pid_t pid = 0;
    scanf("%d%d", &a, &b);
    printf("%d\n", a + b);
    //fflush(stdout); //ok
    //int t[5] = {1, 2, 3, 4, 5}; qsort(t, 5, sizeof(int), cmp); //ok
    //fp = fopen("1.txt", "w"); //rf
    //signal(SIGALRM, sig_handler); //rf
    //fp = popen("ls -l", "r"); //rf
    //fd = creat("1.txt", O_WRONLY);//rf
    //pid = fork(); //rf
    exit(0);

    return 0;
}
