import java.io.*;
import java.net.*;
import java.util.*;
import java.text.*;

class Config
{
    //监听的端口
    public static final int LISTEN_PORT     = 9527;

    //用于启动judge线程的数量
    public static final int MAX_THREADS     = 4;

    //Daemon轮询时间间隔
    public static final int QUERY_INTERVAL  = 1000; //ms

    //调试模式
    public static final boolean DEBUG       = true;

    //Log文件路径
    public static final String LOG_PATH     = "/home/felix021/woj/log/daemon.log";

    //judge_wrapper路径
    public static final String JUDGE_PATH   = "/home/felix021/svn/woj-land/code/web/wrapper/judge_wrapper.php";
}

public class Daemon extends Thread
{
    public static void main(String args[])
    {
        logger.log("Daemon starts");

        //初始化多个Request线程, 等待请求以启动judge
        Request.init(Config.MAX_THREADS, Config.JUDGE_PATH);

        //为了保险, 增加一个Processor线程用于轮询, 
        //如果队列中存在未处理的src_id则唤醒线程去处理
        Daemon d = new Daemon();
        //d.start();

        try
        {
            //监听端口
            ServerSocket server = new ServerSocket(Config.LISTEN_PORT);
            if (!server.isBound())
            {
                throw new Exception("server not bound");
            }
            logger.log("Listening " + Config.LISTEN_PORT);
            while (true)
            {
                Socket conn = server.accept();
                //Processor用于从连接读取src_id并插入队列
                Processor p = new Processor(conn);
                p.start();
            }
        }
        catch(Exception e)
        {
            logger.log("WARNING: Exception " + e);
            System.exit(1);
        }
    }

    public void run()
    {
        logger.log("Daemon is watching requests");
        //轮询
        while (true)
        {
            try
            {
                Request.work(Request.NOTIFY_THREAD, 0);
                Thread.sleep(Config.QUERY_INTERVAL);
            }
            catch(Exception e)
            {
            }
        }
    }
}

