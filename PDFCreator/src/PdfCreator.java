
import com.itextpdf.text.*;
import com.itextpdf.text.pdf.BaseFont;
import com.itextpdf.text.pdf.PdfPCell;
import com.itextpdf.text.pdf.PdfPTable;
import com.itextpdf.text.pdf.PdfWriter;

import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.util.ArrayList;
import java.util.Date;



public class PdfCreator extends Constants {

    private String file;
    private Document document;

    public PdfCreator(String file) throws FileNotFoundException, DocumentException {
        this.file = file;
        document = new Document();
        PdfWriter.getInstance(document, new FileOutputStream(file));
        open();

    }

    public void open(){
        document.open();
    }

    public void close(){
        document.close();
    }

    public void paragraph(String content, Font font2, int align) throws DocumentException {
        //Font f = FontFactory.getFont(FontFactory.COURIER, "Cp1250", BaseFont.EMBEDDED);

        Paragraph p = new Paragraph((content), font2);
        p.setAlignment(align);
        document.add(p);

    }

    public void addTitle(String nazov)
            throws DocumentException {
        Font font = FontFactory.getFont(FONT, "Cp1250",  BaseFont.EMBEDDED,11,BaseFont.ASCENT);
        paragraph("Vyhodnotenie súťažných ponúk pre stavbu ", font, ALIGN_CENTER);
        paragraph(nazov, font, ALIGN_CENTER);

    }

    public void addEmptyLine(int number) throws DocumentException {
        for (int i = 0; i < number; i++) {
            paragraph(" ",NORMAL_FONT,ALIGN_LEFT);
        }
    }

    public void newPage(){
        document.newPage();
    }

    public void createTable(String[] colNames, Font font, ArrayList<ArrayList<String>> colContent)
            throws DocumentException {


        PdfPTable table = new PdfPTable(colNames.length);

         //table.setBorderColor(BaseColor.GRAY);
        // t.setPadding(4);
        // t.setSpacing(4);
        // t.setBorderWidth(1);

        for (String colName:colNames) {
            PdfPCell c1 = new PdfPCell(new Phrase(colName,font));
            c1.setHorizontalAlignment(ALIGN_CENTER);
            c1.setBackgroundColor(BaseColor.GRAY);
            c1.setPadding(4);
            table.addCell(c1);
        }

        table.setHeaderRows(1);
        for (ArrayList<String> row: colContent) {
            for (String cell:row) {
                PdfPCell pcell = new PdfPCell(new Phrase(cell, SMALL_FONT));
                pcell.setHorizontalAlignment(ALIGN_CENTER);
                table.addCell(pcell);
            }
        }

        document.add(table);

    }

    private String convertString(String s){
        String res = "";
        for (int i = 0; i < s.length(); i++) {
            char c = s.charAt(i);
            if (c > 31 && c < 127)
                res += String.valueOf(c);
            else
                res += String.valueOf(String.format("\\u%04x", (int) c));

        }
        return res;
    }
}
