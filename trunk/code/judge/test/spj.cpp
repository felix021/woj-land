#include <stdio.h>
#include <unistd.h>
#include <string.h>

#define buff_len 1024

int main(int argc, char *argv[])
{
    fprintf(stderr, "file_std: %s\n", argv[1]);
    FILE *fp = fopen(argv[1], "r");
    char a[buff_len], b[buff_len], *p;
    //while (true) sleep(100); //for TLE test
    while (true) 
    {
        //p = fgets(a, buff_len, (FILE *)p); //for RE test
        p = fgets(a, buff_len, fp);
        p = fgets(b, buff_len, stdin);
        if (feof(fp) && feof(stdin)) break;
        //fprintf(stderr, "a: %sb: %s\n", a, b); //for test
        if (strcmp(a, b) != 0 || feof(fp) || feof(stdin))
        {
            printf("WA");
            fprintf(stderr, "a: %sb: %s\n", a, b); //for test
            return 0;
        }
    }
    printf("AC");
    return 0;
}
