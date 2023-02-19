<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");
?>

<?php
$NoSol = VarClean($_POST['NoSol']);
$PagosQueDebe = NDebe($NoSol);

if ($PagosQueDebe<= 0){
    Toast("El Contrato ".$NoSol." no debe ningun pago",2,"");
    echo "<script>AhorroDiv();</script>";
} else {
    $NSelect = VarClean($_POST['n']);
    if ($NSelect == 0) {
    
        $DebeTotal=DebeTotal($NoSol);

    } else {//Selecciono un pago
        $DebeTotal=DebePago($NoSol,$NSelect);
        if ($DebeTotal<=0){$DebeTotal=0;}
        echo "<script>$('#CajaPago_distribucion').html('');</script>";
    }
    // $DebeTotal=DebeTotal($NoSol);
    //--------\/ Cantidad a Recibir
    echo '<div class="form-group disable" style="margin: 4px; padding: 4px; width:100%; border-radius: 5px;vertical-align: top;">';
        $IdElement = "CantidadRecibida";
        $Label="Recibida:";
        $SmallText="Cantidad que recibe en caja";
        if ($DebeTotal<=0){$DebeTotal=0;}
        $Value = Moneda($DebeTotal);
        echo '<table width=100%><tr><td>';
        echo '
            <label for="'.$IdElement.'" style="font-size:8pt;">'.$Label.'</label>
            <input title="'.$Value.'" style="cursor:pointer; font-size:12pt; height:50px; margin-top:-7px;" type="number" class="form-control" id="'.$IdElement.'" placeholder="" value="'.$Value.'" >
            <small id="'.$IdElement.'_smalltext'.'" class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;">'.$SmallText.'</small>';
        echo '</td><td width=50px valign=midle><button style="margin-top:10px;" class="btn btn-primary" onclick="RepartirPago();"><img src="iconos/btn_derecha.png" style="width:32px;"></button></td></tr></table>';
        echo '</div>';

    //------ /\ Cantidad a Recibir


}
?>

<script>
    var btn2 = document.getElementById("CantidadRecibida");
btn2.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        RepartirPago();
    }
});  


</script>
<?php
// include("footer.php");
?>