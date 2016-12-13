<?php
namespace PdfGen;

use PdfGen\mpdf\mPDF;

class AuctionPdf
{
    private $auctionId;

    private $html;

    private $nazov;

    public function __construct($auctionId)
    {
        $this->auctionId = $auctionId;
    }

    public function arrayToHtml($data)
    {
        $heslo = "valami";
        $predmet = "masik valami";
        $nazov_aukcie = "harmadik valami";
        $vyhlasovatel = "negyedik valami";
        $login = "otodik valami";
        $link = "https://www.facebook.com/";
        $prevadzkovatel = "hatodik valami";
        $termin_doruc = "hetedik valami";
        $termin_ponuk = "nyolcadik valami";
        $start = "kilencedik valami";
        $doklady = "tizedik valami";
        $kriteria = "tiyenegzedik valami";
        $this->nazov = "";

        $this->html = '
<center><h1>Pozvánka na účasť v aukcii ' . $nazov_aukcie . '<h1></center>
<p>Predmetom e-aukcie bude ' . $predmet . '. Aukciu vyhlásia spoločnosť ' . $vyhlasovatel . '. Aukcia je prevádzkovaná na ' . $prevadzkovatel . '.</p>
<p>Termín doručenia dokladov je do ' . $termin_doruc . '.</p>
<p>Termín odovzdania cenových ponúk je do ' . $termin_ponuk . '.</p>
<p>Termín začiatku aukice je ' . $start . '.</p>
<p>Požadované doklady na učasť v aukcii: ' . $doklady . '</p>
<p>Kritéria a priebeh auckie:' . $kriteria . '</p>
<p>Prihlásiť sa môžete na <a href = "' . $link . '"> ' . $link . '</a></p>
<p>Vaše prihalsovacie meno:' . $login . '</p>
<p>Vaše heslo:' . $heslo . '</p>';

    }

    public function savePdf()
    {
//        include("Mpdf/Mpdf.php");
        $mpdf = new mpdf('c');

        $mpdf->WriteHTML($this->html);
        $mpdf->Output($this->nazov, 'I');
//        $Mpdf->Output(PROJECT_ROOT . '\\auction_files\\pdf');
        exit;
    }
}