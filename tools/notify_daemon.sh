#!/bin/bash
host=localhost
port=9527
src_ids=

if [ -z "$1" ]; then
    echo Usage: $0 src_id [host [port]]
    exit;
fi
src_id=$1

if [ ! -z $2 ]; then
    host=$2
fi

if [ ! -z $3 ]; then
    port=$3
fi

echo -n "Returned: "
echo $src_id | nc $host $port
echo
