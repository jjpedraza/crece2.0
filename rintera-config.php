<?php
// if (isset($_SESSION['RinteraUser'])){
//     session_start();
//     $RinteraUser = $_SESSION['RinteraUser'];
// }

// require_once("components.php");

date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d');
$hora =  date ("H:i:s");
$SesionName="R1nT3r4";

require_once("preference.php");
// require_once("components.php");
//CONEXION DE LA BASE DE DATOS DE RINTERA	
$db0_host = 'localhost';	
$db0_user = 'root';
$db0_pass = ''; 
// $db0_pass = ''; 
$db0_name = 'rintera_crece';


if (function_exists('mysqli_connect')) {		
    $db0 = new mysqli($db0_host,$db0_user,$db0_pass,$db0_name);
    $acentos = $db0->query("SET NAMES 'utf8'"); // para los acentos
    $acentos = $db0->query("SET lc_time_names = 'es_MX'"); // para los acentos
	// var_dump($db0);
        // global $db0;
        
    }else{			
        die ("Error en la conexion a la base de datos principal de RINTERA");
}




//CONEXION DE LA BASE DE DATOS DE RINTERA	
$db1_host = 'localhost';	
$db1_user = 'root';
$db1_pass = ''; 
// $db0_pass = ''; 
$db1_name = 'crece';

$db1_pdo = new PDO("mysql:host=localhost; dbname=crece", "root", "");

if (function_exists('mysqli_connect')) {		
    $db1 = new mysqli($db1_host,$db1_user,$db1_pass,$db1_name);
    $acentos2 = $db1->query("SET NAMES 'utf8'"); // para los acentos
    $acentos2 = $db1->query("SET lc_time_names = 'es_MX'"); // para los acentos
    setlocale(LC_MONETARY, 'en_MX');
	// var_dump($db0);
        // global $db0;
        
    }else{			
        die ("Error en la conexion a la base de datos principal de CRECE");
}






$UsuariosForaneaos = Preference("UsuariosForaneos", "", ""); 
$QueryUsuariosForaneos = Preference("UsuariosForaneosQuery", "", "");  //"select * from UsuariosRintera where RinteraLevel>0"; 
$UsuariosForaneosIdCon = Preference("UsuariosForaneosIdCon", "", ""); 

$UsuariosForaneosIdConType = "";
$sql = "select * from dbs WHERE Idcon='".$UsuariosForaneosIdCon."'";
$rc= $db0 -> query($sql);
// var_dump($db0);
if($f = $rc -> fetch_array())
{
	$UsuariosForaneosIdConType =  $f['ConType'];
}

$Error="";
// echo $UsuariosForaneaos;
// var_dump($UsuariosForaneosIdCon);
if ($UsuariosForaneaos == "TRUE") {
    if 	($UsuariosForaneosIdCon <> "" ){
        // var_dump($UsuariosForaneosIdConType);
        if ($UsuariosForaneosIdConType  <=1) {

                  
                if ($QueryUsuariosForaneos <> '') {
                    $sql = "select * from dbs where IdCon='".$UsuariosForaneosIdCon."'";    
                    // echo $sql;    
                    $r= $db0 -> query($sql);    
                    if($Fdb = $r -> fetch_array())
                    {    
                        if ($Fdb['dbhost']<>'' &&  $Fdb['dbname']<>'' && $Fdb['dbuser']<>'' && $Fdb['dbpassword']<>'')    {
                            $dbUser_host = $Fdb['dbhost'];
                            $dbUser_user = $Fdb['dbuser'];
                            $dbUser_pass = $Fdb['dbpassword'];
                            $dbUser_name = $Fdb['dbname'];
                            // echo "dbname=".$dbUser_name;

                            // echo "OK";
                            if (function_exists('mysqli_connect')) {		
                                $dbUser = new mysqli($dbUser_host,$dbUser_user,$dbUser_pass,$dbUser_name);
                                $acentos = $dbUser->query("SET NAMES 'utf8'"); // para los acentos                            
                                // var_dump($dbUser);

                                
                                // echo "Exito";p
                            }else{
                                $Error = $Error."No esta activado MySQLi";    
                            }

                        } else {
                            $Error = $Error."Parametros insuficientes para conección." .$dbUser_host;    
                        }

                    } else {
                        $Error = $Error."No se localizo el registro de la conección ".$UsuariosForaneosIdCon.".";    
                    }           

                } else {
                    $Error = $Error."Sin Query para Foraneos";
                }
              
        } else {
            $Error = $Error."No es un tipo de Conección Permitida ConType=0,1. ";
        }
    } else {
        $Error = $Error."IdCon para Foraneos Vacia ";
    }



		
           
                

} else {
                // Conección a la base Local de rintera
                    $dbUser = $db0;
                    // $sql = "select * from users";
                    // $RUser= $dbUser -> query($sql);
                    // if($FUser = $RUser -> fetch_array()){
                    //     // var_dump($FUser);
                        
                        
                    // } else {
                        
                    //     $Error = $Error."Fallo de conección al Consultar los Usuarios";
                    // }


}


// var_dump($dbUser);
// if (isset($dbUser)) {
//     $sql = $QueryUsuariosForaneos;
//     $RUser= $dbUser -> query($sql);
    
//     if ($dbUser->query($sql) == TRUE) {
//         // echo "OK USERS";
        
//         // if($FUser = $RUser -> fetch_array()){
//         //     var_dump($FUser);                
            
//         // } else {
            
            
//         // }
//         // } else {
//         //     $Error = $Error."Fallo de conección";
//         // }

//         } else {
//             $Error = $Error."Fallo de conección al Consultar los Usuarios.!";
//         }
//     }

$StringFecha = date('Ymd')."_".  date("His");

if ($Error ==''){

} else {
    
    echo "<div id='Error'

    style='
    background-color:red;
    color:white;
    width:90%;
    display:inline-block;
    border-radius:10px;
    margin:20px;
    padding:20px;
    '
    ><table width=100%><tr><td
    style='color:white;'
    >".$Error."</td><td width=50px><a href='index.php' class='btn btn-Warning'>Reintentar</a></td></tr></table></div>";

    // $CorreoDestino = "printepolis@gmail.com";
    // $Asunto = "Error: ".$fecha;
    // $ContenidoDelCorreo = "<p>".$fecha.":".$hora.". Rintera: Ha habido un error <b>".$Error."</b> </p>";
    // EnviarCorreo($CorreoDestino, $Asunto, $ContenidoDelCorreo);




    //session.auto_start = 0 o 1;  si esta en 1, da error 
    //Warning: session_name(): Cannot change session name when session is active, al utilizar session_name(); ya que agrega    session_start(); al automaticamente
    

}



$session_auto_start = 1;

$PorcentajeIVA = 0.16;



?>