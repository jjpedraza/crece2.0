<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");

$IdCliente = VarClean($_GET['id']);

if ($IdCliente <> ''){

    $sql = "select * from clientes where curp='".$IdCliente."'";
    // echo $sql;
    $rc = $db1->query($sql);        
    if ($db1->query($sql) == TRUE){
        if($f = $rc -> fetch_array())
        {

        //Nomina PDF=
        require_once('lib/pdf/tcpdf.php');   
        ob_end_clean();
        class PDFEDOCUENTA extends TCPDF {
            public $str;
            public $Delegacion;
            public $RegFiscal;
            public $FechaContrato;
            public $Beneficiario;
    
            public function Header() {
                // Logo
                //   $image_file = K_PATH_IMAGES.'logo_color.png';
                $image_file = 'img/logo_large.png';
                
                $icono = K_PATH_IMAGES.'user.png';
                
                $this->Image($image_file, 15, 10, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    
                // $this->Image($icono, 15, 19, 5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                // Set font
                $this->SetFont('helvetica', 'B', 10);
                // Title
            //    $this->Cell(100, 40, 'INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Text(100,15, 'Reporte de Informacion de Cliente:'); 
            $this->Text(90,5, ''); 
            $this->SetFont('helvetica', 'r', 8);
            $this->Text(120,9, ''); 
    
            //    $this->SetFont('courier', 'R', 7); $this->Text(85,12, ''); $this->SetFont('courier', 'R', 7); $this->Text(90,12, 'Reg. Fiscal:'.$this->RegFiscal); 
            //    $this->SetFont('courier', 'R', 6); $this->Text(85,15, ''); $this->SetFont('courier', 'B', 6); $this->Text(100,15, 'Lugar y fecha: '.$this->FechaContrato); 
    
            $this->SetFont('helvetica', 'B', 12);
            //  $this->SetTextColor(0,91,160);
            $this->SetTextColor(0,0,0);
            //    $this->Image($icono, 15, 19, 5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            //    $this->Text(20,29, '  '.$this->Beneficiario); 
            //  $this->Cell(0, 0, $this->Beneficiario, 1, 1, 'C');
            //  $this->MultiCell(0, 0,  $this->Beneficiario , 1, 'C', false, 1);
    
            }
        
            public function Footer() {
                // Position at 15 mm from bottom
                $this->SetY(-15);
                // Set font
            //    $line_width = (0.85 / $this->k);
            //    $this->Ln(1);
            $this->SetFont('helvetica', 'I', 6);
            //    $pdf->SetXY(0, 100);                   
            $this->SetTextColor(0,0,0);
                // Page number
                $linea= "______________________________________________________________________________________________________________________________________________________________";
            //    $this->Cell(0, 0, $linea, 0, false, 'L', 0, '', 0, false, 'T', 'M');
            //    $this->Cell(0, 20, $this->str.' | Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
            // $str = $this->str." |  Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();
            // $this->SetTextColor(205,205,205);
            $this->Text(15,263, $linea); 
            // $this->SetTextColor(129,129,129);
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,266, $paginas); 
            // $this->SetTextColor(165,165,165);
            $this->SetFont('helvetica', 'R', 7); 
            $this->Text(32,266, substr($this->str,0,140)); 
            $this->Text(32,269, substr($this->str,140,)); 
            // $this->Cell(0, 20, $this->str.'. Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
            }
        }
    
        $pdf = new PDFEDOCUENTA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetKeywords('Reporte ITAVU');
        //$pdf->SetHeaderData('pdf_logo.jpg', '40','');
        $pdf->SetHeaderData('', '10', '', 'ITAVU  '.'Mi Nomina');
        //$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // $pdf->setFooterData('', '10', '', 'ITAVU  '.$string);
        $pdf->str =  "Impreso: ".fecha_larga($fecha).":".hora12($hora);
        $pdf->RegFiscal = 'RegFis';
        $pdf->FechaContrato = 'Fecha';
        
        //  $pdf->FechaContrato =XML_FechaEmision($xmlCont);
        
        $pdf->Beneficiario = "Nombre";

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(15, 25 , 15);
    
        #Establecemos el margen inferior:
        // $pdf->SetAutoPageBreak(true,25);  
        
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
        
        
        $pag = $pdf->PageNo();
        //echo $cancelado;
        //  if($cancelado == TRUE){
        // 	 $pdf->Image('icon/cancelado.png', 18, 70,180, 100, '', '', '', false, 300, '', false, false, 0);
        //  }
        // $pdf->text
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
            //'bgcolor' => false, //array(255,255,255)
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );


                // $pdf->SetFont('', 'B', 9, '', 'false');
                // $pdf->Text(80, 25, 'Informacion de Registro:'); 

            
            
            
            $html = "";
            $html.="<table>";

            $html.='<tr>';
                $html.='<td bgcolor="#FFEFBF" style="background-color:#FFEFBF; color:#000000">
                <span style="font-size:12pt;"><b>'.$f['nombre'].'</b></span><br>';

                if ($f['grupo']<> ''){
                    $html.='
                    <span style="font-size:10pt; font-weight:normal;"><b>'.$f['grupo'].'</b> ';

                    if ($f['grupo_cargo']){
                        $html.=' '.$f['grupo_cargo'];
    
                    }

                    $html.='</span><br><br>';
                }
                $html.='
                <br>
                <span style="font-size:8pt; font-weight:normal;"><b>Telefono</b>:'.$f['telefono'].'</span><br>
                <span style="font-size:8pt; font-weight:normal;"><b>Fecha de Nac.</b>:'.$f['fechadenacimiento'].'</span><br>
                    
                </td>';             

                
                $html.='<td bgcolor="#EEEEEE" style="color:#000000">
                <span style="font-size:7pt; font-weight:normal;"><b>Domicilio:</b> <br>
                '.$f['domicilio'].', '.$f['municipio'].'. '.$f['estado'].'</span><br>
                <br>
                <span style="font-size:8pt; font-weight:normal;"><b>CURP</b>:'.$f['curp'].'</span><br>
                <span style="font-size:8pt; font-weight:normal;"><b>IFE</b>:'.$f['IFE'].'</span><br>
                
                    </td>'; 

            $html.='</tr>';

            $html.='<tr  ><td></td><td></td></tr>';        //linea en blanco 
            
                    
            $html.='<tr>';
            $html.='<td  style="text-align:center; background-color:#DFDFD0; color:#000000;">';
            $html.='<span style="font-size:9pt; font-weight:normal;">REFERENCIAS PERSONALES</span><br><br>';
            $ref = 0;
            if (strlen($f['ref1_nombre'])>1 ){
                
                $html.='<span style="font-size:7pt; font-weight:normal;"><b>'.$f['ref1_nombre'].'</b></span><br>';

                $html.='<span style="font-size:7pt; font-weight:normal;">Tel.:'.$f['ref1_tel'].'</span><br>';
                $html.='<span style="font-size:7pt; font-weight:normal;">Domicilio.:'.$f['ref1_domicilio'].'</span><br><br>';
                $ref = $ref +1;
                

            }

            if (strlen($f['ref2_nombre'])>1 ){
                
                $html.='<span style="font-size:7pt; font-weight:normal;"><b>'.$f['ref2_nombre'].'</b></span><br>';

                $html.='<span style="font-size:7pt; font-weight:normal;">Tel.:'.$f['ref2_tel'].'</span><br>';
                $html.='<span style="font-size:7pt; font-weight:normal;">Domicilio.:'.$f['ref2_domicilio'].'</span><br>';
                $ref = $ref +1;
                

            }

            if ($ref == 0 ){
                $html.='<span style="font-size:7pt; color:#D90000; font-weight:normal;">- Sin registro - </span><br>';
            }

            
            $html.='</td>';
            $html.='<td bgcolor="#FFEFBF"  style="text-align:center;color:#333333">';            
            $html.='<span style="font-size:9pt; font-weight:normal;">REFERENCIAS COMERCIALES</span><br><br>';

            $refc = 0;
            if (strlen($f['refc1_nombre'])>1 ){
                
                $html.='<span style="font-size:7pt; font-weight:normal;"><b>'.$f['refc1_nombre'].'</b></span><br>';

                $html.='<span style="font-size:7pt; font-weight:normal;">Tel.:'.$f['refc1_tel'].'</span><br>';
                $html.='<span style="font-size:7pt; font-weight:normal;">Domicilio.:'.$f['refc1_domicilio'].':</span><br>';
                $html.='<span style="font-size:7pt; font-weight:normal;">Años de conocerle:'.$f['refc1_antiguedad'].'</span><br><br>';
                $refc = $refc+1;
                

            }

            if (strlen($f['refc2_nombre'])>1 ){
                
                $html.='<span style="font-size:7pt; font-weight:normal;"><b>'.$f['refc2_nombre'].'</b></span><br>';

                $html.='<span style="font-size:7pt; font-weight:normal;">Tel.:'.$f['refc2_tel'].'</span><br>';
                $html.='<span style="font-size:7pt; font-weight:normal;">Domicilio.:'.$f['refc2_domicilio'].':</span><br>';
                $html.='<span style="font-size:7pt; font-weight:normal;">Años de conocerle:'.$f['refc2_antiguedad'].'</span><br><br>';
                $refc = $refc+1;
                

            }


            if (strlen($f['refc3_nombre'])>1 ){
                
                $html.='<span style="font-size:7pt; font-weight:normal;"><b>'.$f['refc3_nombre'].'</b></span><br>';

                $html.='<span style="font-size:7pt; font-weight:normal;">Tel.:'.$f['refc3_tel'].'</span><br>';
                $html.='<span style="font-size:7pt; font-weight:normal;">Domicilio.:'.$f['refc3_domicilio'].':</span><br>';
                $html.='<span style="font-size:7pt; font-weight:normal;">Años de conocerle:'.$f['refc3_antiguedad'].'</span><br><br>';
                $refc = $refc+1;
                

            }
        
            if ($refc == 0 ){
                $html.='<span style="font-size:7pt; color:#D90000; font-weight:normal;">- Sin registro - </span><br>';
            }
            $html.='</td>';
            $html.="</tr>";


            $html.='<tr  ><td></td><td></td></tr>';        //linea en blanco 

            //PERFIL SOCIOECONOMICO
            $html.='<tr>';
            $html.='<td colspan="2" bgcolor="#FFEFBF"  style="text-align:center;color:#333333">';                    
            $html.='<span style="font-size:9pt; font-weight:normal;">PERFIL SOCIOECONOMICO</span>';
            $html.='</td><td></td>
            </tr>';
            
            $html.='<tr>
                    <td bgcolor="#BFFFBF"  style="text-align:center;color:#333333" align="left">';                    
            $html.='<span style="font-size:9pt; width:100%; text-align:center; font-weight:normal;">INGRESOS</span><br><br>';

            if (strlen($f['trabajo_nombre'])>1 ){
                if (strlen($f['trabajo_giro'])>1 ){                   
                    $html.='<span style="font-size:7pt; font-weight:normal;">Trabaja: <b>'.$f['trabajo_nombre'].'</b>('.$f['trabajo_giro'].')</span><br>';
                } else {
                    $html.='<span style="font-size:7pt; font-weight:normal;">Trabaja: <b>'.$f['trabajo_nombre'].'</b></span><br>';
                }
            }

            if (strlen($f['trabajo_domicilio'])>1 ){
                $html.='<span style="font-size:7pt; font-weight:normal;">'.$f['trabajo_domicilio'].'</span><br>';
            }

            if (strlen($f['trabajo_telefono'])>1 ){
                $html.='<span style="font-size:7pt; font-weight:normal;">Tel. <b>'.$f['trabajo_telefono'].'</b></span><br>';
            }

            if (strlen($f['trabajo_salario'])>1 ){
                if (strlen($f['trabajo_puesto'])>1 ){                   
                    $html.='<span style="font-size:7pt; font-weight:normal;">Salario: <b>'.Pesos($f['trabajo_salario']).'</b> (Puesto en '.$f['trabajo_puesto'].')</span><br>';
                } else {
                    $html.='<span style="font-size:7pt; font-weight:normal;">Salario: <b>'.Pesos($f['trabajo_salario']).'</b></span><br>';
                }
            }


            $html.='</td>';            

            $html.='<td bgcolor="#FFC4C4"  style="text-align:center;color:#333333">';                    
            $html.='<span style="font-size:9pt; font-weight:normal;">GASTOS</span>';
            $html.='</td>';
            
            $html.='</tr>';        //linea en blanco 

            $html.='</table>';



            $pdf->SetXY(15,35);
            $pdf->writeHTML($html, true, false, true, false, '');// Print text using writeHTMLCell()
            
            // echo $html;
            //  ob_end_clean();
            $pdf->Output($IdCliente.'_carnet', 'I');

        }
    }
 





}


//    Historia($RinteraUser, "VIO", "".$id_rep."");



?>