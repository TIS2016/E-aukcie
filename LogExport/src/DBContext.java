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
  
  
  public static ResultSet getLines(int id,String time) throws SQLException{
	  PreparedStatement s;
	  s = DBContext.getConnection().prepareStatement("Select time,fk_action,fk_user,value from auction_log WHERE fk_auction = "+ id +" and time >= '"+ time +"' ORDER BY time");
	  System.out.println("Select time,fk_action,fk_user,value from auction_log WHERE fk_auction = "+ id +" and time >= "+ time +" ORDER BY time");
	  ResultSet r = s.executeQuery();
	  return r;
  }
  
  public static ResultSet getName(int id) throws SQLException{
	  PreparedStatement s;
	  s = DBContext.getConnection().prepareStatement("Select * from auction WHERE id = "+ 2 +"");
	  ResultSet r = s.executeQuery();
	  return r;
  }
  
  public static ResultSet getSvkNames() throws SQLException{
	  PreparedStatement s;
	  s = DBContext.getConnection().prepareStatement("Select * from c_action");
	  ResultSet r = s.executeQuery();
	  return r;
  }
  
  public static ResultSet getAuctions(String startEnd) throws SQLException{
	  PreparedStatement s;
      if (startEnd.equals("start")){
          s = DBContext.getConnection().prepareStatement("select distinct on (fk_user) * from auction_log where fk_action = 'setCriterionsForUser' and fk_user != 'admin' order by fk_user, time asc" );
      }
      else{
          s = DBContext.getConnection().prepareStatement("select distinct on (fk_user) * from auction_log where fk_action = 'setCriterionsForUser' and fk_user != 'admin' order by fk_user, time desc" );
      }

      ResultSet r = s.executeQuery();
      return r;
  }
    public static ResultSet getZaruka(String user) throws SQLException{
        PreparedStatement s;
        s = DBContext.getConnection().prepareStatement("select numeric_value from auction_user_criterion where fk_user = '" + user + "' and id_in_auction = 2");
        ResultSet r = s.executeQuery();
        return r;
    }

    public static ResultSet getFirma(String user) throws SQLException{
        PreparedStatement s;
        s = DBContext.getConnection().prepareStatement("Select * from users as u join client as c on fk_client=id where login = '"+ user + "'");
        ResultSet r = s.executeQuery();
        return r;
    }

    public static ResultSet getAuctionName(String id) throws SQLException{
        PreparedStatement s;
        s = DBContext.getConnection().prepareStatement("select name from auction where id='"+ id + "'");
        ResultSet r = s.executeQuery();
        return r;
    }

    public static ResultSet getProjectClient(String id) throws SQLException{
        PreparedStatement s;
        s = DBContext.getConnection().prepareStatement("select * from client as c join project as p on p.fk_client=c.id where p.id ='"+ id + "'");
        ResultSet r = s.executeQuery();
        return r;
    }

    public static ResultSet getCurrency(String id) throws SQLException{
        PreparedStatement s;
        s = DBContext.getConnection().prepareStatement("select c.description as curr from auction as a join c_currency as c on a.fk_currency=c.id where a.id='"+ id + "'");
        ResultSet r = s.executeQuery();
        return r;
    }


}