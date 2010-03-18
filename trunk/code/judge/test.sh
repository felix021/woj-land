#!/bin/bash

# ac pe wa ce ...
select=ac
#spj=-S

case $select in
    ac) src=1001.c
    ;;
    pe) src=1001_pe.c
    ;;
    wa) src=1001_wa.c
    ;;
    ce) src=1001_ce.c
    ;;
    #*)
    #echo Unknown option.
    #exit
esac

./judge_c.exe -u 0001 -s "test/$src" -n 1001 -D "test" -d "test/temp" -t 1000 -m 32768 -o 1024 $spj
#./judge_c.exe -u 0001 -s "test/$src" -n 1001 -D "/home/acm/oak/data/1001" -d "test/temp" -t 1000 -m 32768 -o 1024 $spj
echo -e "\nExit status: $?"
