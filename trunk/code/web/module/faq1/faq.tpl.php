<?php

class TPL_Main extends ctemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        echo <<<eot
  <div id="tt"> 
    Frequently Asked Questions
  </div> 

  <style type="text/css"> 
    <!--
    .styRed{color:#d00}
    .styCode{padding:0px 5px 0px 5px;margin:10px 30px 10px 10px;
    background-color:#f7ffd7;border:1px solid #aac747;
    color:#070;font-family:Courier New;font-size:14px}
    -->
  </style> 
 
  <div id="main"> 
    <div class="ptt">Q: 程序的输入和输出来自何处?</div> 
    <div class="ptx">A: 你得程序应当总是从stdin进行输入，并输出到stdout，不需要使用文件。例如，你可以在C里面用scanf或者在C++里面使用cin读取数据；在C里面使用printf或者在C++里面使用printf进行输出。<br /><br /> 
    <b>对于初学者，请不要“告诉”OJ多余的信息（比如 printf("Enter a number: ");），这些多余的输出会作为你的答案的一部分，毫无疑问，OJ会认为你的答案是错误的。</b><br/><br/>
    用户程序不允许操作文件（例如fopen等函数），否则你可能会得到<span class=styRed>Runtime Error</span>(运行时错误)、<span class=styRed>Restricted Functions</span>(限制使用的函数)或者<span class=styRed>Wrong Answer</span>(错误答案)等结果。<br /><br /> 
    注意，使用scanf/printf通常比cin/cout更快，所以如果某个程序的输入/输出量很大，使用cin/cout可能会得到一个<span class=styRed>Time Limit Exceeded</span><br /><br /> 
    下面是一个Problem 1001的示例代码(C++):<br/>
    <div class=styCode><pre>#include &lt;iostream&gt;
 
using namespace std;
 
int main()
{
    int a, b;
    cin &gt;&gt; a &gt;&gt;  b;
    cout &lt;&lt; a + b &lt;&lt;  endl;
    return 0;
}</pre></div> 
    特别注意，C/C++源码的main函数的返回值必须是int，在程序正常结束的情况下应当返回0，否则可能会得到 <span class=styRed>Compile Error</span> .<br/><br/>
    下面是一个Problem 1001的示例代码(C):<br/>
    <div class=styCode><pre>#include  &lt;stdio.h&gt;
 
int main()
{
    int a, b;
    scanf("%d %d", &a, &b);
    printf("%d\n", a + b);
    return 0;
}</pre></div> 
    下面是一个Problem 1001的示例代码(Pascal):<br/>
    <div class=styCode><pre>PROGRAM p1001(Input, Output); 
 
VAR
    a, b:Integer; 
BEGIN
    Readln(a, b); 
    Writeln(a + b); 
END.</pre></div> 
    下面是一个Problem 1001的示例代码(Java):<br/>
    <div class=styCode><pre>//The Java compiler is jdk 1.5+, below is a program for problem 1001
 
import java.io.*;
import java.util.*;
public class Main
{
    public static void main(String args[]) throws Exception
    {
        Scanner cin=new Scanner(System.in);
        int a = cin.nextInt(), b = cin.nextInt();
        System.out.println(a + b);
    }
}</pre></div> 
    <div class=styCode><pre>//Old program for jdk 1.4
 
import java.io.*;
import java.util.*;
 
public class Main
{
    public static void main (String args[]) throws Exception
    {
        BufferedReader stdin = 
            new BufferedReader(
                new InputStreamReader(System.in));
 
        String line = stdin.readLine();
        StringTokenizer st = new StringTokenizer(line);
        int a = Integer.parseInt(st.nextToken());
        int b = Integer.parseInt(st.nextToken());
        System.out.println(a + b);
    }
}</pre></div> 
    </div> 
    <div class="ptt">Q: 如何使用 long long 或是 __int64 ?</div> 
    <div class="ptx"> 
    A: 如果你在C/C++代码中使用 long long , 确认你使用%lld来进行格式化输入输出(scanf/printf). __int64是微软VC++中使用的，本系统并不支持。
    </div> 
    <div class="ptt">Q: 提交Java代码时有什么需要特别注意的?</div> 
    <div class="ptx"> 
    A: 提交的Java程序应当是一个源码而不是class文件；输入输出也应当从stdin/stdout获得。<br/><br/>
    所有程序应当从一个class Main的main方法开始，但是不限制使用其他的类和实例。
    </div> 
    <div class="ptt">Q: Status里面的各个状态是什么意思?</div> 
    <div class="ptx">A: 各状态含义如下: <br /> <br/>
    <span class="styRed"><a name="WAIT"></a>Queuing</span>: 等待评判.  <br /> <br /> 
    <span class="styRed"><a name="AC"></a>Accepted</span> (AC): 恭喜，程序完全符合要求！ <br /> <br /> 
    <span class="styRed"><a name="PE"></a>Presentation Error</span> (PE): 程序总体正确，但是输出格式不符合要求！注意程序中的空格、空行。 <br /> <br /> 
    <span class="styRed"><a name="WA"></a>Wrong Answer</span> (WA): 输出的答案错了。偶尔，<span class="styRed">Presentation Error</span> 也会被归类到这个情况，这取决于你的输出。<br /> <br /> 
    <span class="styRed"><a name="RE"></a>Runtime Error</span> (RE): 程序在运行的过程中出错了，也许是栈溢出、非法指针访问、浮点错误、整数除0。。。<br /> 
    &nbsp; &nbsp;通常会包含一些额外的信息如下:<br /> 
    &nbsp; &nbsp; &nbsp; <a name="RE_SEGV"></a>SIGSEGV --- 段错误，通常是栈溢出、非法指针访问（如越界）。<br /> 
    &nbsp; &nbsp; &nbsp; <a name="RE_FPE"></a>SIGFPE  --- 除0错误<br /> 
    &nbsp; &nbsp; &nbsp; <a name="RE_BUS"></a>SIGBUS  --- 硬件错误. 联系我们吧.<br /> 
    And, <span class="styRed"><a name="RE_JAVA"></a>Runtime Error(JAVA)</span> 表示你的Java程序在运行时出错了。
    <br /> <br /> 
    <span class="styRed"><a name="RF"></a>Restricted Function</span>: 这意味着你的程序使用了不被允许的程序，比如文件操作、访问网络等。记住一个原则，对做题没有意义的函数都是被禁用的，这是考虑到服务器的安全因素。 Occationally, when Runtime Error occurs, glibc will write debug infomation to /dev/tty(or open /proc/self/maps or other files) which will be also judged as Restricted Function.
    <br /> <br /> 
    <span class="styRed"><a name="TLE"></a>Time Limit Exceeded</span> (TLE): 程序运行时间超过预期。
    <br /> <br /> 
    <span class="styRed"><a name="MLE"></a>Memory Limit Exceeded</span> (MLE): 程序使用的内存超过预期。
    <br /> <br /> 
    <span class="styRed"><a name="OLE"></a>Output Limit Exceeded</span> (OLE): 程序输出的内容过多，超出预期。
    <br /> <br /> 
    <span class="styRed"><a name="CE"></a>Compile Error</span> (CE): 编译出错. 点击该链接(<span class="styRed">Compile Error</span>)以查看详细的编译错误.
    <br /> <br /> 
    <span class="styRed"><a name="SE"></a>System Error</span>: 未知系统错误，请反馈给我们，谢谢。    </div>
    <div class="ptt">Q: 如何判断输入的结束?</div> 
    <div class="ptx"> 
    A: 大多数情况下，题目描述的输入数据有给出明确的结束标志，按照要求编写代码即可；但是有些情况要求你一直读入到输入结束并被关闭，你需要在输入时判断。例如，使用scanf/cin/getchar等函数的返回值是否等于EOF来判断，或者feof(stdin)都可以。详情请参照Problem 1001后面的样例。
    </div> 
    <div class="ptt">Q: 有些人的代码运行超过了题目限制的时间，却得到了AC！</div>
    <div class="ptx"> 
    A: Java代码效率略低，所以我们给了2倍的时间，但是如果没有使用正确的算法，仍然会得到TLE。如果非Java程序使用了超过题目限制的时间却AC了，请反馈给我们，谢谢。</div> 
    <div class="ptt">Q: 我的程序貌似只超出了时限一点点，怎么改进?</div> 
    <div class="ptx"> 
    A: 大多数情况下其实你的代码超时了很多，只是系统在时限之后就把它掐掉了。
    </div> 
    <div class="ptt">Q: 我还有其他问题...</div> 
    <div class="ptx"> 
    请到珞珈山水BBS的ACM_ICPC版面提问，会有whuacm的同学答复你的 :)
    </div> 
  </div> 
 
eot;
        return true;
    }
}

?>
