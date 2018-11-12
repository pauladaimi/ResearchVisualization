import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.sql.*;
import java.util.Scanner;

public class sqlServer{
	private int port = 9999;
    private ServerSocket serverSocket;
    private Connection myConnection;
	
    
    public sqlServer() throws ClassNotFoundException {}
    
	 public void startSQL(){
	    	try {
				myConnection = DriverManager.getConnection("jdbc:mysql://localhost:3306/research" , "root" , "paul");
			}catch (SQLException e1) {
				e1.printStackTrace();
				}
	 }
	 
	 public void acceptConnections() {
		 startSQL();
	        try
	        {
	            serverSocket = new ServerSocket(port);
	        }
	        catch (IOException e)
	        {
	            System.err.println("ServerSocket instantiation failure");
	            e.printStackTrace();
	            System.exit(0);
	        }

	        while (true) {
	            try
	            {
	                Socket newConnection = serverSocket.accept();
	                System.out.println("accepted connection");
					//now each client gets a threads that deals with its connection and requests //
	                ServerThread st = new ServerThread(newConnection);
	                new Thread(st).start();
					//now the server will continue waiting for other requests and the current user will be serviced
					// by the created thread //
	            } 
	            catch (IOException ioe)
	            {
	                System.err.println("server accept failed");
	            }
	        }
	    }
	 
	public static void main(String[] args) {
        sqlServer server = null;
        try {
            server = new sqlServer();
        } catch (ClassNotFoundException e) {
            //   System.out.println("unable to load JDBC driver");
            e.printStackTrace();
            System.exit(1);
        }

        server.acceptConnections();
	}

	
	//Creates a new Thread
    class ServerThread implements Runnable {
        private Socket socket;
        private BufferedReader datain;
        private PrintWriter dataout;

        public ServerThread(Socket socket) {
            this.socket = socket;
        }
        
        //Server Program
        public void run()
        {
            try
            {
                datain =  new BufferedReader(new InputStreamReader(socket.getInputStream()));
                dataout = new PrintWriter(socket.getOutputStream(), true);
                
            } 
            catch (IOException e)
            {
                return;
            }
            
            try 
            {
            	String userInput;
            	while((userInput=datain.readLine())!=null){
            		String newForm = userInput.replaceAll(",", " ");
            		Scanner s = new Scanner(newForm);
            		while(s.hasNext()){
            			sqlArduino(s.nextInt(),s.nextDouble(),s.nextInt(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble());
            		}
            		
            	}
            }catch (IOException k)
            {
                System.out.println(k);
            }
            try
            {
                System.out.println("closing socket");
                datain.close();
                dataout.close();
                socket.close();
            } 
            catch (IOException e)
            {
            }
        }
        
        
        public void sqlArduino(int ID, double Time,int Satellites, double Lattitude, double Longitude, double Altitude, double AX, double AY, double AZ, double GX, double GY, double GZ, double MX, double MY, double MZ, double Temperature, double Pressure){
        	try{
				Statement stmt2 = myConnection.createStatement();
				System.out.println("insert into measures values ('"+ID+ "', '" + Time+"', '"+Satellites+"', '"+ Lattitude+"', '"+ Longitude+"', '"+ Altitude+"', '"+ AX+"', '"+ AY+"', '"+ AZ+"', '"+ GX+"', '"+ GY+"', '"+ GZ+"', '"+ MX+"', '"+ MY+"', '" + MZ+"',  '"+ Temperature+"', '"+Pressure+"');");
				stmt2.executeUpdate("insert into measures values ('"+ID+ "', '" + Time+"', '"+Satellites+"', '"+ Lattitude+"', '"+ Longitude+"', '"+ Altitude+"', '"+ AX+"', '"+ AY+"', '"+ AZ+"', '"+ GX+"', '"+ GY+"', '"+ GZ+"', '"+ MX+"', '"+ MY+"', '" + MZ+"',  '"+ Temperature+"', '"+Pressure+"');");
			}
        	
			catch(Exception e){
				System.out.println(e);
			}
        }
    }
}
