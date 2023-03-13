<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");


$IdSucursal = $_POST['IdSucursal'];
$TipoCredito = $_POST['TipoCredito'];
$no_sol = NoSol_generar($IdSucursal);

// Toast($no_sol,0,"");


$Curp  = VarClean($_POST['IdCliente']);
// $IdGrupo = Cliente_IdGrupo($Curp);

$IdGrupo = VarClean($_POST['IdGrupo']);
if ($IdGrupo=="") {
    Toast("Para crear un contrato grupal, seleccione un grupo y un cargo",2,"");
} else {

$Cargo = $_POST['Cargo'];
var_dump($_POST['Cargo']); 




$CuentasActivas = Grupo_CuentasActivas($IdGrupo);
// $Cargo = Cliente_Grupo_cargo($Curp);

//VALIDACIONES:

//1.- Que no tenga cuentas activas el Grupo



if ($CuentasActivas > 0){
    Toast("No se puede crear otra cuenta; ya que tienes una aun por pagar",2,"");
    
    
} else {
    //2.- Que el que solicite sea presidente (Se entiende como representante Legal del grupo)
    Toast("Cargo".$Cargo,"",1);
    
    $sqlp="select count(*) as n from clientes where IdGrupo='".$IdGrupo."' and grupo_cargo='PRESIDENTE' and curp<>'".$Curp."'";
    
    $rp= $db1 -> query($sqlp);    
    if($fp = $rp -> fetch_array())
    { 
        if ($fp['n']==0){//No hay presidente            
            
        } else {//Hay alguien como presidente
            //Limpiamos primero al presidente existente
            $sqlup="UPDATE clientes SET grupo_cargo='' WHERE IdGrupo='".$IdGrupo."'";            
            if ($db1->query($sqlup) == TRUE){
                Toast("Se elimino de como presidente a otro miembro del grupo");
            }
            

        }
        $sqlup="UPDATE clientes SET grupo_cargo='PRESIDENTE' WHERE curp='".$Curp."' and IdGrupo='".$IdGrupo."'";        
        if ($db1->query($sqlup) == TRUE) {
            Toast("Se actualizo como PRESIDENTE",4,"");
        } else {
            Toast("ERROR: al actualizar como PRESIDENTE al presente cliente",2,"");
            $Cargo = ""; //Para que no pueda continuar
        }
            
    } 
    unset($fp,$rp);




    var_dump($Cargo);
    if ($Cargo == 'PRESIDENTE'){                   
        $sql="
        INSERT INTO cuentas(nosol, curp, fechasol, IdSucursal, tipo, IdGrupo) VALUES ('".$no_sol."', '".$Curp."','".$fecha."', '".$IdSucursal."','GRUPAL','".$IdGrupo."')";
        // echo $sql;
        if ($db1->query($sql) == TRUE){
                Historia($RinteraUser,"CLIENTES","Creo la solicitud ".$no_sol." para el Cliente con CURP= ".$Curp.", siendo PRESIDENTE del IdGrupo ".$IdGrupo);
                Toast("Solicitud  ".$no_sol." creada correctamente",4,"");
                //Redirigir

                $sql="
                 select * from gruposinfo where IdGrupo='".$IdGrupo."'
                ";
                $rg= $db1 -> query($sql);
                while($g = $rg -> fetch_array()) { 

                        $sql2="
                        INSERT INTO historial_contrato(curp,nosol,idgrupo, grupo_cargo, fecha, hora, idsucursal, iduser) 
                        VALUES ('".$g['curp']."', '".$no_sol."','".$IdGrupo."','".$g['grupo_cargo']."', '".$fecha."', '".$hora."', '".$IdSucursal."','".$RinteraUser."')";
                        // echo $sql;
                        if ($db1->query($sql2) == TRUE){}
                }

                $url="app_solicitud.php?n=".$no_sol;
                echo "<script>"."window.location.replace('".$url."')"."</script>";            
        } else {
            Toast("Error al guardar ".$no_sol."",2,"");
        }
    } else {
        Toast("El cliente tiene que tener el cargo de PRESIDENTE del grupo para poder solicitarlo de forma grupal; actualmente tiene el cargo de ".$Cargo,2,"");
    }
}
unset($Curp, $sql);

} //si IdGrupo=""
?>

<?php
// include("footer.php");
?>