<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");


$IdSucursal = $_POST['IdSucursal'];
$no_sol = NoSol_generar($IdSucursal);

Toast($no_sol,0,"");

$Curp  = VarClean($_POST['IdCliente']);
$IdGrupo = VarClean($_POST['IdGrupo']);
$Cargo = VarClean($_POST['Cargo']);
$sql="
INSERT INTO cuentas(nosol, curp, fechasol, IdSucursal, tipo) VALUES ('".$no_sol."', '".$Curp."','".$fecha."', '".$IdSucursal."','INDIVIDUAL')";
// echo $sql;
if ($db1->query($sql) == TRUE){
        Historia($RinteraUser,"CLIENTES","Creo la solicitud ".$no_sol." para el Cliente con CURP= ".$Curp);
        Toast("Solicitud  ".$no_sol." creada correctamente",4,"");
        //Redirigir
        $url="app_solicitud.php?n=".$no_sol;

        $sql2="
        INSERT INTO historial_contrato(curp,nosol,idgrupo, grupo_cargo, fecha, hora, idsucursal, iduser) 
        VALUES ('".$Curp."', '".$no_sol."','".$IdGrupo."','".$Cargo."', '".$fecha."', '".$hora."', '".$IdSucursal."','".$RinteraUser."')";
        // echo $sql;
        if ($db1->query($sql2) == TRUE){}

        echo "<script>"."window.location.replace('".$url."')"."</script>";
        
} else {
    Toast("Error al guardar ".$no_sol."",2,"");

}

unset($Curp, $sql);


?>

<?php
// include("footer.php");
?>