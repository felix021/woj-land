TARGET=judge_*.exe

${TARGET}: judge_c.cpp judge_cpp.cpp judge_pascal.cpp
	g++ -O2 -o judge_c.exe 		judge_c.cpp
	g++ -O2 -o judge_cpp.exe 	judge_cpp.cpp
	g++ -O2 -o judge_pascal.exe judge_pascal.cpp

clean:
	rm -rf ${TARGET}
