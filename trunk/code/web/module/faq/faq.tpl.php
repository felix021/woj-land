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
    <div class="ptt">Q: What does my program input from and output to?</div> 
    <div class="ptx">A: Your program shall always input from stdin (Standard 
    Input) and output to stdout (Standard Output). For example, you use scanf 
    in C or cin in C++ to read from stdin, and printf in C or cout in C++ to 
    write to stdout.<br /><br /> 
    User programs are not allowed to open and read from/write to files. You 
    will probably get a <span class=styRed>Runtime Error</span> or 
    <span class=styRed>Wrong Answer</span> if you try to do so.<br /><br /> 
    Input/Output of scanf/printf is faster than cin/cout, so if a problem has 
    huge input data, use cin will probably get a <span class=styRed>Time Limit 
    Exceeded</span>.<br /><br /> 
    Here is a sample solution to problem 1001 using G++:<br /> 
    <div class=styCode><pre>#include &lt;iostream&gt;
 
using namespace std;
 
int main()
{
    int a, b;
    cin &gt;&gt; a &gt;&gt;  b;
    cout &lt;&lt; a + b &lt;&lt;  endl;
    return 0;
}</pre></div> 
    Please note that the return type of main() must be 
    <span class=styRed>int</span> when you use G++/GCC, or else you may get 
    <span class=styRed>Compile Error</span>.
    Here is a sample solution to problem 1001 using GCC:<br /> 
    <div class=styCode><pre>#include  &lt;stdio.h&gt;
 
int main()
{
    int a, b;
    scanf("%d %d", &a, &b);
    printf("%d\n", a + b);
    return 0;
}</pre></div> 
    Here is a sample solution to problem 1001 using PASCAL:<br /> 
    <div class=styCode><pre>PROGRAM p1001(Input, Output); 
 
VAR
    a, b:Integer; 
BEGIN
    Readln(a, b); 
    Writeln(a + b); 
END.</pre></div> 
    Here is a sample solution to problem 1001 using JAVA:<br /> 
    <div class=styCode><pre>//The Java compiler is jdk 1.5 recently, below is a program for problem 1001
 
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
    <div class="ptt">Q: How to use long long or __int64?</div> 
    <div class="ptx"> 
    A: If you use long long in your GCC/G++ program, make sure you use %lld 
    when read or write long long value. As __int64 is for MS-VC++, it is not 
    supported in this System.
    </div> 
    <div class="ptt">Q: How to copy my codes out of this Judge?</div> 
    <div class="ptx"> 
    A: As some JudgeOnline System, the codes of all users' submissions are 
    saved and others can see it. We allowed <span class="styRed">all users</span> 
    who passed a problem to see the codes of all submissions of this problem, 
    and copy codes from the submissions status is not allowed.
    </div> 
    <div class="ptt">Q: How to submit Java programs?</div> 
    <div class="ptx"> 
    A: Java programs submitted must be in a single source code (not .class) 
    file. They must also read from standard input and write to standard output, 
    as in the other lang uages.<br /><br /> 
    All programs must begin in a static method named 
    <span class="styRed">main</span> in a class named 
    <span class="styRed">Main</span>. However, you can implement and instance 
    as many classes as needed.
    </div> 
    <div class="ptt">Q: What are the meanings of the judge's replies?</div> 
    <div class="ptx">A: Here is a list of the judge's replies and their 
    meanings:<br /> <br/>
    <span class="styRed"><a name="WAIT"></a>Queuing</span>: The judge is so busy that it can't 
    judge your submission or your submission is running at the moment. Usually 
    you just need to wait several seconds and your submission will be judged.
    <br /> <br /> 
    <span class="styRed"><a name="AC"></a>Accepted</span> (AC): Congratulations! Your program is 
    correct!
    <br /> <br /> 
    <span class="styRed"><a name="PE"></a>Presentation Error</span> (PE): Your output format is 
		not exactly the same as the judge's output, although your answer to the 
		problem is correct. Check your output for spaces, blank lines, etc. 
		against the problem output specification.
    <br /> <br /> 
    <span class="styRed"><a name="WA"></a>Wrong Answer</span> (WA): Expected output not reached 
		for the input. The input and output data that we use to test the programs 
		are not public (it is recommendable to get accustomed to a true contest 
		dynamic ;-). For some problem <span class="styRed">Presentation Error</span> 
		is considented as <span class="styRed">Wrong Answer</span> if the problem 
		is just test your presentation.
    <br /> <br /> 
    <span class="styRed"><a name="RE"></a>Runtime Error</span> (RE): Your program failed during 
		the execution (illegal file access, stack overflow, pointer reference out 
		of range, floating point exception, division by zero...).<br /> 
    &nbsp; &nbsp;The following messages may also be shown to you. Here we just provide some tips:<br /> 
    &nbsp; &nbsp; &nbsp; <a name="RE_SEGV"></a>SIGSEGV --- Segment Fault. The possible 
    cases of your encountering this error are:<br /> 
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1.buffer overflow --- 
    usually caused by a pointer reference out of range.<br /> 
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2.stack overflow  --- 
    please keep in mind that the default stack size is 8192K(Notice: In GCC a 
    little overflow will not get a Runtime Error).<br /> 
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3.illegal file access 
    --- file operations are forbidden on our judge system.<br /> 
    &nbsp; &nbsp; &nbsp; <a name="RE_FPE"></a>SIGFPE  --- Divided by 0<br /> 
    &nbsp; &nbsp; &nbsp; <a name="RE_BUS"></a>SIGBUS  --- Hardware Error. //please 
    contact us<br /> 
    &nbsp; &nbsp; &nbsp; <a name="RE_ABRT"></a>SIGABRT --- Programme aborted before it 
    should be finished.<br /> 
    &nbsp; &nbsp;man 7 signal under Linux for more information<br /> 
    And, <span class="styRed"><a name="RE_JAVA"></a>Runtime Error(JAVA)</span> means that your java program failed during run time.
    <br /> <br /> 
    <span class="styRed"><a name="RF"></a>Restricted Function</span>: means that your program tried to do something forbidden, such as file or network access. Occationally, when Runtime Error occurs, glibc will write debug infomation to /dev/tty(or open /proc/self/maps or other files) which will be also judged as Restricted Function.
    <br /> <br /> 
    <span class="styRed"><a name="TLE"></a>Time Limit Exceeded</span> (TLE): Your program tried 
    to run for too much time.
    <br /> <br /> 
    <span class="styRed"><a name="MLE"></a>Memory Limit Exceeded</span> (MLE): Your program tried 
    to use more memory than the judge default settings.
    <br /> <br /> 
    <span class="styRed"><a name="OLE"></a>Output Limit Exceeded</span> (OLE): Your program tried 
    to output too much. This usually occurs when your program goes into an 
    infinite loop. Currently the output limit is twice the standard output 
    file's size.
    <br /> <br /> 
    <span class="styRed"><a name="CE"></a>Compile Error</span> (CE): The compiler could not 
    compile your program. Warning messages are not considered errors. Click on the link
    (<span class="styRed">Compile Error</span>) at the judge's reply to see the actual error messages.
    <br /> <br /> 
    <span class="styRed"><a name="SE"></a>System Error</span>: Errors occur due to the system's bugs. We'll appreciate if you report such issue to us.
    </div>
    <div class="ptt">Q: How should I determine the end of input?</div> 
    <div class="ptx"> 
    A: In most cases there is some information in the input that explicitly 
    indicates the end of input, for example, number of test cases or a single 
    line with a zero following that last test case. But in some cases you have 
    to determine the end of file (EOF) for the end of input. In such cases, you 
    may test for the return value of scanf (which indicates how many values 
    have been successfully read in) or things like cin. Refer to the hints for 
    problem 1001 for a working example.
    </div> 
    <div class="ptt">Q: The time limit is 1000MS. But some guys' programs ran 
    for several seconds to get AC!</div> 
    <div class="ptx"> 
    A: Please be mercy with those who use Java. As is known to all Java 
    programs run much slower than those written in C/C++. Therefore the time 
    limits for Java programs are longer(exactly <span class=styRed>two 
    times</span> as much as C/C++). But TLE is still possible for unacceptably 
    slow programs. If such programs are not Java programs, please let us know.
    </div> 
    <div class="ptt">Q: My program exceeds the time limit by just 0MS. How can 
    I improve it?</div> 
    <div class="ptx"> 
    A: In most cases your program actually requires much more time than the 
    time limit. The judge kills the process instantiating your program once it 
    finds the time limits is exceeded. Usually this occurs at 314MS later than 
    the time limit. If you believe your program really runs for only a little 
    bit longer than the time limit, please submit it a few more times. Possibly 
    error in timing may earn you an AC. And again, AC with efficient code is 
    recommended.
    </div> 
    <div class="ptt">Q: I have more questions.</div> 
    <div class="ptx"> 
    A: Please make full use of our forum. Post your questions in a nice way. 
    The administrators and other users will try to help you.
    </div> 
  </div> 
 
eot;
        return true;
    }
}

?>
