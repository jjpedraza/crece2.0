<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");
$OK = FALSE; $Valor = 0; $Ticket = "";
$NoSol = VarClean($_POST['NoSol']);
$CantidadRecibida = VarClean($_POST['recibe']);
$CantidadRecibida_calculada = $CantidadRecibida;
$PagosQueDebe = NDebe($NoSol);

$IdSucursal = UserIdSucursal($RinteraUser);
if ($PagosQueDebe<= 0){
    Toast("El Contrato ".$NoSol." no debe ningun pago",2,"");
} else {
    
    echo "<h4>Distribucion de la Cantidad Recibida:  ".$CantidadRecibida."</h4>";
    
        $sql = "select * from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' order by NPago + 0";
        $r= $db1 -> query($sql);        
        $Curp = "";
        $GranTotal = 0;
        $Reparto_Moratorios = 0;
        $Reparto_CargoSemanal = 0;
        $Reparto_Extras = 0;
        $Reparto_Financiamiento = 0;
        $Reparto_Impuestos = 0;
        $Reparto_Capital = 0;
        $Reparto_Seguro = 0;
        echo '<table class="tabla">';
        echo "<th>No</th>";
        echo "<th>Moratorios</th>";
        echo "<th>Cargo Semanal</th>";
        echo "<th>Extraordinarios</th>";
        echo "<th>Financiamiento</th>";
        echo "<th>IVA</th>";
        echo "<th>Capital</th>";
        echo "<th>Seguro</th>";
        echo "<th>Restante</th>";
        
        $Deuda = 0; $GTotal = 0; $GranTotal = 0;
        while($Sol = $r -> fetch_array()) {    
            
            //REPARTIMOS LA CANTIDAD RECIBIDA
            if ($CantidadRecibida_calculada > 0){
                $CantidadRecibida_calculada = $CantidadRecibida_calculada  + $Sol['Descuento_cantidad'];    

                $Deuda = $Sol['mora_debe']; $CantidadRecibida_calculada = $CantidadRecibida_calculada -  $Deuda;         
                if ($CantidadRecibida_calculada >= 0 ){$Reparto_Moratorios = $Deuda;} 
                else {$Reparto_Moratorios = $CantidadRecibida_calculada + $Deuda;}

                if ($CantidadRecibida_calculada>0){
                $Deuda = $Sol['CargoSemanal']; $CantidadRecibida_calculada = $CantidadRecibida_calculada -  $Deuda;         
                if ($CantidadRecibida_calculada >= 0 ){$Reparto_CargoSemanal = $Deuda;} 
                else {$Reparto_CargoSemanal = $CantidadRecibida_calculada + $Deuda;}
                }

                if ($CantidadRecibida_calculada>0){
                $Deuda = $Sol['CargoExtraOrdinario_cantidad']; $CantidadRecibida_calculada = $CantidadRecibida_calculada -  $Deuda;         
                if ($CantidadRecibida_calculada >= 0 ){$Reparto_Extras = $Deuda;} 
                else {$Reparto_Extras = $CantidadRecibida_calculada + $Deuda;}
                }

                if ($CantidadRecibida_calculada>0){
                $Deuda = $Sol['interes']; $CantidadRecibida_calculada = $CantidadRecibida_calculada -  $Deuda;         
                if ($CantidadRecibida_calculada >= 0 ){$Reparto_Financiamiento = $Deuda;} 
                else {$Reparto_Financiamiento = $CantidadRecibida_calculada + $Deuda;}
                }

                if ($CantidadRecibida_calculada>0){
                $Deuda = $Sol['iva']; $CantidadRecibida_calculada = $CantidadRecibida_calculada -  $Deuda;         
                if ($CantidadRecibida_calculada >= 0 ){$Reparto_Impuestos = $Deuda;} 
                else {$Reparto_Impuestos = $CantidadRecibida_calculada + $Deuda;}
                }

                if ($CantidadRecibida_calculada>0){
                    $Deuda = $Sol['abono']; $CantidadRecibida_calculada = $CantidadRecibida_calculada -  $Deuda;         
                    if ($CantidadRecibida_calculada >= 0 ){$Reparto_Capital = $Deuda;} 
                    else {$Reparto_Capital = $CantidadRecibida_calculada + $Deuda;}
                }

                if ($CantidadRecibida_calculada>0){
                    $Deuda = $Sol['cargoseguro']; $CantidadRecibida_calculada = $CantidadRecibida_calculada -  $Deuda;         
                    if ($CantidadRecibida_calculada >= 0 ){$Reparto_Seguro = $Deuda;} 
                    else {$Reparto_Seguro = $CantidadRecibida_calculada + $Deuda;}
                    }

                $GranTotal = $GranTotal + floatval($Sol['TOTAL']);
                
                $Valor = $Reparto_Capital +  $Reparto_CargoSemanal + $Reparto_Extras + $Reparto_Financiamiento + $Reparto_Impuestos + $Reparto_Moratorios + $Reparto_Seguro;
            //GUARDAMOS    
            $IdCorte = IdCorte();
            $sqlIn = "INSERT INTO corte (id, fecha, usuario, nosol, no, valor, moratorio, cargosemanal, extras, interes, impuesto, capital, cargoseguro, IdSucursal ) 
            VALUES ('".$IdCorte."','".$fecha."', '".$RinteraUser."', '".$NoSol."', '".$Sol['NPago']."', '".$Valor."', '".$Reparto_Moratorios.
            "','".$Reparto_CargoSemanal."', '".$Reparto_Extras."', '".$Reparto_Financiamiento."', '".$Reparto_Impuestos."','".$Reparto_Capital."','".$Reparto_Seguro."','".$IdSucursal."')";                    
            // echo $sqlIn;
            $OK = FALSE;

            if ($db1->query($sqlIn) == TRUE)
                {
                    $OK = TRUE;
                    Toast("Guardado Correctamente ",4,"");
                    Historia($RinteraUser, "CAJA", "Inserto Pago ".$Sol['NPago']." por ".$CantidadRecibida."  SQL = ".addslashes($sqlIn));
                    
            
                    $Ticket.= "<a target=_blank class='btn btn-primary' href='print_ticket.php?id=".$IdCorte."'>Ticket ".$IdCorte."</a> ";
                    
                    

                    if (
                        $Reparto_Capital == $Sol['abono'] and
                        $Reparto_Financiamiento == $Sol['interes'] and
                        $Reparto_Impuestos == $Sol['iva'] and
                        $Reparto_Extras == $Sol['CargoExtraOrdinario_cantidad'] and
                        $Reparto_CargoSemanal == $Sol['CargoSemanal'] and
                        $Reparto_Moratorios == $Sol['mora_debe'] and
                        $Reparto_Seguro == $Sol['cargoseguro']
                    ){//PAGO COMPLETADO
                        $sqlPago = "UPDATE tabladepagos SET
                        estado='X'
                        WHERE nosol='".$NoSol."' and no ='".$Sol['NPago']."'
                        ";
                        if ($db1->query($sqlPago) == TRUE){
                            Toast("Se ha liquidado correctamente el pago No. ".$Sol['NPago'],4,"");
                            Historia($RinteraUser, "CAJA", "Liquido el Pago ".$Sol['NPago']." por ".$CantidadRecibida."  SQL = ".addslashes($sqlIn));
                        } else {
                            Toast("Error al marcar como pagado en Pago No.".$Sol['NPago'],2,"");
                        }
                        unset($sqlPago);

                    } else {
                        Toast("El pago ".$Sol['NPago']." no se cubrio por completo",0,"");
                        // echo "No. de Pago ".$Sol['NPago'].": <br>";
                        // echo "Reparto_Moratorios $Reparto_Moratorios = ".$Sol['mora_debe']."<br>";
                        // echo "Reparto_CargoSemanal $Reparto_CargoSemanal = ".$Sol['CargoSemanal']."<br>";
                        // echo "Reparto_Extras $Reparto_Extras = ".$Sol['CargoExtraOrdinario_cantidad']."<br>";
                        // echo "Reparto_Financiamiento $Reparto_Financiamiento = ".$Sol['interes']."<br>";
                        // echo "Reparto_Impuestos $Reparto_Impuestos = ".$Sol['iva']."<br>";
                        // echo "Reparto_Capital $Reparto_Capital = ".$Sol['abono']."<br>";
                        // echo "CantidadRecibida_calculada =  $CantidadRecibida_calculada  "."<hr><br>";
                        
                        
                    }
                    // echo "
                    // <script>

                    
                    //     CargaContrato(0);
                    // </script>";

                }
            else { $OK =  FALSE;
                Toast("Problema al Guardar ",2,"");
            
            }
            unset($sqlIn);
            
            if ($CantidadRecibida_calculada < 0) {$CantidadRecibida_calculada = 0;}
            echo '<tr style="border-top: 2px solid #3295ff;">';
            echo '<td rowspan="2" style="
            background-color: #007bff;
            color: white;
            padding: 5px;
            font-size: 12pt; font-weight:bold;
            ">';
            if ($OK == TRUE){
                echo $Sol['NPago']."<img src='iconos/ok.png' style='width:23px;'>";
            } else {
                echo $Sol['NPago'];
            }
            
            echo '</td>';
                echo '<td style="background-color:#daf0da;"><b>'.Pesos($Sol['mora_debe']).'</b></td>';
                echo '<td style="background-color:#daf0da;"><b>'.Pesos($Sol['CargoSemanal']).'</b></td>';
                echo '<td style="background-color:#daf0da;"><b>'.$Sol['CargoExtraOrdinario_concepto'].' '.Pesos($Sol['CargoExtraOrdinario_cantidad']).'</b></td>';
                echo '<td style="background-color:#daf0da;"><b>'.Pesos($Sol['interes']).'</b></td>';
                echo '<td style="background-color:#daf0da;"><b>'.Pesos($Sol['iva']).'</b></td>';
                echo '<td style="background-color:#daf0da;"><b>'.Pesos($Sol['abono']).'</b></td>';
                echo '<td style="background-color:#daf0da;"><b>'.Pesos($Sol['cargoseguro']).'</b></td>';
                if ($Sol['Descuento_cantidad']>0){
                    echo '<td style="background-color:#daf0da;"><b>'.Pesos($Sol['TOTAL']).'</b><a rel=MyModal:open  href="#Descuento_'.$Sol['NPago'].'"><img src="iconos/alerta.png" style="width:13px; cursor:pointer;"></a></td>';
                    echo "<div class='MyModal' id='Descuento_".$Sol['NPago']."'>";
                    echo "Este Pago No. (".$Sol['NPago'].") ha sido beneficiado con un descuento por ".$Sol['Descuento_concepto']." de ".Pesos($Sol['Descuento_cantidad'])."";
                    echo "</div>";
                } else {
                    echo '<td style="background-color:#daf0da;"><b>'.Pesos($Sol['TOTAL']).'</b></td>';
                }
                
            echo '</tr>';
            
            echo '<tr>';
            // echo '<td >'.$Sol['NPago'].'</td>';
                if ($Reparto_Moratorios>0) {echo '<td style="background-color:#3ddd5c;">'.Pesos($Reparto_Moratorios).'</td>';} else {
                    echo '<td>'.Pesos($Reparto_Moratorios).'</td>';
                }
                if ($Reparto_CargoSemanal>0){echo '<td style="background-color:#3ddd5c;">'.Pesos($Reparto_CargoSemanal).'</td>';} else{
                    echo '<td>'.Pesos($Reparto_CargoSemanal);
                }
                if ($Reparto_Extras == $Sol['CargoExtraOrdinario_cantidad']) {
                    if ($Sol['CargoExtraOrdinario_cantidad']==0){
                        echo '<td style="background-color:#3ddd5c;">'.Pesos($Reparto_Extras).' '.'</td>';
                        
                    } else {
                        echo '<td>'.Pesos($Reparto_Extras).' '.'</td>';    
                        
                    }
                } else {
                    if ($Reparto_Extras>0){
                        echo '<td style="background-color:#3ddd5c;">'.Pesos($Reparto_Extras).' '.'</td>';
                    } else {
                        echo '<td>'.Pesos($Reparto_Extras).' '.'</td>';    
                    }
                }
                
                if ($Reparto_Financiamiento>0) { echo '<td style="background-color:#3ddd5c;">'.Pesos($Reparto_Financiamiento).'</td>';} else {
                    echo '<td>'.Pesos($Reparto_Financiamiento).'</td>';
                }
                
                if ($Reparto_Impuestos>0) { echo '<td style="background-color:#3ddd5c;">'.Pesos($Reparto_Impuestos).'</td>';} else {
                    echo '<td>'.Pesos($Reparto_Impuestos).'</td>';
                }
                
                if ($Reparto_Capital>0) {echo '<td style="background-color:#3ddd5c;">'.Pesos($Reparto_Capital).'</td>';} else {
                    echo '<td>'.Pesos($Reparto_Capital).'</td>';
                }

                if ($Reparto_Seguro>0) {echo '<td style="background-color:#3ddd5c;">'.Pesos($Reparto_Seguro).'</td>';} else {
                    echo '<td>'.Pesos($Reparto_Seguro).'</td>';
                }
                $GTotal =  floatval($Sol['TOTAL']) - floatval($CantidadRecibida - $CantidadRecibida_calculada);
                if ($GTotal<0) {$GTotal = 0;}
                if ($GTotal>0) {echo '<td style="background-color:#007bff; color:white;">'.Pesos($GTotal).'</td>';}else {
                    echo '<td>'.Pesos($GTotal).'</td>';
                }
                
            echo '</tr>';
            } else {//Se acabo la cantidad recibida //Si sobra; Podemos seguir repartiendo al pago Siguiente:
                // break;
            }

            $Reparto_Moratorios = 0;
            $Reparto_CargoSemanal = 0;
            $Reparto_Extras = 0;
            $Reparto_Financiamiento = 0;
            $Reparto_Capital = 0;
            $Reparto_Seguro = 0;
            $GranTotal = 0;
            

        }
        echo '</table>';
        unset($r,$sql, $Sol);

        // echo "<script>CajaComponents(0);</script>";

        // echo "Deuda TOTAL = ".Pesos($GranTotal),"<br>";
        // $Feria = $CantidadRecibida - $GranTotal;
        // if ($Feria < 0) {
        //     // $Feria = $Feria + $Feria + $Feria;
        //     echo "Te Faltaron  ".Pesos($Feria)." para Liquidar.<br>";
        // } else {
        //     echo "Feria = ".Pesos($Feria)."<br>";
        // }
        


        echo "<br>";
        if ($OK == TRUE){
            //Ticket y Recibo de Pago
            echo $Ticket ;
            
            // echo "<a target=_blank class='btn btn-primary' href='print_recibo.php?id=".$IdCorte."'>Recibo</a>";
            

        } else{
            echo "<button class='btn btn-success' onclick='Pagar();'>PAGAR</button>";
        }
        // TicketsHoy($NoSol);
}
?>

<?php
// include("footer.php");
?>