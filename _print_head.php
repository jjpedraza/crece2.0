<?php
require_once('lib/pdf/tcpdf.php');   
        ob_end_clean();
        class PDF extends TCPDF {
            public $str;
            public $PDFTitulo;
            public $PDFSubTitulo;
            public $PDFSubTitulo2;
            public $FechaContrato;
            public $Beneficiario;    
            public function Header() {            
                $image_file = 'img/logo_large.png';                                
                $this->Image($image_file, 15, 10, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->SetFont('helvetica', 'B', 10); $this->Text(100,10, ''.$this->PDFTitulo.''); 


                $this->SetFont('helvetica', 'R', 8); $this->Text(100,15, ''.$this->PDFSubTitulo.''); 
                $this->SetFont('helvetica', 'B', 12); $this->Text(100,20, ''.$this->PDFSubTitulo2.''); 
            }
        
            public function Footer() {                
                $this->SetY(-15);                
                $this->SetFont('helvetica', 'I', 6);            //  
                $this->SetTextColor(0,0,0);                
                $linea= "______________________________________________________________________________________________________________________________________________________________";            
                $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();            
                $this->Text(15,263, $linea);             
                $this->SetFont('helvetica', 'B', 9); $this->Text(15,266, $paginas);                 
                $this->SetFont('helvetica', 'R', 7); 
                $this->Text(32,266, substr($this->str,0,140)); 
                // $this->Text(32,269, substr($this->str,140,));             
            }
        }
    
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetKeywords('Reporte ITAVU');        
        $pdf->SetHeaderData('', '10', '', 'ITAVU  '.'Mi Nomina');        
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        
        $pdf->str =  "Impreso: ".fecha_larga($fecha).":".$hora;
        $pdf->PDFTitulo=$PDFTitulo;
        $pdf->PDFSubTitulo=$PDFSubTitulo;
        $pdf->PDFSubTitulo2=$PDFSubTitulo2;

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);        
        $pdf->SetMargins(15, 25 , 15);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
            require(dirname(__FILE__).'pdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        // set font
        $pdf->SetFont('helvetica', '', 9);        
        $pages = $pdf->getNumPages();        
        $pdf->AddPage('P', 'LETTER');
        $pag = $pdf->PageNo();

        $style = array(
            'border' => true,
            'padding' => 5,
            'fgcolor' => array(0,0,0),
            'bgcolor' => false
        );

        

        $styleqr = array(
            'border' => false,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(1,92,162),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

// $pdf->SetFont('dejavusans', '', 10);
// $pdf->SetFont('helvetica', '', 10);             
?>