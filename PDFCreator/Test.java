
import com.itextpdf.text.DocumentException;

import java.io.IOException;
import java.util.ArrayList;

public class Test extends Constants{

    /** Path to the resulting PDF file. */


    /**
     * Creates a PDF file: hello.pdf
     * @param    args    no arguments needed
     */
    public static void main(String[] args)
            throws DocumentException, IOException {
        new Test().createPdf(OUTPUT);

    }

    /**
     * Creates a PDF document.
     * @param filename the path to the new PDF document
     * @throws    DocumentException
     * @throws    IOException
     */
    public void createPdf(String filename)
            throws DocumentException, IOException {
        PdfCreator pdfCreator = new PdfCreator(filename);
        ArrayList<ArrayList<String>> colContent = new ArrayList<>();
        for (int i = 0; i<2; i++){
            colContent.add(new ArrayList<>());
            for (int j = 0; j<5; j++){
                colContent.get(i).add(i + "." + j);
            }
        }

        pdfCreator.addTitle();
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Víťaznú ponuku v elektronickej aukcii pre stavbu “nazov aukcie“ predložil uchádzač ",NORMAL_FONT,ALIGN_LEFT);

        pdfCreator.paragraph("FIRMA 1",SMALL_BOLD,ALIGN_CENTER);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("s cenou 145 000.07,- EUR bez DPH a zárukou 60 mesiacov.  ",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Ceny uvedené v nasledujúcich tabuľkách sú uvedené bez DPH. ", NORMAL_FONT, ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Vstupné ponuky uchádzačov:",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.createTable(colNames,colContent);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Všetky ponuky uchádzačov splnili podmienky účasti na elektronickej aukcii.",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.paragraph("Výsledky elektronickej aukcie, ktorá sa konala 12.09.2016 v čase od 15:00 do 15:32:35:",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.createTable(colNames,colContent);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Po započítaní  fixnej  čiastky 34 374,29 EUR bez DPH, " +
                "ktorá nebola predmetom elektronickej aukcie je výsledná cena víťaznej ponuky v sume 179 374,36 EUR bez DPH.",
                NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("v Bratislave, 12. septembra 2016 ",NORMAL_FONT,ALIGN_RIGHT);
        pdfCreator.addEmptyLine(1);
        pdfCreator.paragraph("Za $nazov nasej firmy$",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.paragraph("$meno zastupcu firmy$",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.addEmptyLine(3);
        pdfCreator.paragraph("Za $nazov kleinta$",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.paragraph("$meno klienta$",NORMAL_FONT,ALIGN_LEFT);
        pdfCreator.close();

    }


}


