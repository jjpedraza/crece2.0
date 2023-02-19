<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$IdSucursal = UserIdSucursal($RinteraUser);

if (isset($_POST['NoSol'])) {
    $NoSol = VarClean($_POST['NoSol']);
    
        if (isset($_POST['CantidadAhorro_retirar'])){
            $CantidadAhorro_retirar = VarClean($_POST['CantidadAhorro_retirar']);
            if ($CantidadAhorro_retirar >= 0){
                $MiAhorro = NoSol_Ahorro($NoSol);
                if ($CantidadAhorro_retirar > $MiAhorro) {
                    Toast("La cantidad solicitada ".$CantidadAhorro_retirar." es mayor que el su ahorro ".$MiAhorro,3,"");

                } else {
                        //GUARDAMOS    
                    $IdCorte = IdCorte();
                    $sqlIn = "INSERT INTO corte (id, fecha, usuario, nosol, ahorro_retiro, IdSucursal ) 
                    VALUES ('".$IdCorte."','".$fecha."', '".$RinteraUser."', '".$NoSol."', '".$CantidadAhorro_retirar."','".$IdSucursal."')";           
                    // echo $sqlIn;
                    $OK = FALSE;
                    if ($db1->query($sqlIn) == TRUE)
                        {
                            $OK = TRUE;
                            Toast("retiro Guardado Correctamente ",4,"");
                            Toast("<a   target=_blank href=print_ticket.php?id=".$IdCorte.">Imprimir Ticket ".$IdCorte."</a>",5,"");
                            Historia($RinteraUser, "CAJA", "Inserto Retiro de Ahorro ".$NoSol." por ".$CantidadAhorro."  SQL = ".addslashes($sqlIn));
                            echo "<script>AhorroDiv();</script>";

                        }
                    else { $OK =  FALSE;
                        Toast("Problema al Guardar ",2,"");
                    
                    }
                    unset($sqlIn);
                }
                
            } else {
                Toast("La cantidad para retirar tiene que se mayor que cero",4,"");
            }

            
        } else {
            Toast("Parametro incorrecto cantidad para ahorrar",0,"");
        }

} else {
    Toast("Parametro incorrecto nosol",0,"");
}
 


?>

<?php
// include("footer.php");
?>