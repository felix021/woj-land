#!/bin/bash

# ac pe wa ce re tle...
#spj=-S

sudo ./judge_java.exe -u 0001 -s "test/Main.java" -n 1001 -D "test" -d "test/temp" -t 1000 -m 32768 -o 4096 $spj
#./judge_c.exe -u 0001 -s "test/$src" -n 1001 -D "/home/acm/oak/data/1001" -d "test/temp" -t 1000 -m 32768 -o 1024 $spj
echo -e "\nExit status: $?"

sudo chown -R $USER:$USER test/temp

