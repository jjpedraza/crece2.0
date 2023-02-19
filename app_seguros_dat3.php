<?php
require("seguridad.php");
require("rintera-config.php");



 $query = "
 INSERT INTO seguros_config(tag,cantidad_asegurada,costo,nmeses) VALUES('',0,0,0) 
 ";
 $statement = $db1_pdo->prepare($query);
 $statement->execute();
 
 
 
 echo json_encode($_POST);

?>
<script>

</script>