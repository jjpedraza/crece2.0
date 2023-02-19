<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol = VarClean($_POST['NoSol']);
// $NPago = VarClean($_POST['NPago']);
$sql="select * from descuentos_html where nosol='".$NoSol."' and EstadoPago='SIN PAGAR'";
TableData($sql,"Descuentos autorizados:"); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
?>