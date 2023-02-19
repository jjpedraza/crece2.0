<?php 
session_start();

$RinteraUser = "";
$RinteraUserName = "";

 //Crear sesión
//  session_name($SesionName);
//  session_start();

 //Vaciar sesión
 $_SESSION = array();


//  SESSION_close(session_id());
 //Destruir Sesión
 session_unset();
 session_destroy();
 
  

 if(isset($_COOKIE[session_name()])) { 
    setcookie(session_name(), '', time() - 42000, '/'); 
  } 
  
unset($_SESSION['RinteraUser']);
 //Redireccionar a login.php

header("location:index.php");

?>