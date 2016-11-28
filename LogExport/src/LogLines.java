import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import  java.io.*;
import  org.apache.poi.hssf.usermodel.HSSFSheet;
import  org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.hssf.util.CellRangeAddress;
import org.apache.poi.hssf.util.HSSFColor;
import  org.apache.poi.hssf.usermodel.HSSFRow;

import org.apache.poi.hssf.usermodel.HSSFCellStyle;
import org.apache.poi.hssf.usermodel.HSSFFont;

@SuppressWarnings("deprecation")
public class LogLines {
	static DBContext connect;
	ArrayList<AuctionLine> lines = new ArrayList<>();
	int id;
	
	public void readLines() throws SQLException{
		connect = new DBContext();
		connect.init("postgres", "tistis");
		ResultSet r = DBContext.getLines(id);
		 while (r.next()) {
			 
	          String source = r.getString("value");
	          String action = r.getString("fk_action");
	          String t = r.getString("time");
	          String user = r.getString("fk_user");
	          
	          Object a = new Jackson2Example(action,source).getValue();
	          
	          AuctionLine line = new AuctionLine(t,action,user, a);
	          lines.add(line);
	          
	      }
	      r.close(); 
	}
	
	public void generateEXCel(){
		try {

            ResultSet r = DBContext.getName(id);
            r.next();
            String name = r.getString("name");
            
            
            String filename = "E:/"+"Log elektronickej aukcie pre stavbu " +name+".xls" ;
            HSSFWorkbook workbook = new HSSFWorkbook();
            HSSFSheet sheet = workbook.createSheet("FirstSheet");  
            sheet.addMergedRegion(new CellRangeAddress(0,3,0,100));
            sheet.addMergedRegion(new CellRangeAddress(4,4,0,100));


			HSSFCellStyle style=workbook.createCellStyle();
			//style.setBorderBottom(HSSFCellStyle.BORDER_THICK);
			style.setBorderTop(HSSFCellStyle.BORDER_MEDIUM);
			//style.setBorderRight(HSSFCellStyle.BORDER_THICK);
			style.setBorderLeft(HSSFCellStyle.BORDER_MEDIUM);
			style.setWrapText(true);
			
			HSSFCellStyle cellStyle = workbook.createCellStyle();
	        cellStyle = workbook.createCellStyle();
	        HSSFFont hSSFFont = workbook.createFont();
	        hSSFFont.setFontName(HSSFFont.FONT_ARIAL);
	        hSSFFont.setFontHeightInPoints((short) 16);
	        hSSFFont.setBoldweight(HSSFFont.BOLDWEIGHT_BOLD);
	        hSSFFont.setColor(HSSFColor.BLACK.index);
	        cellStyle.setWrapText(true);
	        cellStyle.setFont(hSSFFont);
	        cellStyle.setBorderBottom(HSSFCellStyle.BORDER_THICK);
	        
	        HSSFCellStyle nstyle=workbook.createCellStyle();
			nstyle.setBorderTop(HSSFCellStyle.BORDER_MEDIUM);
			nstyle.setBorderLeft(HSSFCellStyle.BORDER_MEDIUM);
			nstyle.setFont(hSSFFont);
			nstyle.setWrapText(true);
	      
	       
	        
           
            HSSFRow rowhead0 = sheet.createRow(0); 
            rowhead0.createCell(0).setCellValue("Log elektronickej aukcie pre stavbu " +name+ "\n");
            rowhead0.getCell(0).setCellStyle(cellStyle);
          
            
            
           
            HSSFRow rowhead = sheet.createRow((short)5);
            
            rowhead.createCell(0).setCellValue("Èas");
            rowhead.getCell(0).setCellStyle(nstyle);
            rowhead.createCell(1).setCellValue("Akcia");

            rowhead.getCell(1).setCellStyle(nstyle);
            rowhead.createCell(2).setCellValue("Uchádzaè");

            rowhead.getCell(2).setCellStyle(nstyle);
            rowhead.createCell(3).setCellValue("Krok");

            rowhead.getCell(3).setCellStyle(nstyle);
            int c = 6;
            for(AuctionLine line :lines){
            	HSSFRow row = sheet.createRow((short)c);
            	
            	row.createCell(0).setCellValue(line.time+"\n");
            	row.getCell(0).setCellStyle(style);
        
            	row.createCell(1).setCellValue(line.action+"\n");
            	row.getCell(1).setCellStyle(style);
            	row.createCell(2).setCellValue(line.user+"\n");
            	row.getCell(2).setCellStyle(style);
            	if(line.value == null){
            		row.createCell(3).setCellValue("\n");
            		row.getCell(3).setCellStyle(style);
            	}else{
            		row.createCell(3).setCellValue(line.value.toString()+"\n");
            		row.getCell(3).setCellStyle(style);
            	}
            	c++;
            	
            }
            for(int i = 0 ; i < 5; i++){
            	sheet.autoSizeColumn(i);
            }
    

            FileOutputStream fileOut = new FileOutputStream(filename);
            workbook.write(fileOut);
            fileOut.close();
            System.out.println("Your excel file has been generated!");

        } catch ( Exception ex ) {
            System.out.println(ex);
        }
	}
}
