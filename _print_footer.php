<?php
$pdf->SetFont('', 'R', 12, '', 'false');
$pdf->SetTextColor(0,0,0);            
$pdf->SetXY(15,35);
$pdf->writeHTML($htmlPDF, true, false, true, false, '');// Print text using writeHTMLCell()
include("_print_sello.php");
$ArchivoFinal = "";
$pdf->Output($ArchivoFinal.'', 'I');
?>