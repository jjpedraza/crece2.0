<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol  = VarClean($_POST['NoSol']);
$Actual_Curp = Contrato_Curp($NoSol);
$Actual_Nombre = Contrato_Nombre($NoSol);

$NuevoTitular_Curp = VarClean($_POST['NuevoTitular']);
if (MiembroDelGrupo($NoSol, $NuevoTitular_Curp) == TRUE){
    if (Contrato_cambioTitular($NoSol, $NuevoTitular_Curp) == TRUE){
        Toast("Se ha cambiado la titularidad del contrato con exito, Actualiza la Pagina para observar los cambios",5,"");
        LocationFull("app_solicitud.php?n=".$NoSol);
    } else {
        Toast("Ha habido un problema",2,"");
    }
} else {
    Toast("El Cliente seleccionado no es miembro del mismo grupo",2,"");
}


?>

<?php
// include("footer.php");
?>