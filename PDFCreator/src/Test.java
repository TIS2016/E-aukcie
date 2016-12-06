
import com.itextpdf.text.DocumentException;


import java.io.IOException;


public class Test extends Constants{

    public static void main(String[] args)
            throws DocumentException, IOException {
        //new Test().createPdf(OUTPUT);
        new Report("2",34374.29);
        //new Report("2");

    }
}


