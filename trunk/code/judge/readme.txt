Judge约定

主程序: 由judge_all.cpp judge.h rf_table.h 编译出judge_all.exe

输入输出文件
1. 所有输入输出文件保存在以题号为名的同一目录下
2. 输入文件的命名为 [文件名].in , 输出文件则为对应的 [文件名].out
3. 使用data.txt保存所有输入文件的文件名, 一行一个, 行末有回车, 不需要扩展名
例: 1001题有输入文件a.in b.in, 对应的输出文件是a.out b.out, 对应的data.txt因该是
a
b

AC/PE/WA的含义
1. AC(Accepted)表示程序的输出与标准输出完全一致。
2. PE(Presentation Error)表示程序的输出在不考虑空白(空格/回车\r\n/Tab)的情况下, 与标准输出完全一致。
3. WA(Wrong Answer)表示程序的输出与标准输出不一致, 且不是PE的情况。

编译器相关
1. 编译时间限制为5s, 如果在5s内没有结束或者编译器非正常结束, 为System Error。
2. 编译器默认使用gcc(c)、g++(c++)、fpc(pascal)、sun-jdk(java)
3. 可能需要将/usr/lib/jvm/java-6-sun/jre/lib/i386/jli/libjli.so链接到/usr/lib

Special Judge相关
1. 如果是SPJ题目，必须在数据目录下有一个[可执行](chmod +x)的spj.exe
2. SPJ程序的执行时间限制是5s
3. Judge会将用户程序的输出文件打开, 作为spj.exe的标准输入数据
4. 如果有提供标准输出文件，则作为命令行参数(argv[1])给出
5. spj.exe退出时的返回值必须是0, 其他值表示spj.exe非正常退出
6. spj.exe将结果以字符串"AC", "PE", "WA"的形式输出到标准输出中

参数传递

    输入参数通过命令行指定, 格式如下
    ./judge -l 语言 -s 源文件   -n 题号     -D 数据目录 
            -d 临时目录 -t 时间限制 -m 内存限制 
            -o 输出限制 [-S]
     -l 语言        C=1, C++=2, JAVA=3, PASCAL=4
     -s 源文件      包含代码, 其中JAVA源文件名必须是Main.java。
     -n 题号        题目的唯一编号, 一个正整数
     -D 数据目录    包含data.txt以及输入输出文件的目录
     -d 临时目录    judge可以用来存放编译后的文件及其他临时文件的
     -t 时间限制    允许程序运行的最长时间, 以毫秒为单位, 默认为1000, 1s
     -m 内存限制    允许程序使用的最大内存量, 以KB为单位, 默认为65536, 64MB
     -o 输出限制    允许程序输出的最大数据量, 以KB为单位, 默认为8192, 8MB
     -S             可选, 如指定此参数, 则表示这是一个Special Judge的题目

    输出参数
    1. 返回值
        返回0表示judge正常执行, 返回非0表示judge本身出错
    2. 标准输出
        输出JUDGE结果的值, 对应judge.h中的OJ_*系列。输出的一定是个正整数。
    3. 文件输出
        如果出现CE, 将编译器的标准错误输出存在stderr_compiler.txt;
        如果出现RE(Java), 将JRE的标准错误输出存在stderr_executive.txt中。 //待定
        *编译器、程序、spj.exe的输出分别是在临时目录下的(-d)
            stdout_compiler.txt, stderr_compiler.txt
            stdout_executive.txt, stderr_executive.txt
            stdout_spj.txt

其他：
    其余judge_c.cpp等文件为单独实现的judge，不再更新，不应使用。
