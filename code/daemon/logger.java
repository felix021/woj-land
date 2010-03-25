import java.io.*;
import java.net.*;
import java.util.*;
import java.text.*;

class logger
{
    private static DateFormat df = new SimpleDateFormat(
                                        "yyyy-MM-dd HH:mm:ss");
    public static String getTimeStr()
    {
        return logger.df.format(new Date());
    }

    public static void log(String l)
    {
        try
        {
            System.out.println("[" + logger.getTimeStr() + "] " + l);
        }
        catch (Exception e)
        {
        }
    }

    public static void debug(String l)
    {
        if (Config.DEBUG == true)
        {
            logger.log("DEBUG " + l);
        }
    }
}
