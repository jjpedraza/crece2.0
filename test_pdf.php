<?php
include ("head.php");
require_once('lib/pdf/tcpdf.php');   

$pdf = new PDFEDOCUENTA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetKeywords('Reporte ITAVU');
//$pdf->SetHeaderData('pdf_logo.jpg', '40','');
$pdf->SetHeaderData('', '10', '', 'ITAVU  '.'Mi Nomina');
//$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(15, 25 , 15);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
    require(dirname(__FILE__).'pdf/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('helvetica', '', 9);
// add a page
$pages = $pdf->getNumPages();

$pdf->AddPage('P', 'LETTER'); //en la tabla de reporte L o P


    $html="<b>Hola Mundo</b>";
    $pdf->SetXY(15,35);
    $pdf->writeHTML($html, true, false, true, false, '');// Print text using writeHTMLCell()
            
        // echo $html;
        //  ob_end_clean();
        $pdf->Output($IdCliente.'_carnet', 'I');
include ("footer.php");
?>