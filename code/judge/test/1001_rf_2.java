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
