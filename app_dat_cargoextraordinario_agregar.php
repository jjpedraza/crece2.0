<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol = VarClean($_POST['NoSol']);
$NPago =VarClean($_POST['NPago']);
$Cargo_concepto = VarClean($_POST['Cargo_concepto']);
$Cargo_cantidad = VarClean($_POST['Cargo_cantidad']);
$DebeCargoExtraOrdinario = DebePago_cargoextraordinarios($NoSol,$NPago);

if (NoSol_existe($NoSol)==TRUE){
    
        Toast($Cargo_concepto." = ".$Cargo_cantidad,5,"");
        if ($Cargo_cantidad > 0){

            $Query="INSERT INTO extraordinarios (nosol, no, concepto, cantidad, fecha, act_user) VALUES (
                '".$NoSol."',
                '".$NPago."',
                '".$Cargo_concepto."',
                '".$Cargo_cantidad."',
                '".$fecha."',
                '".$RinteraUser."'
                
            )";            
            if ($db1->query($Query) == TRUE)
            {
                Toast("Cargo ".$Cargo_concepto." agregado correctamente",4,"");
                echo "<script>CargaContrato(0);</script>";
                echo "<script>
                $('.MyModal').hide();
                $('.jquery-MyModal').hide();
                
                </script>";
            }
            else {
                Toast("Error al guardar, intenlo nuevamente <br>".$Query,2,"");

            }
            unset($Query);


        } else {
            Toast("Cantidad Incorrecta",2,"");    
        }

    

} else {
    Toast("No existe el contrato ".$NoSol,2,"");
}
?>

<?php
// include("footer.php");
?>