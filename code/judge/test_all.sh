#!/bin/bash

# ac pe wa ce re tle...
select=ac

# 1=c, 2=cpp, 3=java, 4=pascal
lang=1

ext=c

#spj=-S

src=1001_${select}.${ext}

sudo ./judge_all.exe -l ${lang} -u 0001 -s "test/${src}" -n 1001 -D "test" -d "test/temp" -t 1000 -m 32768 -o 4096 ${spj}

echo -e "\nExit status: $?"

sudo chown -R $USER:$USER test/temp
