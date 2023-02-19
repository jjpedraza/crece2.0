<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$IdSucursal = $_POST['IdSucursal'];

if ($IdSucursal == 0){
    $sql=" 
    select 
    g.IdGrupo,
    g.Grupo_html as Grupo,
    g.Miembros,
    g.Contratos,
    (select Sucursal from sucursales where IdSucursal = g.IdSucursal) as Sucursal,
    g.Grupo_eliminar_html as Eliminar
    
    
    from grupos_html g
    
    
    ";
    echo "<h1>Grupos registrados: </h1>";
    DynamicTable_MySQL($sql, "DivProyeccion", "TblProyeccion", "tabla", 0, 1);

    echo "<br><br>";
} else {
    $sql=" 
    select 
    g.IdGrupo,
    g.Grupo_html as Grupo,
    g.Miembros,
    g.Contratos,
    (select Sucursal from sucursales where IdSucursal = g.IdSucursal) as Sucursal,
    g.Grupo_eliminar_html as Eliminar


    from grupos_html g

    where IdSucursal = '".$IdSucursal."'
    ";
    echo "<h1>Grupos registrados en esta Sucursal:</h1>";
    DynamicTable_MySQL($sql, "DivProyeccion", "TblProyeccion", "tabla", 0, 1);

    echo "<br><br>";
}


?>