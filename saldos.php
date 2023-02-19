<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$sql="
delete from saldos;
";
if ($db1->query($sql) == TRUE){
        Historia($RinteraUser,"SALDOS","Limpio Saldos");
        Toast("Saldos vaciados correctamente",3,"");
} else {
    Toast("Error",2,"");

}
unset($sql);



$sql="
insert into saldos (select c.*, curdate() as act_fecha, curtime() as act_hora from cartera c);
";
if ($db1->query($sql) == TRUE){
        Historia($RinteraUser,"SALDOS","Calculo Saldos");
        Toast("Saldos calculados correctamente",3,"");
} else {
    Toast("Error",2,"");

}
unset($sql);



?>

<?php
// include("footer.php");
?>