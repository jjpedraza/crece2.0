<?php
if (isset($Aprobado)){
    if ($Aprobado == ''){

    } else {
          $pdf->SetXY(50, 0);
        // $pdf->Image('img/afimex_plantilla.jpg', '', '', 120, 190, '', '', 'T', false, 300, '', false, false, 0, false, false, false);    
      
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->SetAlpha(0.5);
        if ($Aprobado==TRUE){
            $pdf->SetTextColor(0,143,57);                    
            $pdf->SetFont('', 'B', 50, '', 'false'); $pdf->Text(10, 100, ''.'APROBADO'); 
        } else {
            $pdf->SetTextColor(255,0,0);                    
            $pdf->SetFont('', 'B', 50, '', 'false'); $pdf->Text(10, 100, ''.'RECHAZADO'); 
        }
        $pdf->StopTransform();
    }
}


?>