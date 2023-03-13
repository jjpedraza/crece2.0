<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");



$NoSol  = VarClean($_POST['NoSol']);

if ( 0 < $_FILES['GarantiaFile']['error'] ) {
            $Err=  'Error: ' . $_FILES['GarantiaFile']['error']. '<br>';
            Toast("Error: ".$Err,2,"");

}
else {
    $archivofinal = 'fotos/'.$NoSol."_garantia.pdf";            
    // rename("fotos_vehiculos/".$IdVehiculo.".jpg", "fotos_vehiculos/".$IdVehiculo."-".MiToken_generate().".jpg");
    if (move_uploaded_file($_FILES['GarantiaFile']['tmp_name'], $archivofinal)==TRUE){
        echo '<script>ActualizaFoto();</script>';
        $archivofinal = $archivofinal."?".date ("His");
        Toast("Se actualizo el archivo de la Garantia",6,$archivofinal);

        echo "<script>ActualizaFoto();</script>";
        Historia($RinteraUser,"CLIENTES","Actualizo la Foto IdCliente = ".$Curp);
        
    } else {
        Toast("Error al subir el archivo",2,"");
    }

}

// Toast("Guardado ".$Nombre." correctamente",4,"");


?>

<?php
// include("footer.php");
?>