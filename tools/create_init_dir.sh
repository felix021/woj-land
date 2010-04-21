#!/bin/bash
WOJ_ROOT=~/woj

mkdir -p ${WOJ_ROOT}/{data,log,temp,upload}
cd ${WOJ_ROOT}
mkdir data/1001
cd data/1001
echo 1 > data.txt
echo 1 2 > 1.in
echo 3 > 1.out

