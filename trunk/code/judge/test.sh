#!/bin/bash
./judge_c.exe -s "test/1001.c" -n 1001 -D "test" -d "test/temp" -t 2000 -m 32768 -o 1024 -S
echo $?
