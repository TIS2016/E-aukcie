import com.itextpdf.text.DocumentException;
import com.itextpdf.text.Font;
import com.itextpdf.text.FontFactory;
import com.itextpdf.text.pdf.BaseFont;

import java.io.IOException;
import java.sql.Date;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Collections;

public class Report extends Constants{

    static DBContext connect;
    private ArrayList<Row> rowsStart;
    private ArrayList<Row> rowsEnd;
    private String auctionName, aCompany,aOwner, currency;
    private Timestamp date,from, to;
    private String[] colNames;
    private Double ciastka;

    private String user = "postgres"; // username k databaze
    private String password = "tistis"; // password k databaze
    private String url = "jdbc:postgresql://localhost/postgres"; // URL k databaze

    SimpleDateFormat sdf, sdf2, sdf3;

    Font TITLE_FONT = FontFactory.getFont(FONT, "Cp1250",  BaseFont.EMBEDDED,11,BaseFont.ASCENT);
    Font NORMAL_FONT = FontFactory.getFont(FONT, "Cp1250",  BaseFont.EMBEDDED,10);
    Font SMALL_BOLD = FontFactory.getFont(FONT, "Cp1250",  BaseFont.EMBEDDED,10,BaseFont.ASCENT);

    public Report(String auctionID) {
        rowsStart = new ArrayList<>();
        rowsEnd = new ArrayList<>();
        connect = new DBContext();
        this.ciastka = null;

        sdf = new SimpleDateFormat("dd.MM.yyyy");
        sdf2 = new SimpleDateFormat("HH:mm:ss");
        sdf3 = new SimpleDateFormat("dd-MM-yyyy");

        try {
            connect.init(user, password, url);

            getData("start", auctionID);
            getData("end", auctionID);
            getName(auctionID);
            getProjectClient(auctionID);
            getAuctionDate(auctionID);
            getCurrency(auctionID);

            DBContext.close();

        } catch (SQLException e) {
            e.printStackTrace();
        }

        try {
            createPdf(auctionName + sdf3.format(to) + ".pdf");
        } catch (DocumentException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }

    }

    public Report(String auctionID, Double ciastka){
        rowsStart = new ArrayList<>();
        rowsEnd = new ArrayList<>();
        connect = new DBContext();
        this.ciastka = ciastka;
        sdf = new SimpleDateFormat("dd.MM.yyyy");
        sdf2 = new SimpleDateFormat("HH:mm:ss");
        sdf3 = new SimpleDateFormat("dd-MM-yyyy");

        try {
            connect.init(user, password, url);

            getData("start", auctionID);
            getData("end", auctionID);
            getName(auctionID);
            getProjectClient(auctionID);
            getAuctionDate(auctionID);
            getCurrency(auctionID);

            DBContext.close();

        } catch (SQLException e) {
            e.printStackTrace();
        }

        try {
            createPdf(auctionName + sdf3.format(to) + ".pdf");
        } catch (DocumentException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void getData(String startEnd,String auctionID){
        try {
            ResultSet r = DBContext.getAuctions(startEnd);

            while (r.next()){
                String source = r.getString("value");

                String action = r.getString("fk_action");
                String user = r.getString("fk_user");
                String zaruka = getZaruka(user);
                String firma = getFirma(user);
                Auction auction = (Auction) new Jackson2Example(action, source).getValue();

                if (startEnd.equals("end")){
                    rowsEnd.add(new Row(user,zaruka,auction,firma,startEnd.equals("end")));
                    Collections.sort(rowsEnd);
                    vlozPoradie(rowsEnd);
                }
                else{
                    rowsStart.add(new Row(user,zaruka,auction,firma,startEnd.equals("end")));
                    Collections.sort(rowsStart);
                    vlozPoradie(rowsStart);
                }

            }



            r.close();
        }catch (SQLException e) {
            e.printStackTrace();
        }

    }

    private void getCurrency(String auctionID){
        try {
            ResultSet r = DBContext.getCurrency(auctionID);

            while (r.next()){
                currency =  r.getString("curr");
                System.out.print(currency);

            }
            r.close();
        }catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private void getProjectClient(String auctionID){
        try {
            ResultSet r = DBContext.getProjectClient(auctionID);

            while (r.next()){
                aCompany =  r.getString("company_name");
                aOwner =  r.getString("fk_user_owner");
                //from = r.getDate("valid_from");
                //to = r.getDate("valid_until");
            }
            r.close();
        }catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private void getAuctionDate(String auctionID){
        try {
            ResultSet r = DBContext.getAuctionDate(auctionID);

            while (r.next()){
                from = r.getTimestamp("begining_time");
                to = r.getTimestamp("end_time");
            }
            r.close();
        }catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private void getName(String auctionID){
        try {
            ResultSet r = DBContext.getAuctionName(auctionID);

            while (r.next()){
                auctionName =  r.getString("name");
            }
            r.close();
        }catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private String getZaruka(String user){
        try {
            ResultSet r = DBContext.getZaruka(user);
            while (r.next()){
                return r.getString("numeric_value");
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return "";
    }

    private String getFirma(String user){
        try {
            ResultSet r = DBContext.getFirma(user);
            while (r.next()){
                return r.getString("company_name");
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return "";
    }

    private void vlozPoradie(ArrayList<Row> rows){
        for (int i = 0; i<rows.size();i++){
            rows.get(i).poradie=(i+1)+".";
        }
    }

    public ArrayList<ArrayList<String>> getArrays(ArrayList<Row> rows){
        ArrayList<ArrayList<String>> arrayLists = new ArrayList<>();

        for (Row r:rows) {
            arrayLists.add(r.toArray());
        }
        return arrayLists;
    }

    public void createPdf(String filename)
            throws DocumentException, IOException {

        PdfCreator pdfCreator = new PdfCreator(filename);
        //PdfFont f1 = PdfFontFactory.createFont(FONT, "Cp1250", true);
        Font font = FontFactory.getFont(FONT, "Cp1250", BaseFont.EMBEDDED);
        colNames = new String[]{"Poradie", "Alias/Prihl. meno", "Firma", "Cena\n["+ currency + "]", "Záruka\n[mes.]"};

        ArrayList<ArrayList<String>> colContent = new ArrayList<>();
        for (int i = 0; i<2; i++){
            colContent.add(new ArrayList<>());
            for (int j = 0; j<5; j++){
                colContent.get(i).add(i + "." + j);
            }
        }

        //Report rStart = new Report("start");
        //Report rEnd = new Report("end");
        ArrayList<ArrayList<String>> naKonci = getArrays(rowsEnd);

        pdfCreator.addTitle(auctionName);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Víťaznú ponuku v elektronickej aukcii pre stavbu "+ auctionName + " predložil uchádzač ",NORMAL_FONT,ALIGN_LEFT);

        pdfCreator.paragraph(naKonci.get(0).get(2),SMALL_BOLD,ALIGN_CENTER);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("s cenou "+naKonci.get(0).get(3)+",- "+ currency + " bez DPH a zárukou "+naKonci.get(0).get(4)+" mesiacov.  ",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Ceny uvedené v nasledujúcich tabuľkách sú uvedené bez DPH. ", NORMAL_FONT, ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Vstupné ponuky uchádzačov:",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.createTable(colNames,TITLE_FONT,getArrays(rowsStart));
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Všetky ponuky uchádzačov splnili podmienky účasti na elektronickej aukcii.",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.paragraph("Výsledky elektronickej aukcie, ktorá sa konala " + sdf.format(from)+" v čase od " + sdf2.format(from)+ " do " + sdf2.format(to)+ ":",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);

        pdfCreator.createTable(colNames,TITLE_FONT,naKonci);
        pdfCreator.addEmptyLine(1);
        if (ciastka==null){
            pdfCreator.paragraph("Výsledná cena víťaznej ponuky je v sume "+naKonci.get(0).get(3)+" "+ currency + " bez DPH.",
                    NORMAL_FONT,ALIGN_LEFT);
        }else{
            pdfCreator.paragraph("Po započítaní  fixnej  čiastky "+ciastka +" "+ currency + " bez DPH, " +
                            "ktorá nebola predmetom elektronickej aukcie je výsledná cena víťaznej ponuky v sume "+(Math.round((Double.valueOf(naKonci.get(0).get(3))+ ciastka)*100)/100.0 )+" "+ currency + " bez DPH.",
                    NORMAL_FONT,ALIGN_LEFT);
        }

        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("v Bratislave, " + sdf.format(to),NORMAL_FONT,ALIGN_RIGHT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Za " + aCompany,NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.paragraph(aOwner,NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(3);
        pdfCreator.paragraph("Za " + naKonci.get(0).get(2),NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.paragraph(naKonci.get(0).get(1),NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.close();


    }


}
