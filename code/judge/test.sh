#!/bin/bash
ac=1
if [ $ac -eq 1 ]; then
    ./judge_c.exe -u 0000 -s "test/1001.c" -n 1001 -D "test" -d "test/temp" -t 4000 -m 32768 -o 1024 -S
else
    ./judge_c.exe -u 0001 -s "test/1001_ce.c" -n 1001 -D "test" -d "test/temp" -t 1000 -m 32768 -o 1024 -S
fi
echo -e "\nExit status: $?"
