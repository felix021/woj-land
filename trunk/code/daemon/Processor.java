import java.io.*;
import java.net.*;
import java.util.*;
import java.text.*;

class Processor extends Thread
{
    private Socket conn = null;
    private Scanner in = null;
    private OutputStreamWriter os = null;
    private int source_id = -1;

    public Processor(Socket _conn)
    {
        conn = _conn;
    }

    public void run()
    {
        try
        {
            InetAddress addr = conn.getInetAddress();
            //TODO add a list of permitted address
            logger.log("new conn from: " + addr);
            os = new OutputStreamWriter(conn.getOutputStream());
            if (!addr.toString().trim().equals("/127.0.0.1"))
            {
                //logger.log("WARNING: Unauthorized address");
                throw new Exception("Unauthorized address");
            }
            in = new Scanner(conn.getInputStream());
            if (!in.hasNextInt())
            {
                String t = in.next();
                throw new Exception("Unknown input '" + t + "'");
            }

            source_id = in.nextInt();
            if (source_id <= 0)
            {
                throw new Exception("bad source_id: " + Integer.toString(source_id));
            }

            os.write(Integer.toString(source_id));
        }
        catch(IOException ioe)
        {
            logger.log("WARNING: IOException " + ioe);
        }
        catch(Exception e)
        {
            try
            {
                os.write("What are you doing...?\n");
            }
            catch(IOException ioe){}
            logger.log("WARNING: Exception " + e);
        }

        try
        {
            os.close();
            conn.close();
        }
        catch(Exception ioe){}

        if (source_id > 0)
        {
            logger.log("Source id: " + Integer.toString(source_id));
            Request.work(Request.ADD_SOURCE_ID, source_id);
        }
    }
}

