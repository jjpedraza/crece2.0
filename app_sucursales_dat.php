<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");


$IdSucursal= $_POST['IdSucursal'];
$rl = $_POST['rl'];




$sql="
UPDATE sucursales SET representante='".$rl."' where IdSucursal='".$IdSucursal."'
";
if ($db1->query($sql) == TRUE){
        Historia($RinteraUser,"SUCURSALES","Actualizo el respresentante legal de la sucursal ".SucursalName($IdSucursal)." - ".$rl);
        Toast("Representante Legal de  ".SucursalName($IdSucursal)." actulizado correctamente",4,"");
        //Redirigir
        
} else {
    Toast("Error al guardar ".$no_sol."",2,"");

}

unset($Curp, $sql);


?>

<?php
// include("footer.php");
?>