<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol = VarClean($_POST['NoSol']);
$NPago =VarClean($_POST['NPago']);
$Descuento = VarClean($_POST['Descuento']);
$DebePago = DebePago_capital($NoSol,$NPago);

if (NoSol_existe($NoSol)==TRUE){
    if ($DebePago>0){
        // Toast($Descuento." <= ".$DebePago,5,"");
        if ($Descuento <= $DebePago){

            $Query="INSERT INTO descuetos (nosol, no, concepto, cantidad, act_user, act_fecha, act_hora, IdTipoDescuento) VALUES (
                '".$NoSol."',
                '".$NPago."',
                'Descuento p/Capital',
                '".$Descuento."',
                '".$RinteraUser."',
                '".$fecha."',
                '".$hora."',
                '5'
                
                

            )";            
            if ($db1->query($Query) == TRUE)
            {
                Toast("Se guardo correctamente el descuento",4,"");
                echo "<script>CargaContrato(0);</script>";
                echo "<script>
                $('.MyModal').hide();
                $('.jquery-MyModal').hide();
                
                </script>";
            }
            else {
                Toast("Error al guardar, intenlo nuevamente <br>".$Query,2,"");

            }
            unset($Query);


        } else {
            Toast("Cantidad Incorrecta",2,"");    
        }

    } else {
        Toast("El Pago ".$NPago." no tiene saldo, del contrato ".$NoSol,2,"");
    }

} else {
    Toast("No existe el contrato ".$NoSol,2,"");
}
?>

<?php
// include("footer.php");
?>