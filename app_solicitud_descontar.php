<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

if (isset($_POST['NoSol'])) {
    $NoSol = VarClean($_POST['NoSol']);
    if (NoSol_existe($NoSol)==TRUE){
    
        if (isset($_POST['DescuentoCantidad'])){
            $DescuentoCantidad = VarClean($_POST['DescuentoCantidad']);
            $NPago = VarClean($_POST['NPago']);
            $Debe = DebePago($NoSol,$NPago);
            $DescuentoConcepto = VarClean($_POST['DescuentoConcepto']);
            if ($DescuentoCantidad < $Debe) {
                            if ($DescuentoCantidad > 0){
                                        //GUARDAMOS    
                                    $IdCorte = IdCorte();
                                    $sqlIn = "INSERT INTO descuetos (nosol, no, cantidad, act_user, act_fecha, act_hora, concepto) 
                                    VALUES ('".$NoSol."','".$NPago."', '".$DescuentoCantidad."', '".$RinteraUser."', '".$fecha."','".$hora."','".$DescuentoConcepto."')";           
                                    // echo $sqlIn;
                                    $OK = FALSE;
                                    if ($db1->query($sqlIn) == TRUE)
                                        {
                                            $OK = TRUE;
                                            Toast("Descuento Guardado Correctamente ",4,"");
                                            echo "<script>CargaDescuentos();</script>";
                                            // Toast("<a   target=_blank href=print_ticket.php?id=".$IdCorte.">Imprimir Ticket ".$IdCorte."</a>",5,"");
                                            Historia($RinteraUser, "CAJA", "Inserto Descuento ".$NoSol." por ".$DescuentoCantidad." al pago no ".$NPago." por ".$DescuentoConcepto." SQL = ".addslashes($sqlIn));
                                            

                                        }
                                    else { $OK =  FALSE;
                                        Toast("Problema al Guardar ",2,"");
                                    
                                    }
                                    unset($sqlIn);
                                
                            } else {
                                Toast("La cantidad para descontar tiene que se mayor que cero",2,"");
                            }
            } else {
                Toast("La Cantidad (".$DescuentoCantidad.") a descontar debe ser menor a lo que se debe del pago (".$Debe.", NPago=".$NPago.")",2,"");
            }
            
            
        
            
        } else {
            Toast("Parametro incorrecto cantidad para descontar",0,"");
        }
    } else {
        Toast("".$NoSol." no valido",2,"");
    }
} else {
    Toast("Parametro incorrecto nosol",0,"");
}
 


?>

<?php
// include("footer.php");
?>