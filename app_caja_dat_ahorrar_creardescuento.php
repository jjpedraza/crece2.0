<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");


$IdSucursal = UserIdSucursal($RinteraUser);
$NoSol = VarClean($_POST['NoSol']);
$CantidadAhorro_retirar = VarClean($_POST['CantidadAhorro_retirar']);            
$MiAhorro = NoSol_Ahorro($NoSol);
if ($CantidadAhorro_retirar > $MiAhorro){
    Toast("Intenta con una cantidad menor o igual que tu Ahorro ".$MiAhorro,2,"");
} else {
$DescuentoBridge = $CantidadAhorro_retirar;

    $sqlPagos = "select * from cartera where nosol='".$NoSol."' and TOTAL>0 order by NPago ASC";
    $rPagos= $db1 -> query($sqlPagos);
    $Descuento = 0;
    while($Pago = $rPagos -> fetch_array()) {                
        if ($DescuentoBridge >= $Pago['TOTAL']){
            $Descuento = $Pago['TOTAL'];

            if (Ahorro_retiro($NoSol, $Pago['NPago'], $Descuento, "T. Ahorro->Descuento", $IdSucursal)==TRUE){
                if (Descuento_crear($NoSol, $Pago['NPago'], $Descuento, "Descuento desde Ahorro")==TRUE){

                }else {
                    Toast("Hubo un problema al crear el Descuento",2,"");
                }
            }
            $DescuentoBridge = $DescuentoBridge - $Pago['TOTAL'];

        } else {
            if ($DescuentoBridge > 0){
                $Descuento = $DescuentoBridge;
                if (Ahorro_retiro($NoSol, $Pago['NPago'], $Descuento, "T. Ahorro->Descuento", $IdSucursal)==TRUE){
                    if (Descuento_crear($NoSol, $Pago['NPago'], $Descuento, "Descuento desde Ahorro")==TRUE){
    
                    } else {
                        Toast("Hubo un problema al crear el Descuento",2,"");
                    }
                }
                $DescuentoBridge = 0;
            }
            
        }

    }
    echo "<script>CargaContrato(0);</script>";
}
?>

<?php
// include("footer.php");
?>