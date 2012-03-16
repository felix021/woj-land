#include <iostream>
#include <vector>
#include <string>
#include <map>
#include <cstdio>
#include <cstdlib>
#include <cmath>
#include <cstring>
using namespace std;

const int EXIT_OK               = 0;
const int EXIT_BAD_CMDLINE      = 1;
const int EXIT_BAD_FILE         = 2;
const int EXIT_NO_JUDGEMENT     = 3;
enum result_type { AC = 1, PE = 2, WA = 3 };

string ans_in_path, ans_out_path, user_out_path, src_file_path;
FILE *fans_in = NULL, *fans_out = NULL, *fuser_out = NULL;

void fail(const char *reason, int errcode);
void answer_ac();
void answer_pe();
void answer_wa();
string file_get_contents(string filename);
string filter_space(string s);
int strpos(string, string, int);

int check_code() {
    string code = file_get_contents(src_file_path);
    code = filter_space(code);
    string pattern = "PATTERN";
    return strpos(code, pattern, 0) >= 0;
}

void judge()
{
    string user_out = file_get_contents(user_out_path);
    string ans_out = file_get_contents(ans_out_path);

    //if (!check_code()) answer_wa();

    if (user_out != ans_out) {
        user_out = filter_space(user_out);
        ans_out  = filter_space(ans_out);
        if (user_out == ans_out)
            answer_pe();
        else
            answer_wa();
    }
    answer_ac();
}

int main(int argc, char *argv[])
{
    if (argc != 5)
        fail("bad cmdline args", EXIT_BAD_CMDLINE);

    ans_out_path     = argv[1];
    ans_in_path      = argv[2];
    user_out_path    = argv[3];
    src_file_path    = argv[4];

    fans_out = fopen(argv[1], "rb");
    if (!fans_out) fail("open ans_out", EXIT_BAD_FILE);

    fans_in = fopen(argv[2], "rb");
    if (!fans_in) fail("open ans_in", EXIT_BAD_FILE);

    fuser_out = fopen(argv[3], "rb");
    if (!fuser_out) fail("open user_out", EXIT_BAD_FILE);

    void exit_func(void);
    atexit(exit_func);

    judge();

    return EXIT_NO_JUDGEMENT;
}

void exit_func(void) {
    if (!fans_in)   fclose(fans_in);
    if (!fans_out)  fclose(fans_out);
    if (!fuser_out) fclose(fuser_out);
}

void fail(const char *reason, int errcode) {
    fprintf(stderr, "%s\n", reason);
    exit(errcode);
}

void answer_ac() { printf("AC"); exit(EXIT_OK); }
void answer_pe() { printf("PE"); exit(EXIT_OK); }
void answer_wa() { printf("WA"); exit(EXIT_OK); }

string file_get_contents(string filepath)
{
    string content;
    char buf[1024];

    FILE *fp = fopen(filepath.c_str(), "rb");
    if (!fp)
        fail("open file failed", EXIT_BAD_FILE);

    while (fgets(buf, 1024, fp) != NULL) {
        content += buf;
    }

    fclose(fp);
    return content;
}

string filter_space(string s)
{
    string t;
    for (unsigned i = 0; i < s.size(); i++) {
        if (s[i] != '\t' && s[i] != '\n' && s[i] != '\r' && s[i] != ' ')
            t += s[i];
    }
    return t;
}

int strpos(string str, string substr, int offset)
{
    unsigned i, j;
    for (i = offset; i < str.size(); i++) {
        for (j = 0; j < substr.size(); j++)
            if (i + j >= str.size() || str[i+j] != substr[j])
                break;
        if (j == substr.size())
            return i;
    }
    return -1;
}

