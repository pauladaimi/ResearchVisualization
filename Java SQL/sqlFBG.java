import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Scanner;

public class sqlFBG {
	private int port = 9999; //Change to the port that you need
    private ServerSocket serverSocket;
    private Connection myConnection;
	
    
    public sqlFBG() throws ClassNotFoundException {}
    
	 public void startSQL(){
	    	try {
	    		// change "research" to your DB name, "root" to your username, "paul" to your password.
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
        sqlFBG server = null;
        try {
            server = new sqlFBG();
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
            			sqlFBG(s.nextInt(),s.nextInt(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble(),s.nextDouble());
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
        
        
        public void sqlFBG(int sensorID, int structureID,double time, double lattitude, double longitude, double altitude, double strain){
        	try{
				Statement stmt2 = myConnection.createStatement();
				//Change toyfbgdata to your tableName
				System.out.println("insert into toyfbgdata values ('"+sensorID+ "', '" + structureID+"', '"+time+"', '"+ lattitude+"', '"+ longitude+"', '"+ altitude+"', '"+strain+"');");
				stmt2.executeUpdate("insert into toyfbgdata values ('"+sensorID+ "', '" + structureID+"', '"+time+"', '"+ lattitude+"', '"+ longitude+"', '"+ altitude+"', '"+strain+"');");
			}
        	
			catch(Exception e){
				System.out.println(e);
			}
        }
    }
}
