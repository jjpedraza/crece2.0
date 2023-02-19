<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");
echo '<datalist id="contratos" style="

">';
$sql="
select 
DISTINCT c.Cliente, c.nosol,
c.IdSucursal
from cartera c
WHERE EstadoPago <> 'PAGADO'
";
$r= $db1 -> query($sql);
while($f = $r -> fetch_array()) {          
  echo '<option  value="'.$f['nosol'].'">'.$f['nosol'].' - '.$f['Cliente'].'</option>';
}
unsert($r, $f);
  
echo '</datalist>';

?>

<?php
// include("footer.php");
?>