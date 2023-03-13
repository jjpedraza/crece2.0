<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");

if (isset($_GET['id'])){
    $NoSol = VarClean($_GET['id']);
    $Curp = NoSol_to_Curp($NoSol);
    $Cliente = Cliente_Nombre($Curp);

    if ($NoSol <> ''){
        Historia($RinteraUser, "PRINT", "Descargo la Estado de Cuenta NoSol=".$NoSol."");
        $sqlX = "select 
        *

        from edocuenta where nosol='".$NoSol."' order by no + 0";
        // echo $sqlX;
        $rx = $db1->query($sqlX);    
        if ($db1->query($sqlX) == TRUE){   
            $PDFTitulo="CONTROL DE PAGOS";
            if (Contrato_Activo($NoSol) ==TRUE){
                $PDFSubTitulo="No. ".$NoSol." | ACTIVO";
            } else {
                $PDFSubTitulo="No. ".$NoSol." | CANCELADO";
            }
            
            $PDFSubTitulo2=$Cliente;
            include("_print_head.php");


            $htmlPDF = '<table border="1" style="
                    
                ">';

            $htmlPDF.='<tr 
                style="
                    
                    font-size:8pt; text-align:center;
                "
            >';
            $htmlPDF.='<td width="30pt">No.'.'</td>'; //1                            
            $htmlPDF.='<td width="200pt" >Fecha de Pago'.'</td>'; //1                            
            $htmlPDF.='<td >Cantidad'.'</td>'; //1                            
            $htmlPDF.='<td>'.'</td>'; //1                                        
            $htmlPDF.='</tr>';

            $c = 0; $GranAbono=0; $GranMoratorio = 0; $GranTotal = 0; $GranInteres = 0; $GranExtras=0; $GranSemanal=0; $DiasMax = 0;
             while($Pagos= $rx -> fetch_array()) { 
                // $Total_Moratorios = $Total_Moratorios + $Pagos['mora_debe'];
                

                if ($Pagos['EstadoPago']=='SIN PAGAR'){
                    $GranTotal = $GranTotal + $Pagos['Cantidad'];
                    $GranMoratorio = $GranMoratorio + $Pagos['mora_debe'];
                    $GranInteres = $GranInteres + $Pagos['interes'];
                    $GranSemanal = $GranSemanal + $Pagos['CargoSemanal'];
                    $GranExtras = $GranExtras + $Pagos['CargoExtraOrdinario_cantidad'];
                    $GranAbono = $GranAbono + $Pagos['abono'];

                    if ($DiasMax == 0){
                        $DiasMax = $Pagos['mora_dias'];
                    }
                }
                $htmlPDF.='<tr 
                    
                >';
             
                $htmlPDF.='<td width="30pt" ><b>'.$Pagos['no'].'</b></td>'; //1                            
                $htmlPDF.='<td width="200pt" style="font-size:8pt;">'.FechaLarga($Pagos['fecha_inicio']).' a <br>'.FechaLarga($Pagos['fecha_fin']).'</td>'; //1                            
                $htmlPDF.='<td ><b>'.Pesos($Pagos['Cantidad']).'</b></td>'; //1                            
                $htmlPDF.='<td ></td>'; //1                            
                $htmlPDF.='</tr>';

                $c = $c + 1;
             }


            $htmlPDF.='</table>';

            $DiasAmigables = DiasAmigables($DiasMax);

        //     $htmlPDF.= '<br><br>Resumen de Cuenta:<br><table style="
        //             border:1px solid gray;
        //             font-size:8pt;

        //         ">';

        
        // $htmlPDF.= '<tr><td style="text-align:right;">Capital:</td><td>'.Pesos($GranAbono).'</td></tr>';
        // $htmlPDF.= '<tr><td style="text-align:right;">Interes de Financiamiento:</td><td>'.Pesos($GranInteres).'</td></tr>';
        // $htmlPDF.= '<tr><td style="text-align:right;">Moratorio:</td><td>'.Pesos($GranMoratorio).'</td></tr>';
        // $htmlPDF.= '<tr><td style="text-align:right;">Cargos Semanales:</td><td>'.Pesos($GranSemanal).'</td></tr>';
        // $htmlPDF.= '<tr><td style="text-align:right;">Cargos Extraordinarios:</td><td>'.Pesos($GranExtras).'</td></tr>';
        // $htmlPDF.= '<tr><td style="text-align:right;">Dias de Retrado:</td><td>'.$DiasMax.' dias, ('.$DiasAmigables.')</td></tr>';
        // $SuperTotal = $GranAbono +  $GranInteres + $GranMoratorio + $GranExtras + $GranSemanal;

        // $htmlPDF.= '<tr><td 
        // style="text-align:right; background-color:black; color:white; font-size:12pt;">TOTAL:</td><td 
        // style="text-align:left; background-color:black; color:white; font-size:12pt;">'.Pesos($GranTotal).'</td></tr>';
        // $htmlPDF.= '<tr><td colspan="2" style="text-align:center;">'.NumToLetras_Moneda($SuperTotal).'</td></tr>';

        
        // $htmlPDF.= '</table>';


        $idgrupo = idgrupo($NoSol);
        if ($idgrupo == '') {
            $htmlPDF.='<br>Este contrato es de tipo INDIVIDUAL';
        } else {
            $infogrupo = InfoGrupo_html($idgrupo);
            $htmlPDF.='<br><br>Este contrato es de tipo Grupal:<br>'.$infogrupo;


        }


            //Texto con coordenadas
            // $pdf->SetFont('', 'B', 12, '', 'false'); $pdf->Text(48, 97, ''.'Palabra EXIS'); 

            
            
            // echo $htmlPDF;

            include("_print_footer.php");




            

                
                
                


        } else { echo "ERROR; Sin informacion en la base de datos";}
        
    } else { echo "ERROR; Parametros incompletos";}
} else { echo "ERROR; Parametros no definidos";}


unset($rx, $sqlX, $Pagos);

?>