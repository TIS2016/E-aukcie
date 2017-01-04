<?php
namespace PdfGen;

use DataObject\AdminFromData;
use DateTime;
use PdfGen\FPDF;

class PDF extends FPDF
{
    /**
     * @param AdminFromData $data
     */
    function dataToPdf($data)
    {
        $termin_doruc = new DateTime($data->getTerminDorucenia());
        $termin_ponuk = new DateTime($data->getTerminDorucenia());
        $start = new DateTime($data->getTerminAukcie());
        $h1 = 'Pozvánka na účasť v aukcii ' . $data->getNazov();
        $p1 = 'Predmetom e-aukcie bude ' . $data->getPredmet() . '. Aukciu vyhlásia spoločnosť ' . $data->getVyhlasovatel() . '. Aukcia je prevádzkovaná na ' . $data->getPrevadzkovatel() . '.';
        $p2 = 'Termín doručenia dokladov je do ' . $termin_doruc->format('d.m.Y');
        $p3 = 'Termín odovzdania cenových ponúk je do' . $termin_ponuk->format('d.m.Y');
        $p4 = 'Termín začiatku aukice je ' . $start->format('d.m.Y');
        $p5 = 'Požadované doklady na učasť v aukcii: ' . $data->getPozadovanePodklady();
        $p6 = 'Kritéria a priebeh auckie: ' . $data->getKriteria();
        $p7 = 'ako prihlasovací login použite prvú časť Vašej e-mailovej adresy vaslogin@xxxxxxx.xx';
        $p8 = 'Prihlásiť sa môžete na:';
        $loginPage = $_SERVER['HTTP_HOST'].'/login';


        $this->AddPage();
        $this->AddFont('Arial', '', 'Arial.php');
        $this->SetFont('Arial', '', 20);
        $this->Cell(0, 15, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $h1), 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $p1), 0, 'L');
        $this->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $p2), 0, 'L');
        $this->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $p3), 0, 'L');
        $this->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $p4), 0, 'L');
        $this->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $p5), 0, 'L');
        $this->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $p6), 0, 'L');
        $this->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $p7), 0, 'L');
        $this->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $p8), 0, 'L');

        $this->SetTextColor(0, 0, 255);
        $this->SetFont('Arial','U', 12);
        $this->Write(5, $loginPage, $loginPage);
    }
}
