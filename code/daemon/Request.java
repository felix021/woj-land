import java.io.*;
import java.net.*;
import java.util.*;
import java.text.*;

//Request类维护一个队列用于存储提交的src_id
//每个Request对象是一个线程, 用于调用judge_wrapper
//在有未处理的src_id时, 空闲的Request线程会被唤醒

class Request extends Thread
{
    //用于work函数, 分别实现增加、提取src_id, 以及唤醒空闲线程
    public static final int ADD_SOURCE_ID   = 1;
    public static final int GET_SOURCE_ID   = 2;
    public static final int NOTIFY_THREAD   = 3;

    //等待judge的src_id队列, 该队列的读写必须通过work函数
    private static Queue<Integer> src_ids   = new LinkedList<Integer>();

    //Daemon启动时初始化的Request线程池
    private static Request[] objs           = null;
    //线程池同步用的锁对象
    private static byte[] obj_lock          = new byte[0];

    //judge_wrapper的路径
    private static String judge             = null;

    //初始化, 需提供线程池的大小(>0), 以及judge_wrapper的路径
    public static void init(int n_threads, String judge_path)
    {
        judge = judge_path;

        if (n_threads <= 0)
        {
            return;
        }

        objs = new Request[n_threads];
        for (int i = 0; i < n_threads; i++)
        {
            //初始化每一个线程
            objs[i]         = new Request(i);
            objs[i].start();
        }
    }

    synchronized  //同步成员函数
    public static int work(int action, int src_id)
    {
        switch(action)
        {
            //增加src_id
            case ADD_SOURCE_ID:
                if (false == src_ids.offer(src_id))
                {
                    return 0;
                }
                //新增加的src_id未被处理,因此不break, 继续执行NOTIFY_THREAD

            //如果有未judge的src_id, 则唤醒一个在等待的线程
            case NOTIFY_THREAD:
                if (null != src_ids.peek())
                {
                    synchronized(obj_lock)
                    {
                        //唤醒
                        obj_lock.notify();
                    }
                }
                return 1;

            //从队列中获取一个src_id
            case GET_SOURCE_ID:
                return src_ids.peek() != null ? src_ids.poll() : 0;

            default:
                return 0;
        }
    }


    //线程编号
    private int req_id = -1;

    public Request(int i)
    {
        req_id = i;
        logger.log("thread " + Integer.toString(i) + " starts");
    }

    public void run()
    {
        while(true)
        {
            try
            {
                synchronized(Request.obj_lock)
                {
                    //等待, 直到有需要judge的src_id
                    obj_lock.wait();
                }

                //获取src_id
                int src_id = Request.work(GET_SOURCE_ID, 0);

                logger.log("req_id: " + Integer.toString(req_id) + ", "
                         + "src_id: " + Integer.toString(src_id));

                //准备运行参数
                String t        = Integer.toString(src_id);
                String[] cmd    = {Request.judge, t};

                //运行judge并等待其结束
                Process p = null;
                int retry = 3; //重试3次
                for ( ; retry > 0; retry--)
                {
                    try
                    {
                        p = Runtime.getRuntime().exec(cmd);
                        break;
                    }
                    catch(Exception e)
                    {
                        if (retry == 0)
                        {
                            throw e; //重试3次仍无法启动, 放弃
                        }
                        logger.log("WARNING: exec failed " + e + ", retrying...");
                    }
                    sleep(500); //每次重试前等待500ms
                }
                p.waitFor(); //等待其结束

            }
            catch(Exception e)
            {
                logger.log("WARNING: Exception " + e);
                try
                {
                    Thread.sleep(1000);
                }
                catch(Exception e1){}
            }
            finally
            {
                //如果还有未judge的src_id, 再唤醒一个在等待的线程
                Request.work(NOTIFY_THREAD, 0);
            }
        }
    }

}

