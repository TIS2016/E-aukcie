import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Properties;

class DBContext {
  
  static Connection c;
  static String url;
  static Properties properties;
  
  public void init(String name, String password) throws SQLException {
	  String url = "jdbc:postgresql://localhost/postgres";
	  Properties properties = new Properties();
	  properties.put("user", name);
	  properties.put("password", password);
	  c = DriverManager.getConnection(url, properties);
  }
  
  public static Connection getConnection() throws SQLException {
    if (c.isValid(10)) {
	  return c;
	} else {
	  c.close();
	  c = DriverManager.getConnection(url, properties);
	  return c;
	}
  	
  }
  
  public static void close() throws SQLException {
  	c.close();
  }
  
  public static ResultSet getLogs() throws SQLException{
	  PreparedStatement s;
      s = DBContext.getConnection().prepareStatement("SELECT * FROM auction_log" );
      ResultSet r = s.executeQuery();
     
		return r;
  }
  
  
  public static ResultSet getLines(int id) throws SQLException{
	  PreparedStatement s;
	  s = DBContext.getConnection().prepareStatement("Select time,fk_action,fk_user,value from auction_log WHERE fk_auction = "+ id +" ORDER BY time");
	  ResultSet r = s.executeQuery();
	  return r;
  }
  
  public static ResultSet getName(int id) throws SQLException{
	  PreparedStatement s;
	  s = DBContext.getConnection().prepareStatement("Select * from auction WHERE id = "+ 2 +"");
	  ResultSet r = s.executeQuery();
	  return r;
  }

}