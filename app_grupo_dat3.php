<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$IdSucursal = $_POST['IdSucursal'];
$IdGrupo = $_POST['IdGrupo'];
if (Grupo_delete($IdGrupo) == TRUE){
    Toast("Grupo   ".GrupoName($IdGrupo)." eliminado correctamente ",4,"");
} else {
    Toast("Error al intentar eliminar ".GrupoName($IdGrupo).", Revise que no tenga contratos o miembros ",2,"");
}

?>