<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");

$id_rep = VarClean($_POST['id_rep']);
$Tipo = ReporteTipo($id_rep);
$ClaseDiv  = "ContenedorDeReporte"; $ClaseTabla = "tabla";



    $Data =  Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $RinteraUser );
    Historia($RinteraUser, "VIO", "".$id_rep."");
    echo $Data;

?>