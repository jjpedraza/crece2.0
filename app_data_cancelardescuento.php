<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$IdDescuento = VarClean($_POST['IdDescuento']);
$NoSol = VarClean($_POST['NoSol']);

$sqlPago = "DELETE FROM  descuetos WHERE id='".$IdDescuento."'";
if ($db1->query($sqlPago) == TRUE){

    Historia($RinteraUser, "DESCUENTO", "Cancelo el Descuento con Id ".$IdDescuento." de la Solicitud ".$NoSol);
    Toast("Descuento Cancelado correctamente",4,"");
    echo "<script>CargaDescuentos();</script>";
} else {
    Toast("Error ",0,"");
}
?>

<?php
// include("footer.php");
?>