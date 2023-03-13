<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");

if (isset($_GET['id'])){
    $NoSol = VarClean($_GET['id']);

    if ($NoSol <> ''){
        Historia($RinteraUser, "PRINT", "Descargo la solicitud NoSol=".$NoSol."");
        $sql = "select * from solicitudes where nosol='".$NoSol."'
        AND COALESCE(valoracion, '') <> ''
        AND fechacontrato IS NOT NULL
        AND fechainicio IS NOT NULL
        AND COALESCE(cantidad, 0) <> 0
        AND plazo IS NOT NULL
        AND formadepago IS NOT NULL
        AND COALESCE(tasa_interes, 0) <> 0
        AND COALESCE(cargoporsemana, 0) <> 0;
        ";
        $r = $db1->query($sql);        
            if ($db1->query($sql) == TRUE){
                if($Sol = $r -> fetch_array()) {

                    $sql2 = "select * from clientes where curp='".$Sol['curp']."'";
                    $r2 = $db1->query($sql2);        
                    if ($db1->query($sql) == TRUE){
                        if($Cliente = $r2 -> fetch_array()) {                
                            //Generar PDF
                            $PDFTitulo="SOLICITUD DE PRESTAMO";
                            $PDFSubTitulo="No. ".$NoSol." - ".$Sol['fechasol'];
                            $PDFSubTitulo2=$Sol['Cliente'];
                            include("_print_head.php");


                            if ($Sol['valoracion']=='APROBADO'){$Aprobado=TRUE;} else {$Aprobado=FALSE;}
                            
                            $htmlPDF = '<table style="
                                border:1px solid gray;
                                font-size:8pt;

                            ">';

                            

                            $htmlPDF.='<tr>';
                            $htmlPDF.='<td colspan="2"
                            style="
                                background-color:#bfc9ca; 
                                font-size:8pt; text-align:center;
                            ">
                            Informacion personal del solicitante:'.'</td>'; //1                            
                            $htmlPDF.='</tr>';

                            $htmlPDF.='<tr>';                            
                                $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';

                            $htmlPDF.='<b>CURP</b>:'.$Cliente['curp'].'<br>';
                            $htmlPDF.='<b>Domicilio</b>:'.$Cliente['domicilio'].', '.$Cliente['municipio'].'. '.$Cliente['estado'].'<br>';
                            $htmlPDF.='<b>Telefono</b>:'.$Cliente['telefono'].'<br>';
                            $htmlPDF.='<b>Fecha de Nacimiento</b>:'.$Cliente['fechadenacimiento'].'<br>';
                            $htmlPDF.='<b>Estado Civil</b>:'.$Cliente['estadocivil'].'<br>';
                            $htmlPDF.='<b>Estudios</b>:'.$Cliente['estudios'].'<br>';
                            $htmlPDF.='<b>Sexo</b>:'.$Cliente['sexo'].'<br>';
                            $htmlPDF.='<b>Correo electronico</b>:'.$Cliente['correo'].'<br>';
                            $htmlPDF.='<b>IFE</b>:'.$Cliente['IFE'].'<br>';


                            $htmlPDF.='</td>';

                                
                            $htmlPDF.='<td style="
                                    
                                    text-align:center; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">Fotografia:<br>';
                            $htmlPDF.="<table id='t2'><tr><td></td><td width=20%>";
                            $FileFoto ='fotos/'.$Cliente['curp'].".jpg";            
                            $NoFoto ='iconos/nofoto.jpg';            
                            if (file_exists($FileFoto)){
                                $htmlPDF.='<img src="'.$FileFoto.'">';
                            } else {
                                $htmlPDF.='<img src="'.$NoFoto.'" style="width:50px">';
                            }
                            $htmlPDF.="</td></tr></table>";
                            $htmlPDF.='</td>';
                            $htmlPDF.='</tr>';
                            



                            $htmlPDF.='<tr>';
                            $htmlPDF.='<td colspan="2"
                            style="
                                background-color:#bfc9ca; 
                                font-size:8pt; text-align:center;
                            ">
                            Informacion laboral:'.'</td>'; //1                            
                            $htmlPDF.='</tr>';
                            
                            $htmlPDF.='<tr>';                            
                                $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';

                            $htmlPDF.='<b>INGRESOS:</b><br><b>Trabaja actualmente en:</b>:'.$Cliente['trabajo_nombre'].'<br>';
                            $htmlPDF.='<b>Puesto</b>:'.$Cliente['trabajo_puesto'].' '.$Cliente['trabajo_giro'].'<br>';
                            $htmlPDF.='<b>Salario Mensual</b>:'.Pesos($Cliente['trabajo_salario']).'<br>';
                            $htmlPDF.='<b>Telefono (Trabajo)</b>:'.$Cliente['trabajo_telefono'].'<br>';
                            $htmlPDF.='<b>Domicilio del trabajo:</b>:'.$Cliente['trabajo_domicilio'].'<hr>';

                            $htmlPDF.='<b>Mi Negocio</b>:'.$Cliente['minegocio_giro'].' '.$Cliente['minegocio_nombre'].'<br>';
                            $htmlPDF.='<b>Mi Negocio, Propio?:</b>:'.$Cliente['minegocio_propio'].'<br>';
                            $htmlPDF.='<b>Mi Negocio Ingresos:</b>:'.Pesos($Cliente['minegocio_ingresos']).'<br>';
                            $htmlPDF.='<b>Mi Negocio Telefono:</b>:'.$Cliente['minegocio_telefono'].'<br>';

                            

                            $htmlPDF.='</td>';

                                
                            $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';
                            $htmlPDF.='<b>GASTOS:</b><br><b>Hogas:</b>:'.Pesos($Cliente['socio_hogar']).'<br>';
                            $htmlPDF.='<b>Luz</b>:'.Pesos($Cliente['socio_agualuz']).'<br>';                            
                            $htmlPDF.='<b>Agua y Drenaje</b>:'.Pesos($Cliente['socio_drenaje']).'<br>';                            
                            $htmlPDF.='<b>Renta</b>:'.Pesos($Cliente['socio_renta']).'<hr>';

                            $htmlPDF.='<b>Casa Propia?</b>:'.$Cliente['socio_casapropia'].'<br>';
                            $htmlPDF.='<b>Dependientes:</b>:'.$Cliente['socio_dependen'].'<br>';
                            $htmlPDF.='<b>hijos:</b>:'.$Cliente['socio_hijos'].'<br>';

                            $Ingresos = $Cliente['trabajo_salario'] + $Cliente['minegocio_ingresos'];
                            $Gastos = $Cliente['socio_hogar'] + $Cliente['socio_renta'] + $Cliente['socio_agualuz'] + $Cliente['socio_drenaje'];
                            $RecursoDisponible = $Ingresos -  $Gastos;

                            

                            
                            $htmlPDF.='</td>';
                            $htmlPDF.='</tr>';
                            
                                                        $htmlPDF.='<tr>';
                            $htmlPDF.='<td colspan="2"
                            style="
                                background-color:#e3e2de; 
                                font-size:8pt; text-align:center;

                            ">
                            ';
                            $htmlPDF.='';
                            $htmlPDF.='<b>Ingreso disponible  </b>=  <b style="color:green;"> INGRESOS </b>('.Pesos($Ingresos).') - <b 
                            style="color:red;"> GASTOS</b> ('.Pesos($Gastos).') = <b style="color:blue;">'.Pesos($RecursoDisponible).'</b>';
                            $htmlPDF.='</td></tr>';



                            $htmlPDF.='<tr>';
                            $htmlPDF.='<td colspan="2"
                            style="
                                background-color:#bfc9ca; 
                                font-size:8pt; text-align:center;
                            ">
                            REFERENCIAS:'.'</td>'; //1                            
                            $htmlPDF.='</tr>';


                            $htmlPDF.='<tr>';

                            $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';

                            $htmlPDF.='<b>'.$Cliente['refc1_nombre'].'</b><br>';
                            $htmlPDF.='Telefono: <b>'.$Cliente['refc1_tel'].'</b><br>';
                            $htmlPDF.='Tiempo de conocerle: _'.$Cliente['refc1_antiguedad'].'_ años <br>';
                            $htmlPDF.='<b>Domicilio</b>: '.$Cliente['refc1_domicilio'].'';

                            $htmlPDF.='</td>';


                            $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';
                            $htmlPDF.='<b>'.$Cliente['refc2_nombre'].'</b><br>';
                            $htmlPDF.='Telefono: <b>'.$Cliente['refc2_tel'].'</b><br>';
                            $htmlPDF.='Tiempo de conocerle: _'.$Cliente['refc2_antiguedad'].'_ años <br>';
                            $htmlPDF.='<b>Domicilio</b>: '.$Cliente['refc2_domicilio'].'';


                            $htmlPDF.='</td></tr>';




                             $htmlPDF.='<tr>';
                            $htmlPDF.='<td colspan="2"
                            style="
                                background-color:#bfc9ca; 
                                font-size:8pt; text-align:center;
                            ">
                            OPERACION SOLICITADA:'.'</td>'; //1                            
                            $htmlPDF.='</tr>';


                            $htmlPDF.='<tr>';

                            $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';

                            $htmlPDF.='Cantidad: <b>'.Pesos($Sol['cantidad']).'</b><br>';
                            $htmlPDF.='Forma de Pago: <b>'.$Sol['formadepago'].' dias</b><br>';
                            $htmlPDF.='Plazo: <b> '.$Sol['plazo'].' meses</b> <br>';
                            $htmlPDF.='<b>Interes de Financiamiento:</b> '.$Sol['tasa_interes'].'% mensual<br>';
                            $htmlPDF.='<b>Interes Moratorio:</b> '.$Sol['tasa_moratorio'].'% mensual<br>';

                           $NPlazo = 0; $MultiploMensual = 0;
                           if ($Sol['formadepago']==7){$NPlazo=$Sol['plazo']*4; $MultiploMensual = 4;}
                           if ($Sol['formadepago']==15){$NPlazo=$Sol['plazo']*2; $MultiploMensual = 2;}
                           if ($Sol['formadepago']==30){$NPlazo=$Sol['plazo']*1; $MultiploMensual = 1;}
                            $Abono=$Sol['cantidad']/$NPlazo;

                            $Interes=(($Sol['cantidad']/100)*$Sol['tasa_interes'])*$Sol['plazo'];
                            $Interes=$Interes/$NPlazo; //se reparte entre el numero de letras de pago
                            $Impuestos = (($Abono  +  $Interes) /100) * $Sol['iva_tipo'];               
                            $AbonoLetra=$Abono+$Interes + $Impuestos;

                            $AbonoMensual = $AbonoLetra * $MultiploMensual;
                            
                            $htmlPDF.='<hr><b>'.$NPlazo.' pagos </b> de <b> '.Pesos($AbonoLetra).' </b>, es decir Mensualmente estaria pagando <b>'.Pesos($AbonoMensual).'</b>';

                            $htmlPDF.='</td>';


                            $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';
                            $htmlPDF.='Tipo de Credito: <b>'.$Sol['tipo'].'</b><br>';
                            if ($Sol['tipo']=='GRUPAL'){
                                $htmlPDF.='Grupo al que pertenece: <b>'.GrupoName($Cliente['IdGrupo']).' '.$Cliente['grupo_cargo'].'</b><br>';
                            }

                            $htmlPDF.='Garantia: <b>'.$Sol['garantia'].'</b><br>';
                            $htmlPDF.='<hr>Historial Crediticio:<br><span style="font-size:6pt;">';
                            $rH = $db1->query("select * from cartera_resumen where curp='".$Cliente['curp']."'");    
                            if ($db1->query("select * from cartera_resumen where curp='".$Cliente['curp']."'") == TRUE){
                                while($H= $rH -> fetch_array()) {  
                                    if ($H['nosol'] == $NoSol){
                                    $htmlPDF.='<b style="text-decoration:underline;">-'.$H['fechasol'].'-<b>'.$H['nosol'].'</b>('.$H['valoracion'].') '.Pesos($H['cantidad']).' Debe: '.$H['DebePagos'].' pagos, '.Pesos($H['Debe']).'</b><br>';
                                    } else {
                                        $htmlPDF.='-'.$H['fechasol'].'-<b>'.$H['nosol'].'</b>('.$H['valoracion'].') '.Pesos($H['cantidad']).' Debe: '.$H['DebePagos'].' pagos, '.Pesos($H['Debe']).'<br>';
                                    }
                                }
                            }
                            unset($rH, $H);
                            $htmlPDF.='</span>';

                            $htmlPDF.='</td></tr>';


                            $htmlPDF.='<tr>';
                            $htmlPDF.='<td colspan="2"
                            style="
                                background-color:#bfc9ca; 
                                font-size:8pt; text-align:center;
                            ">
                            AVAL:'.'</td>'; //1                            
                            $htmlPDF.='</tr>';


                            $htmlPDF.='<tr>';
                            $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';

                           //  $htmlPDF.='<b>Interes Moratorio:</b> '.$Sol['tasa_moratorio'].'% mensual<br>';
                            if ($Sol['aval_curp']==''){
                                $htmlPDF.='* Sin Aval';

                            } else {
                                $htmlPDF.='<b>Aval(1)'.$Sol['aval_nombre'].'</b><br>';
                                $htmlPDF.='<b>Curp</b>:'.$Sol['aval_curp'].'<br></td>';
                                $htmlPDF.='<td><b>Aval(2)'.$Sol['aval_nombre2'].'</b><br>';
                                $htmlPDF.='<b>Curp</b>:'.$Sol['aval_curp2'].'<br>
                                <br><br><br>';

                            }

                            $htmlPDF.='</td>';


                            $htmlPDF.='<td style="
                                    text-align:left; font-size:8pt;
                                    border: 0.5px solid gray;
                                ">';
                            
                            

                            $htmlPDF.='</td></tr>';




                            $htmlPDF.='<tr>';
                            $htmlPDF.='<td colspan="2"
                            style="
                                background-color:#bfc9ca; 
                                font-size:8pt; text-align:center;
                            ">
                            FIRMA:'.'</td>'; //1                            
                            $htmlPDF.='</tr>';


                            $htmlPDF.='<tr>';
                            $htmlPDF.='<td  colspan="2" style="
                                    text-align:center; font-size:8pt;
                                    border-right-width: 0.3px;
                                    border-right-style: dashed;
                                ">';

                           $htmlPDF.='<br><br><br><br>';
                        



                         
                           $htmlPDF.='____________________________________________<br>';
                           $htmlPDF.='Solicitante';                            

                            $htmlPDF.='</td></tr>';


                            $htmlPDF.='<tr>';
                            $htmlPDF.='<td colspan="2"
                            style="
                                background-color:white; 
                                font-size:5pt; text-align:center;
                                border: 1px solid gray;
                            ">
                                Declaro que: Los datos en la presente solicitud, parte integrante del contrato, son correctos y autorizo a CRECE Y MAS S.A. de C.V. a realizar las investigaciones y acciones que se consideren necesarias, a efecto de comprobar a travéz de cualquier tercero, dependencia u autoridad, la veracidad de los datos que le fueron proporcionados; de conformidad con el articulo 18 bis de la Ley para la Transparencia y Ordenamiento de los Servicio Financieros, fue hecho de mi conocimiento a mi entera satisfaccion, el contenido, alcance,terminos y condiciones de la presentesolicitud, queforma parte del Contrato, documentos con los que estoy de acuerdo y me adhiero a lo pactado en los mismos, procediendo en este ato a firmar la solicitud y aceptar el contrato registrado en terminos de las disposiciones legales aplicables la presene solicitud y se entendera por recibida y aceptada de mi parte al disponer del prestamo a traves de los medios de disposicion que CRECE Y MAS S.A. de C.V. tiene para tal efecto; Fuehecho de mi conocimiento que los recursos del prestamo solicitado en caso de que sea autorizado los destinare a fines licitos. '.'</td>'; //1                            
                            $htmlPDF.='</tr>';

                            



                            // $htmlPDF.='<tr>';
                            // $htmlPDF.='<td>1'.'</td>'; //1
                            // $htmlPDF.='<td>2'.'</td>'; //2
                            // $htmlPDF.='<td>3'.'</td>'; //3
                            // $htmlPDF.='<td>4'.'</td>'; //4
                            // $htmlPDF.='</tr>';
                            
                            $htmlPDF.='</table>';
                            



                            //Texto con coordenadas
                            // $pdf->SetFont('', 'B', 12, '', 'false'); $pdf->Text(48, 97, ''.'Palabra EXIS'); 

                            
                            
                            // echo $htmlPDF;

                            include("_print_footer.php");

                        } else {echo "ERROR: Cliente no encontrado";}
                    } else {echo "ERROR: Informacion de Cliente no disponible";}
                } else { 
                    echo "ERROR; Solicitud no disponible, Inexistente o le falta capturar informacion en:
                        los siguientes campos: <br>
                        - valoracion <br>
                        - fechacontrato <br>
                        - fechainicio <br>
                        - cantidad <br>
                        - plazo <br>
                        - formadepago <br>
                        - tasa_interes <br>
                        - cargoporsemana <br>
                        ";
                
                }
            }else { echo "ERROR; Solicitud no disponible, Inexistente o le falta capturar informacion en:
                los siguientes campos: <br>
                - valoracion <br>
                - fechacontrato <br>
                - fechainicio <br>
                - cantidad <br>
                - plazo <br>
                - formadepago <br>
                - tasa_interes <br>
                - cargoporsemana <br>
                ";}  
    }else { echo "ERROR; Parametros incompletos";}
} else { echo "ERROR; Parametros no definidos";}

unset($sql, $sql1, $r, $r2, $Sol, $Cliente);

?>