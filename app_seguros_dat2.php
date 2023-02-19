<?php
require("seguridad.php");
require("rintera-config.php");

if($_POST['action'] == 'edit')
{
 $data = array(
  ':tag'  => $_POST['tag'],
  ':cantidad_asegurada'  => $_POST['cantidad_asegurada'],
  ':costo'   => $_POST['costo'],
  ':nmeses'    => $_POST['nmeses'],
  ':idseguro' => $_POST['idseguro']
 );

 $query = "
 UPDATE seguros_config 
 SET tag = :tag, 
 cantidad_asegurada = :cantidad_asegurada, 
 costo = :costo,
 nmeses = :nmeses 
 WHERE idseguro = :idseguro
 ";
 $statement = $db1_pdo->prepare($query);
 $statement->execute($data);
 echo json_encode($_POST);
}

if($_POST['action'] == 'delete')
{
 $query = "
 DELETE FROM seguros_config 
 WHERE idseguro = '".$_POST["idseguro"]."'
 ";
 $statement = $db1_pdo->prepare($query);
 $statement->execute();
 echo json_encode($_POST);
}
?>