#include <iostream>
#include <string>
#include <cstdio>
#include <cstdlib>
#include "judge.h"

using namespace std;

int main(int argc, char *argv[])
{
    problem::lang = 1;
    log_open("judge_c.log");
    parse_arguments(argc, argv);
    return 0;
}
