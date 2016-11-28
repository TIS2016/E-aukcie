import java.sql.SQLException;

public class Main {
	
	
	public static void main(String[] args) throws SQLException {
		// TODO Auto-generated method stub
		LogLines lines = new LogLines();
		lines.id = 2;
		lines.readLines();
		lines.generateEXCel();
		
	}
	
	
	
	 

}
