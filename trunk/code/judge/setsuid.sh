#!/bin/bash
if [ ! -z $1 ]; then
    sudo rm judge_*.exe
    make
else
    sudo chown root:root judge_*.exe
    sudo chmod 4755 judge_*.exe
fi
