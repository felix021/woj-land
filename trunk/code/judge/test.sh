#!/bin/bash

# ac pe wa ce re tle...
select=ac
#spj=-S

src=1001_${select}.c

sudo ./judge_c.exe -u 0001 -s "test/$src" -n 1001 -D "test" -d "test/temp" -t 1000 -m 32768 -o 1024 $spj
#./judge_c.exe -u 0001 -s "test/$src" -n 1001 -D "/home/acm/oak/data/1001" -d "test/temp" -t 1000 -m 32768 -o 1024 $spj
echo -e "\nExit status: $?"

sudo chown -R $USER:$USER test/temp
