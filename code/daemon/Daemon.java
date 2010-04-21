import java.io.*;
import java.net.*;
import java.util.*;
import java.text.*;
import java.util.regex.MatchResult;
import java.util.regex.Pattern;

class Config
{
    //监听的端口
    public static int LISTEN_PORT     = 9527;

    //用于启动judge线程的数量
    public static int MAX_THREADS     = 4;

    //Daemon轮询时间间隔
    public static int QUERY_INTERVAL  = 1000; //ms

    //调试模式
    public static boolean DEBUG       = true;

    //Log文件路径
    public static String LOG_PATH     = "";

    //judge_wrapper路径
    public static String JUDGE_PATH   = "";

    public static void load()
    {
        try {
            Scanner sin = new Scanner(new File("config.ini"));
            Pattern pat;
            String key, value, line;
            pat = Pattern.compile("(.*?)=(.*)");
            while (sin.hasNextLine())
            {
                line = sin.nextLine();
                if (line.indexOf('=') >= 0)
                {
                    Scanner in = new Scanner(line);
                    in.findInLine(pat);
                    MatchResult mat = in.match();
                    if (mat.groupCount() == 2)
                    {
                        key     = mat.group(1);
                        value   = mat.group(2);
                        if (key.equals("PORT"))
                        {
                            Config.LISTEN_PORT = Integer.parseInt(value);
                        }
                        else if (key.equals("DEBUG"))
                        {
                            if (value.equals("TRUE"))
                            {
                                Config.DEBUG = true;
                            }
                            else 
                                Config.DEBUG = false;
                        }
                        else if (key.equals("MAX_THREADS"))
                        {
                            Config.MAX_THREADS = Integer.parseInt(value);
                        }
                        else if (key.equals("QUERY_INTERVAL"))
                        {
                            Config.QUERY_INTERVAL = Integer.parseInt(value);
                        }
                        else if (key.equals("LOG_PATH"))
                        {
                            Config.LOG_PATH = value;
                        }
                        else if (key.equals("JUDGE_PATH"))
                        {
                            Config.JUDGE_PATH = value;
                        }
                        else
                        {
                            logger.log("Unknown Config");
                        }
                    }
                }
            }
        }
        catch(Exception e)
        {
            logger.log("Config load failed: " + e);
            System.exit(1);
        }
    }
}

public class Daemon extends Thread
{
    public static void main(String args[])
    {
        logger.log("Daemon starts");

        Config.load();

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

