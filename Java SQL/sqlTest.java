import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;

public class sqlTest {

	public static void main(String args[])
	{
	try
	{
	/*Class.forName("com.mysql.jdbc.Driver");
	Connection conn = null;
	conn = DriverManager.getConnection("jdbc:mysql:3306//localhost/test","root", "paul");
	System.out.print("Database is connected !");
	Statement stmt = conn.createStatement();
	stmt.executeUpdate("insert into person values('danny',85)");
	conn.close();*/
		System.out.println("test \ntest");
	}
	catch(Exception e)
	{
	System.out.print("Do not connect to DB - Error:"+e);
	}
	}

}
