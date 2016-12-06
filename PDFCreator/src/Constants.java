import com.itextpdf.text.BaseColor;
import com.itextpdf.text.Element;
import com.itextpdf.text.Font;
import com.itextpdf.text.pdf.BaseFont;

abstract class Constants {
    Font TITLE_FONT = new Font(Font.FontFamily.TIMES_ROMAN, 11, Font.BOLD);
    Font NORMAL_FONT = new Font(Font.FontFamily.TIMES_ROMAN, 10, Font.NORMAL);
    Font SMALL_BOLD = new Font(Font.FontFamily.TIMES_ROMAN, 10, Font.BOLD);
    Font SMALL_FONT = new Font(Font.FontFamily.TIMES_ROMAN, 10, Font.NORMAL);
    public static final String FONT = "./src/resources/FreeSans.ttf";


    //Font redFont = new Font(Font.FontFamily.TIMES_ROMAN, 12, Font.NORMAL, BaseColor.RED);

    int ALIGN_LEFT = Element.ALIGN_LEFT;
    int ALIGN_CENTER = Element.ALIGN_CENTER;
    int ALIGN_RIGHT= Element.ALIGN_RIGHT;

    /*** Constanst for "Vystupny protokol" ***/





}
