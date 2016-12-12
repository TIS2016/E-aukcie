
import com.itextpdf.text.DocumentException;


import java.io.IOException;


public class Test extends Constants{

    public static void main(String[] args)
            throws DocumentException, IOException {

        new Report("2",34374.29); // ID aukcie, fixna ciastka
        //new Report("2"); // ID aukcie, bez fixnej ciastky

    }
}


