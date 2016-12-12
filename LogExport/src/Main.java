import java.sql.SQLException;

public class Main {
	
	
	public static void main(String[] args) throws SQLException {
		// TODO Auto-generated method stub
		LogLines lines = new LogLines();
		// trosku som to zmenil premene ako id a cas sa volaju ako argumenty funcii , takto je to lepsie
		lines.readLines(2, "2016-09-12 15:00:00");
		lines.generateEXCel(2); 

		
	}
	
	
	
	 

}
