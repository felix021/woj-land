#!/usr/bin/python

import os
import sys
import socket
import Queue
import thread
import time

import conf

ids = Queue.Queue()

def worker(tid):
    print "tid: %d" % (tid)
    while True:
        src_id = ids.get(True)
        print "tid: %d, src_id: %d" % (tid, src_id)
        cmd = "%s %d &>/dev/null" % (conf.JUDGE_PATH, src_id)
        os.system(cmd)

print "BEGIN"

for i in range(0, conf.MAX_THREADS):
    thread.start_new_thread(worker, (i,))

sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)

sock.bind(("127.0.0.1", conf.PORT))
sock.listen(128)

while True:
    connection, addr = sock.accept()
    if addr[0] != "127.0.0.1":
        print "Bad request"
        connection.close()
        continue
    try:
        connection.settimeout(3)
        buf = connection.recv(1024)
        source_id = int(buf)
        ids.put(source_id)
        connection.send("%d\n" % source_id)
    except:
        print 'exception'
    connection.close()
