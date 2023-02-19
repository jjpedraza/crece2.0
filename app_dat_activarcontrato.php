<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol  = VarClean($_POST['NoSol']);
if (ActivarContrato($NoSol)==TRUE){
    Toast("Contrato activado con exito",4,"");
    LocationFull("app_solicitud.php?n=".$NoSol);
} else {
    Toast("Hubo un problema al cancelar el contrato ".$NoSol,2,"");
}

?>

<?php
// include("footer.php");
?>