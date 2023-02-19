<?php
include("head.php");
include("header.php");


if ($RinteraUser =='admin'){
echo "<h2>Configuracion de Parametros de Sucursales </h2>";
if ($RinteraUser=='admin'){
    $sql="select * from sucursales";
    $r= $db1 -> query($sql);
        
        echo "<table class='tabla'>";
        echo "<th>IdSucursal</th>";
        echo "<th>Sucursal</th>";
        echo "<th>Represante Legal</th>";
        echo "<th>Btn</th>";
        while($f = $r -> fetch_array()) {      
            echo "<tr>";
            echo "<td style='text-align:left;'>".$f['IdSucursal']."</td>";
            echo "<td style='text-align:left;'>".$f['Sucursal']."</td>";
            echo "<td style='text-align:left;'><input class='form-control' type='text' id='rl_".$f['IdSucursal']."' value='".$f['representante']."'></td>";
            echo "<td style='text-align:left;'><button class='btn btn-primary' onclick='SaveSuc(".$f['IdSucursal'].")'>Guardar</button></td>";
            echo "</tr>";
        }
        echo "</table>";


} else {
    echo "Esta opcion es solo para el usuario admin";
}

} else {
    MsgBox("ERRROR: No Esta Autorizado para esta sección","index.php", "Continuar");
}
?>


<script>
function SaveSuc(IdSucursal){
   rl = $('#rl_'+IdSucursal).val();
   $('#PreLoader').show();
            $.ajax({
                url: 'app_sucursales_dat.php',
                type: 'post',
                data: {
                   IdSucursal:IdSucursal, rl:rl
       
                },
                success: function(data) {
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
}
</script>
<?php

include("footer.php");
?>