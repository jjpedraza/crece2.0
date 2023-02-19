<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$IdSucursal = UserIdSucursal($RinteraUser);
if (isset($_POST['NoSol'])) {
    $NoSol = VarClean($_POST['NoSol']);
    if (NoSol_existe($NoSol)==TRUE){
    
        if (isset($_POST['CantidadAhorro'])){
            $CantidadAhorro = VarClean($_POST['CantidadAhorro']);
            if ($CantidadAhorro >= 0){
                        //GUARDAMOS    
                    $IdCorte = IdCorte();
                    $sqlIn = "INSERT INTO corte (id, fecha, usuario, nosol, ahorro, IdSucursal ) 
                    VALUES ('".$IdCorte."','".$fecha."', '".$RinteraUser."', '".$NoSol."', '".$CantidadAhorro."','".$IdSucursal."')";           
                    // echo $sqlIn;
                    $OK = FALSE;
                    if ($db1->query($sqlIn) == TRUE)
                        {
                            $OK = TRUE;
                            Toast("Ahorro Guardado Correctamente ",4,"");
                            Toast("<a   target=_blank href=print_ticket.php?id=".$IdCorte.">Imprimir Ticket ".$IdCorte."</a>",5,"");
                            Historia($RinteraUser, "CAJA", "Inserto Ahorro ".$NoSol." por ".$CantidadAhorro."  SQL = ".addslashes($sqlIn));
                            echo "<script>CargaContrato(0);</script>";

                        }
                    else { $OK =  FALSE;
                        Toast("Problema al Guardar ",2,"");
                    
                    }
                    unset($sqlIn);
                
            } else {
                Toast("La cantidad para ahorrar tiene que se mayor que cero",4,"");
            }
        
            
        } else {
            Toast("Parametro incorrecto cantidad para ahorrar",0,"");
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