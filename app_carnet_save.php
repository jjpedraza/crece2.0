<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");



$IdSucursal  = VarClean($_POST['IdSucursal']);
$Curp  = VarClean($_POST['IdCliente']);
$Nombre   = VarClean($_POST['Nombre']);
$Domicilio  = VarClean($_POST['Domicilio']);
$Municipio   = VarClean($_POST['Municipio']);
$Estado    = VarClean($_POST['Estado']);
$IFE    = VarClean($_POST['IFE']);
$Correo    = VarClean($_POST['Correo']);
$EstadoCivil    = VarClean($_POST['EstadoCivil']);
$FechaDeNacimiento    = VarClean($_POST['FechaDeNacimiento']);
$Profesion    = VarClean($_POST['Profesion']);
$Sexo    = VarClean($_POST['Sexo']);
$Telefono    = VarClean($_POST['Telefono']);
$trabajo_nombre    = VarClean($_POST['trabajo_nombre']);
$trabajo_domicilio   = VarClean($_POST['trabajo_domicilio']);
$trabajo_telefono    = VarClean($_POST['trabajo_telefono']);
$trabajo_giro   = VarClean($_POST['trabajo_giro']);
$trabajo_puesto   = VarClean($_POST['trabajo_puesto']);
$trabajo_salario   = VarClean($_POST['trabajo_salario']);
$socio_dependen   = VarClean($_POST['socio_dependen']);
$socio_casapropia  = VarClean($_POST['socio_casapropia']);
$minegocio_propio  = VarClean($_POST['minegocio_propio']);
$minegocio_giro  = VarClean($_POST['minegocio_giro']);
$minegocio_ingresos  = VarClean($_POST['minegocio_ingresos']);
$minegocio_telefono  = VarClean($_POST['minegocio_telefono']);
$minegocio_empleados  = VarClean($_POST['minegocio_empleados']);
$minegocio_domicilio  = VarClean($_POST['minegocio_domicilio']);
$minegocio_antiguedad  = VarClean($_POST['minegocio_antiguedad']);
$socio_hijos   = VarClean($_POST['socio_hijos']);
$socio_hogar   = VarClean($_POST['socio_hogar']);
$socio_renta   = VarClean($_POST['socio_renta']);
$socio_agualuz   = VarClean($_POST['socio_agualuz']);
$socio_drenaje   = VarClean($_POST['socio_drenaje']);
$refc1_nombre  = VarClean($_POST['refc1_nombre']);
$refc1_tel  = VarClean($_POST['refc1_tel']);
$refc1_domicilio  = VarClean($_POST['refc1_domicilio']);
$refc1_antiguedad   = VarClean($_POST['refc1_antiguedad']);
$refc2_nombre   = VarClean($_POST['refc2_nombre']);
$refc2_tel   = VarClean($_POST['refc2_tel']);
$refc2_domicilio    = VarClean($_POST['refc2_domicilio']);
$refc2_antiguedad    = VarClean($_POST['refc2_antiguedad']);
$refc3_nombre   = VarClean($_POST['refc3_nombre']);
$refc3_tel  = VarClean($_POST['refc3_tel']);
$refc3_domicilio  = VarClean($_POST['refc3_domicilio']);
$refc3_antiguedad  = VarClean($_POST['refc3_antiguedad']);
$grupo    = VarClean($_POST['grupo']);
$grupo_cargo  = VarClean($_POST['grupo_cargo']);

$grupo_actual = Cliente_IdGrupo($Curp);
$CuentasActivas = Grupo_CuentasActivas($grupo);

$sqlUp =  "UPDATE clientes  SET        
                
        nombre = '".$Nombre."',
        domicilio = '".$Domicilio."',
        municipio = '".$Municipio."',
        estado = '".$Estado."',
        IFE = '".$IFE."',
        correo = '".$Correo."',
        estadocivil = '".$EstadoCivil."',
        fechadenacimiento = '".$FechaDeNacimiento."',
        profesion = '".$Profesion."',
        sexo = '".$Sexo."',
        telefono = '".$Telefono."',
        trabajo_nombre = '".$trabajo_nombre."',
        trabajo_domicilio = '".$trabajo_domicilio."',
        trabajo_telefono = '".$trabajo_telefono."',
        trabajo_giro = '".$trabajo_giro."',
        trabajo_puesto = '".$trabajo_puesto."',
        trabajo_salario = '".$trabajo_salario."',
        socio_dependen = '".$socio_dependen."',
        socio_casapropia = '".$socio_casapropia."',
        minegocio_propio = '".$minegocio_propio."',
        minegocio_giro = '".$minegocio_giro."',
        minegocio_ingresos = '".$minegocio_ingresos."',
        minegocio_telefono = '".$minegocio_telefono."',
        minegocio_empleados = '".$minegocio_empleados."',
        minegocio_domicilio = '".$minegocio_domicilio."',
        minegocio_antiguedad = '".$minegocio_antiguedad."',
        socio_hijos = '".$socio_hijos."',
        socio_hogar = '".$socio_hogar."',
        socio_renta = '".$socio_renta."',
        socio_agualuz = '".$socio_agualuz."',
        socio_drenaje = '".$socio_drenaje."',
        refc1_nombre = '".$refc1_nombre."',
        refc1_tel = '".$refc1_tel."',
        refc1_domicilio = '".$refc1_domicilio."',
        refc1_antiguedad = '".$refc1_antiguedad."',
        refc2_nombre = '".$refc2_nombre."',
        refc2_tel = '".$refc2_tel."',
        refc2_domicilio = '".$refc2_domicilio."',
        refc2_antiguedad = '".$refc2_antiguedad."',
        refc3_nombre = '".$refc3_nombre."',
        refc3_tel = '".$refc3_tel."',
        refc3_domicilio = '".$refc3_domicilio."',
        refc3_antiguedad = '".$refc3_antiguedad."',
        IdGrupo = '".$grupo."',
        grupo_cargo = '".$grupo_cargo."',
        act_fecha='".$fecha."',
        act_hora='".$hora."',
        act_user='".$RinteraUser."',
        IdSucursal='".$IdSucursal."'

        
        WHERE curp='".$Curp."'";

        if ($db1->query($sqlUp) == TRUE){
            Toast("Actulizado ".$Nombre." correctamente",4,"");
            Historia($RinteraUser,"CLIENTES","Actualizo al cliente con IdCliente = ".$Curp);
            echo "<script>GuardarFoto();</script>";
        } else {
            Toast("Error al guardar ".$Nombre." correctamente",2,"");
    
        }
?>

<?php
// include("footer.php");
?>