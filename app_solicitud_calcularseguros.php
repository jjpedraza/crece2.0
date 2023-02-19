<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol  = VarClean($_POST['NoSol']);
if (isset($_POST['Cantidad'])){
    $Cantidad =  VarClean($_POST['Cantidad']);
} else {
    $Cantidad = 0;
}
if (isset($_POST['CreditoPlazo'])){
    $CreditoPlazo =  VarClean($_POST['CreditoPlazo']);
} else { 
    $CreditoPlazo = 0;
}
$IdSeguroSelect =  VarClean($_POST['IdSeguroSelect']);
$CargoSeguro = CargoSeguro($NoSol);

if (Valoracion($NoSol)==''){
    $sqlSeguros = "select * from seguros_config where cantidad_asegurada='".$Cantidad."' and nmeses='".$CreditoPlazo."'";
    // echo $sqlSeguros;
    $rS = $db1->query($sqlSeguros);    
    // var_dump($db1);
    if ($db1->query($sqlSeguros) == TRUE){        
        
        echo "<select id='CargoSeguro' name='CargoSeguro' class='form-control'>";
        while($S= $rS -> fetch_array()) {  
            if ($S['idseguro']==$IdSeguroSelect) {
                echo "<option value='".$S['idseguro']."' selected>".$S['tag']." (".$S['cantidad_asegurad'].") ".$S['costo']." por ".$S['nmeses']." meses</option>";
            } else {
                echo "<option value='".$S['idseguro']."'>".$S['tag']." (".$S['cantidad_asegurada'].")  $".$S['costo']." por ".$S['nmeses']." meses</option>";
            }
            
        }
        if ($CargoSeguro == 0){
            echo "<option value='' selected>Sin seguro</option>";
        } else {
            echo "<option value=''>Sin seguro</option>";
        }

        
        echo "</select>";
    }
} else {

}
?>

<?php
// include("footer.php");
?>