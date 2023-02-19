<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$Anio = VarClean($_POST['year']);
Historia($RinteraUser, "PROYECCION", "Vio la proyeccion ".$Anio);

if (Proyeccion_Generate(TRUE)==TRUE){
    
    if ($Anio == 0){
        $sql = "select Anio, Mes, FORMAT(PagoCorriente,2) as Esperado, FORMAT(Ingresos,2) as Ingresos from proyeccion";
    } else {
        
        $sql = "select Anio, Mes, FORMAT(PagoCorriente,2)  as Esperado, FORMAT(Ingresos,2) as Ingresos from proyeccion WHERE Anio > = ".$Anio;
    }
    
    if ($Anio == 0){
        echo "Proyeccion sobre todos los años posibles de calculo";
        if (ProyeccionCheck(1)==TRUE){
            DynamicTable_MySQL($sql, "DivProyeccion", "TblProyeccion", "tabla", 0, 1);
            Toast("Proyeccion Generada",4,"");    
        } else {
            echo '
            <div class="alert alert-warning" role="alert">
            Informacion insuficiente en la base de datos para generar una proyeccion
            </div>';
        }
    } else {
        echo "Proyeccion desde el año ".$Anio;
        if (ProyeccionCheck(0)==TRUE){
            DynamicTable_MySQL($sql, "DivProyeccion", "TblProyeccion", "tabla", 0, 1);
            Toast("Proyeccion Generada",4,"");    
        } else {
            echo '
            <div class="alert alert-warning" role="alert">
            Informacion insuficiente en la base de datos para generar una proyeccion
            </div>';
        }
    }
    
    

    
} else {
    Toast("Error al generar la proyeccion",2,"");
}

?>

<?php
// include("footer.php");
?>