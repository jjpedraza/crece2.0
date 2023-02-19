<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");

if (isset($_GET['id'])){
    $NoSol = VarClean($_GET['id']);
    $IdSucursal =  NoSol_to_IdSucrusal($NoSol);
    $RepresentanteLegal = RepresentanteLegal($IdSucursal);
    if ($NoSol <> ''){
        Historia($RinteraUser, "PRINT", "Descargo el contrato NoSol=".$NoSol."");
        $sql = "select * from solicitudes where nosol='".$NoSol."'";
        $r = $db1->query($sql);        
            if ($db1->query($sql) == TRUE){
                if($Sol = $r -> fetch_array()) {

                    $sql2 = "select * from clientes where curp='".$Sol['curp']."'";
                    $r2 = $db1->query($sql2);        
                    if ($db1->query($sql) == TRUE){
                        if($Cliente = $r2 -> fetch_array()) {                
                            //Generar PDF
                            if ($Sol['tipo']=='INDIVIDUAL'){
                                    $PDFTitulo="PAGARE";
                            } else {
                                    $PDFTitulo="PAGARE SOLIDARIO - ";
                            }

                            $PDFSubTitulo="No. ".$NoSol." - ".$Sol['fechasol'];
                            $PDFSubTitulo2=$Sol['Cliente'];
                            include("_print_head.php");


                            

                            // $htmlPDF='Bueno por '.Pesos($Sol['cantidad']);

                            $htmlPDF='<span style="text-align:right;font-size:12pt">
                            Bueno por: <b>'.Pesos($Sol['cantidad']).'</b> <br>('.NumToLetras_Moneda($Sol['cantidad']).') </span><br><br>';

                            $htmlPDF.='<span style="text-align:right;font-size:11pt">Aldama, Tamaulipas.'.fecha_larga($Sol['fechacontrato']).' </span><br><br>';



                            $htmlPDF.='<span style="text-align:justify;font-size:11pt">';
                            $htmlPDF.='Por el presente pagare me obligo incondicionalmente a pagar a la orden de CRECE Y MAS S.A. DE C.V. Representada por el C. <b>'.$RepresentanteLegal.'</b>,  en sus oficinas en Aldama, Tamaulipas, o en cualquiera otra plaza que se nos indicará, en fechas y montos establecidos en el presente pagare. <br><br>';

                            $como=""; $npago = 0;
                            if ($Sol['formadepago']==7){
                                $como="semanal";    
                                $npago = 4 * $Sol['plazo'];
                                }
                            if ($Sol['formadepago']==15){
                                $como="quincenal";  
                                $npago = 2 * $Sol['plazo'];
                                }
                            if ($Sol['formadepago']==30){
                                $como="mensual";    
                                $npago = 1 * $Sol['plazo'];
                                }
                            $npago = round($npago);

                            $htmlPDF.='El valor total que ampara este Pagaré ha sido recibido en efectivo y a nuestra entera satisfacción este pagaré ampara una serie de <b>'.$npago.' pagos </b> de forma '.$como.'  en <b> '.$Sol['plazo'].' meses</b> y todos están sujetos a la condición de que, al no pagarse cualquiera de ellos y se tenga saldo vigente, serán exigibles de manera anticipada todos los que le sigan en fecha de vencimiento, además de los pagos ya vencidos.<br><br>
                            ';
        
                            $htmlPDF.='La cantidad importe de este pagare causara interes ordinario, que resulte de multiplicar la Tasa del '.$Sol['tasa_interes'].'% ('.NumToLetras($Sol['tasa_interes']).') MENSUAL, durante el tiempo que tenga vigencia en este crédito. <br><br>';

                            $htmlPDF.='Si el importe correspondiente a cada uno de los pagos no fuere pagado a su vencimiento el dia  '.fecha_larga(Solicitud_FechaUltimoPago($NoSol)).' causara intereses moratorios de '.$Sol['tasa_moratorio'].'% ('.NumToLetras($Sol['tasa_moratorio']).')mensual mas el interes ordinario mensual,  por el tiempo en que el adeudo continué insoluto.<br><br>';

                            $htmlPDF.='El suscriptor y los avales, aceptan que en caso de controversia judicial, independientemente del domicilio 
                                que tengan, se someterán a la Jurisdicción del XV Distrito Judicial en el Estado Con Residencia en los municipios de Gonzalez y Aldama Tamaulipas.<br><br>';
                            $htmlPDF.=' </span>';


                            if ($Sol['tipo']=='INDIVIDUAL'){
                                $htmlPDF.='El suscriptor acepta que mientras deba este contrato, no puede disponer, tratar o alguna promesa de compra-venta de la Garantia otorgada, hasta no liquidar dicho adeudo.<br>';

                                
                                    $htmlPDF .= '<table style="
                                    
                                    ">';
                                    
                                    $htmlPDF.='<tr>';
                                    $htmlPDF.='<td
                                    style="                                
                                        font-size:9pt; text-align:center;
                                    ">
                                    <br>Acepto los terminos:<br><br><br><br><br><br><br><br>___________________________________________________<br>
                                    '.$Cliente['nombre'].'<br>Firma y Huella:'.'</td>'; //1                            
                                    $htmlPDF.='</tr></table>';

                           



                            } else {
                                    $htmlPDF.='<span style="text-align:justify;font-size:11pt">';
                                    $htmlPDF.='El Grupo <b>'.GrupoName($Cliente['IdGrupo']).'</b> acepta los terminos de este pagare para su cumplimiento:<br><br>';
                                    $htmlPDF.='</span>';
                                    $htmlPDF.= '<table style="
                                        border:1px solid #e8e7e3;
                                        font-size:8pt;
                                    ">';
                                    $htmlPDF.='<tr>';

                                    // $htmlPDF.='<td
                                    // style="
                                    //     background-color:#bfc9ca; border: 1px solid #cfcdc6;
                                    //     font-size:8pt; text-align:center;
                                    //     width:5%;
                                    // ">
                                    // No.'.'</td>'; //1                            

                                    $htmlPDF.='<td
                                    style="
                                        background-color:#bfc9ca; border: 1px solid #cfcdc6;
                                        font-size:8pt; text-align:center;
                                        width:35%;
                                    ">
                                    Integrante'.'</td>'; //1                            

                                    $htmlPDF.='<td
                                    style="
                                        background-color:#bfc9ca; border: 1px solid #cfcdc6;
                                        font-size:8pt; text-align:center; with:50%;
                                    ">
                                    Domicilio/Telefono.'.'</td>'; //1                            

                                    $htmlPDF.='<td
                                    style="
                                        background-color:#bfc9ca; border: 1px solid #cfcdc6;
                                        font-size:8pt; text-align:center; width:35%;
                                    ">
                                    Firma'.'</td></tr>'; //1                            

                                    $sqlg="select * from clientes where IdGrupo='".$Cliente['IdGrupo']."' ";
                                    $rg = $db1->query($sqlg);    
                                    $n=1;
                                    $Presidente = "";
                                    $Secretario = "";
                                    $Tesorero="";
                                    $Resto = "";
                                    if ($db1->query($sqlg) == TRUE){
                                        while($G= $rg -> fetch_array()) {  
                                            if ($G['grupo_cargo']=='PRESIDENTE'){
                                                $Presidente.='<tr>';                                    
                                                // $Presidente.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.$n.'</td>';
                                                $Presidente.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.$G['nombre'].'<br><b>'.$G['grupo_cargo'].'</b></td>';
                                                $Presidente.='<td style="text-align:left; border: 1px solid #cfcdc6; font-size:7pt;">'.$G['domicilio'].', '.$G['municipio'].'. '.$G['estado'].' / Tel.'.$G['telefono'].'</td>';
                                                $Presidente.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.''.'</td>';
                                                $Presidente.='</tr>';
                                            } else {
                                                if ($G['grupo_cargo']=='SECRETARIO'){
                                                    $Secretario.='<tr>';                                    
                                                    // $Secretario.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.$n.'</td>';
                                                    $Secretario.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.$G['nombre'].'<br><b>'.$G['grupo_cargo'].'</b></td>';
                                                    $Secretario.='<td style="text-align:left; border: 1px solid #cfcdc6; font-size:7pt;">'.$G['domicilio'].', '.$G['municipio'].'. '.$G['estado'].' / Tel.'.$G['telefono'].'</td>';
                                                    $Secretario.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.''.'</td>';
                                                    $Secretario.='</tr>';

                                                } else {
                                                    if ($G['grupo_cargo']=='TESORERO'){
                                                        $Tesorero.='<tr>';                                    
                                                        // $Tesorero.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.$n.'</td>';
                                                        $Tesorero.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.$G['nombre'].'<br><b>'.$G['grupo_cargo'].'</b></td>';
                                                        $Tesorero.='<td style="text-align:left; border: 1px solid #cfcdc6; font-size:7pt;">'.$G['domicilio'].', '.$G['municipio'].'. '.$G['estado'].' / Tel.'.$G['telefono'].'</td>';
                                                        $Tesorero.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.''.'</td>';
                                                        $Tesorero.='</tr>';
                                                    } else {
                                                        $Resto.='<tr>';                                    
                                                        // $Resto.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.$n.'</td>';
                                                        $Resto.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.$G['nombre'].'<br><b>'.$G['grupo_cargo'].'</b></td>';
                                                        $Resto.='<td style="text-align:left; border: 1px solid #cfcdc6; font-size:7pt;">'.$G['domicilio'].', '.$G['municipio'].'. '.$G['estado'].' / Tel.'.$G['telefono'].'</td>';
                                                        $Resto.='<td style="text-align:left; border: 1px solid #cfcdc6;">'.''.'</td>';
                                                        $Resto.='</tr>';
                                                    }
                                                }

                                            }

                                            $n = $n + 1;



                                        }
                                        $htmlPDF.=$Presidente.$Secretario.$Tesorero.$Resto;
                                    } else {
                                        $htmlPDF.='<tr>';                                    
                                        $htmlPDF.='<td style="text-align:left; border: 1px solid #e8e7e3;" colspan=4>'.'No encontro informacion de este grupo'.'</td>';
                                        $htmlPDF.='</tr>';


                                    }
                                    unset($sqlg, $n, $G, $rg);

                                    

                                    
                                    $htmlPDF.='</table>';

                                   
                                   
                           

                            }
                            $htmlPDF.='<span style="text-align:justify;font-size:11pt">';
                            $htmlPDF.='<br><br>Créditos sujetos a aprobación por CRECE Y MAS S.A. de C.V., misma que NO requiere autorización de la Secretaria de Hacienda y Crédito Publico, para la realización de operaciones de crédito, y no está sujeta a la supervisión y vigilancia de la Comisión Nacional Bancaria y de Valores.';
                            $htmlPDF.='</span>';    


                            include("_print_footer.php");

                        } else {echo "ERROR: Cliente no encontrado";}
                    } else {echo "ERROR: Informacion de Cliente no disponible";}
                } else { echo "ERROR; Sin Informacion";}
            }else { echo "ERROR; Sin Informacion bd";}  
    }else { echo "ERROR; Parametros incompletos";}
} else { echo "ERROR; Parametros no definidos";}

unset($sql, $sql1, $r, $r2, $Sol, $Cliente);

?>