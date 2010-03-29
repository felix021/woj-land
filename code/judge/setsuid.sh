#!/bin/bash
if [ ! -z $1 ]; then
    sudo rm judge_c.exe
    make
else
    sudo chown root:root judge_c.exe
    sudo chmod 4755 judge_c.exe
fi
