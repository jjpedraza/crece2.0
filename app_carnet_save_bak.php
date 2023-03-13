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
if ($CuentasActivas > 0){ //No se puede cambiar de grupo
    $grupo = $grupo_actual; //le regresamos al grupo que tenia
    Toast("No es posible cambiarse de grupo, ya que aun este grupo tiene cuentas por pagar",2,"");
}

// Historia($RinteraUser, "PROYECCION", "Vio la proyeccion ".$Anio);


$sql = "select count(*) as n from clientes where curp='".$Curp."'";
$Existe = 0;

if ($db1->query($sql) == TRUE){
    $rc = $db1->query($sql);    
    if($f = $rc -> fetch_array())
    {
        if ($f['n']>=1){
            $Existe = 1;
        }
    } else {

    }
}
unset($rc, $f);

if ($Existe == 0){ //INSERT
    if ($grupo_cargo=='MIEMBRO'){
        $sqlIn =  "INSERT INTO clientes          
        (
        curp,
        nombre,
        domicilio,
        municipio,
        estado,
        IFE,
        correo,
        estadocivil,
        fechadenacimiento,
        profesion,
        sexo,
        telefono,
        trabajo_nombre,
        trabajo_domicilio,
        trabajo_telefono,
        trabajo_giro,
        trabajo_puesto,
        trabajo_salario,
        socio_dependen,
        socio_casapropia,
        minegocio_propio,
        minegocio_giro,
        minegocio_ingresos,
        minegocio_telefono,
        minegocio_empleados,
        minegocio_domicilio,
        minegocio_antiguedad,
        socio_hijos,
        socio_hogar,
        socio_renta,
        socio_agualuz,
        socio_drenaje,
        refc1_nombre,
        refc1_tel,
        refc1_domicilio,
        refc1_antiguedad,
        refc2_nombre,
        refc2_tel,
        refc2_domicilio,
        refc2_antiguedad,
        refc3_nombre,
        refc3_tel,
        refc3_domicilio,
        refc3_antiguedad,
        grupo,
        grupo_cargo, IdSucursal)

    VALUES (
     '".$Curp."',
     '".$Nombre."',
     '".$Domicilio."',
     '".$Municipio."',
     '".$Estado."',
     '".$IFE."',
     '".$Correo."',
     '".$EstadoCivil."',
     '".$FechaDeNacimiento."',
     '".$Profesion."',
     '".$Sexo."',
     '".$Telefono."',
     '".$trabajo_nombre."',
     '".$trabajo_domicilio."',
     '".$trabajo_telefono."',
     '".$trabajo_giro."',
     '".$trabajo_puesto."',
     '".$trabajo_salario."',
     '".$socio_dependen."',
     '".$socio_casapropia."',
     '".$minegocio_propio."',
     '".$minegocio_giro."',
     '".$minegocio_ingresos."',
     '".$minegocio_telefono."',
     '".$minegocio_empleados."',
     '".$minegocio_domicilio."',
     '".$minegocio_antiguedad."',
     '".$socio_hijos."',
     '".$socio_hogar."',
     '".$socio_renta."',
     '".$socio_agualuz."',
     '".$socio_drenaje."',
     '".$refc1_nombre."',
     '".$refc1_tel."',
     '".$refc1_domicilio."',
     '".$refc1_antiguedad."',
     '".$refc2_nombre."',
     '".$refc2_tel."',
     '".$refc2_domicilio."',
     '".$refc2_antiguedad."',
     '".$refc3_nombre."',
     '".$refc3_tel."',
     '".$refc3_domicilio."',
     '".$refc3_antiguedad."',
     '".$grupo."',
     '".$grupo_cargo."',
     '".$IdSucursal."')";
    } else {
        if (Grupo_Cargo($grupo, $grupo_cargo,$Curp)==TRUE){
            // $grupo_cargo='MIEMBRO';
            $sqlIn =  "INSERT INTO clientes          
            (
            curp,
            nombre,
            domicilio,
            municipio,
            estado,
            IFE,
            correo,
            estadocivil,
            fechadenacimiento,
            profesion,
            sexo,
            telefono,
            trabajo_nombre,
            trabajo_domicilio,
            trabajo_telefono,
            trabajo_giro,
            trabajo_puesto,
            trabajo_salario,
            socio_dependen,
            socio_casapropia,
            minegocio_propio,
            minegocio_giro,
            minegocio_ingresos,
            minegocio_telefono,
            minegocio_empleados,
            minegocio_domicilio,
            minegocio_antiguedad,
            socio_hijos,
            socio_hogar,
            socio_renta,
            socio_agualuz,
            socio_drenaje,
            refc1_nombre,
            refc1_tel,
            refc1_domicilio,
            refc1_antiguedad,
            refc2_nombre,
            refc2_tel,
            refc2_domicilio,
            refc2_antiguedad,
            refc3_nombre,
            refc3_tel,
            refc3_domicilio,
            refc3_antiguedad,
            grupo,
            IdSucursal)
    
        VALUES (
         '".$Curp."',
         '".$Nombre."',
         '".$Domicilio."',
         '".$Municipio."',
         '".$Estado."',
         '".$IFE."',
         '".$Correo."',
         '".$EstadoCivil."',
         '".$FechaDeNacimiento."',
         '".$Profesion."',
         '".$Sexo."',
         '".$Telefono."',
         '".$trabajo_nombre."',
         '".$trabajo_domicilio."',
         '".$trabajo_telefono."',
         '".$trabajo_giro."',
         '".$trabajo_puesto."',
         '".$trabajo_salario."',
         '".$socio_dependen."',
         '".$socio_casapropia."',
         '".$minegocio_propio."',
         '".$minegocio_giro."',
         '".$minegocio_ingresos."',
         '".$minegocio_telefono."',
         '".$minegocio_empleados."',
         '".$minegocio_domicilio."',
         '".$minegocio_antiguedad."',
         '".$socio_hijos."',
         '".$socio_hogar."',
         '".$socio_renta."',
         '".$socio_agualuz."',
         '".$socio_drenaje."',
         '".$refc1_nombre."',
         '".$refc1_tel."',
         '".$refc1_domicilio."',
         '".$refc1_antiguedad."',
         '".$refc2_nombre."',
         '".$refc2_tel."',
         '".$refc2_domicilio."',
         '".$refc2_antiguedad."',
         '".$refc3_nombre."',
         '".$refc3_tel."',
         '".$refc3_domicilio."',
         '".$refc3_antiguedad."',
         '".$grupo."',         
         '".$IdSucursal."')";
        if($grupo==''){} 
        else {Toast("No se guardara el cargo ".$cargo.", ya que hay alguien con el mismo en el grupo. Pero sera miembro del mismo", 2,"");}

        } else {
            // Toast("Cargo libre ".$cargo." en el grupo.", 1,"");
            $sqlIn =  "INSERT INTO clientes          
            (
            curp,
            nombre,
            domicilio,
            municipio,
            estado,
            IFE,
            correo,
            estadocivil,
            fechadenacimiento,
            profesion,
            sexo,
            telefono,
            trabajo_nombre,
            trabajo_domicilio,
            trabajo_telefono,
            trabajo_giro,
            trabajo_puesto,
            trabajo_salario,
            socio_dependen,
            socio_casapropia,
            minegocio_propio,
            minegocio_giro,
            minegocio_ingresos,
            minegocio_telefono,
            minegocio_empleados,
            minegocio_domicilio,
            minegocio_antiguedad,
            socio_hijos,
            socio_hogar,
            socio_renta,
            socio_agualuz,
            socio_drenaje,
            refc1_nombre,
            refc1_tel,
            refc1_domicilio,
            refc1_antiguedad,
            refc2_nombre,
            refc2_tel,
            refc2_domicilio,
            refc2_antiguedad,
            refc3_nombre,
            refc3_tel,
            refc3_domicilio,
            refc3_antiguedad,
            grupo,
            grupo_cargo, IdSucursal)
    
        VALUES (
         '".$Curp."',
         '".$Nombre."',
         '".$Domicilio."',
         '".$Municipio."',
         '".$Estado."',
         '".$IFE."',
         '".$Correo."',
         '".$EstadoCivil."',
         '".$FechaDeNacimiento."',
         '".$Profesion."',
         '".$Sexo."',
         '".$Telefono."',
         '".$trabajo_nombre."',
         '".$trabajo_domicilio."',
         '".$trabajo_telefono."',
         '".$trabajo_giro."',
         '".$trabajo_puesto."',
         '".$trabajo_salario."',
         '".$socio_dependen."',
         '".$socio_casapropia."',
         '".$minegocio_propio."',
         '".$minegocio_giro."',
         '".$minegocio_ingresos."',
         '".$minegocio_telefono."',
         '".$minegocio_empleados."',
         '".$minegocio_domicilio."',
         '".$minegocio_antiguedad."',
         '".$socio_hijos."',
         '".$socio_hogar."',
         '".$socio_renta."',
         '".$socio_agualuz."',
         '".$socio_drenaje."',
         '".$refc1_nombre."',
         '".$refc1_tel."',
         '".$refc1_domicilio."',
         '".$refc1_antiguedad."',
         '".$refc2_nombre."',
         '".$refc2_tel."',
         '".$refc2_domicilio."',
         '".$refc2_antiguedad."',
         '".$refc3_nombre."',
         '".$refc3_tel."',
         '".$refc3_domicilio."',
         '".$refc3_antiguedad."',
         '".$grupo."',
         '".$grupo_cargo."',
         '".$IdSucursal."')";
        
        }
    }
    

    echo $sqlIn;
    if ($db1->query($sqlIn) == TRUE){
        Toast("Guardado ".$Nombre." correctamente",4,"");
        Historia($RinteraUser,"CLIENTES","Dio de Alta al cliente con IdCliente = ".$Curp);
    } else {
        Toast("Error al guardar ".$Nombre." correctamente",2,"");

    }
    

} else { //UPDATE
    if ($grupo_cargo=='MIEMBRO'){
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
    } else {
        if (Grupo_Cargo($grupo, $grupo_cargo,$Curp)==TRUE){
            // $grupo_cargo='MIEMBRO';
                    
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
            act_fecha='".$fecha."',
            act_hora='".$hora."',
            act_user='".$RinteraUser."',
            IdSucursal='".$IdSucursal."'

            
        WHERE curp='".$Curp."'";
        if ($grupo==''){}
        else {
            Toast("No se guardara el cargo ".$cargo.", ya que hay alguien con el mismo en el grupo. Pero sera miembro del mismo", 2,"");
            }
            
        } else {
            // Toast("Cargo libre ".$cargo." en el grupo.", 1,"");
            
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
        }
    }
    
    // echo $sqlUp;

    if ($db1->query($sqlUp) == TRUE){
        Toast("Actulizado ".$Nombre." correctamente",4,"");
        Historia($RinteraUser,"CLIENTES","Actualizo al cliente con IdCliente = ".$Curp);
        echo "<script>GuardarFoto();</script>";
    } else {
        Toast("Error al guardar ".$Nombre." correctamente",2,"");

    }
}

?>

<?php
// include("footer.php");
?>