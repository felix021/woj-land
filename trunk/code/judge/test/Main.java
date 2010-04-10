/*
import java.net.*;

public class Main {
	public static void main(String[] args) {
		try {
			InetAddress address = InetAddress.getByName("www.sun.com");
			System.out.println(address);
		} catch (UnknownHostException e) {
			e.printStackTrace();
		}
	}
}

*/

import java.io.*;
import java.util.*;
public class Main
{
    public static void main(String args[]) throws Exception
    {
        Scanner cin=new Scanner(System.in);
        int a = cin.nextInt();
        int b = cin.nextInt();
        System.out.println(a + b);
    }
}

