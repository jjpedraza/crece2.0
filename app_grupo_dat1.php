<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");


$IdSucursal = $_POST['IdSucursal'];
$GrupoName = $_POST['GrupoName'];

// Toast($no_sol,0,"");

// $Curp  = VarClean($_POST['IdCliente']);
$sql="
INSERT INTO grupos(Grupo, IdSucursal) VALUES ('".$GrupoName."', '".$IdSucursal."')";

if ($db1->query($sql) == TRUE){
        Historia($RinteraUser,"GRUPOS","Creo el grupo".$GrupoName." ");
        Toast("Grupo   ".$GrupoName." creado correctamente ",4,"");
        //Redirigir
        // $url="app_solicitud.php?n=".$no_sol;
        // echo "<script>"."window.location.replace('".$url."')"."</script>";
        
} else {
    Toast("Error al guardar ".$GrupoName."",2,"");

}

// unset($, $sql);


?>

<?php
// include("footer.php");
?>