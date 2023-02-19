<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol = VarClean($_POST['NoSol']);
$CreditoTipo = VarClean($_POST['CreditoTipo']);

$CreditoCantidad = VarClean($_POST['CreditoCantidad']);
$CreditoPlazo = VarClean($_POST['CreditoPlazo']);
$CreditoFormaDePago = VarClean($_POST['CreditoFormaDePago']);

$CreditoTasaInteres = VarClean($_POST['CreditoTasaInteres']);
$CreditoTasaMoratorio = VarClean($_POST['CreditoTasaMoratorio']);
$CreditoCargoPorSemana = VarClean($_POST['CreditoCargoPorSemana']);
$CreditoGarantia = VarClean($_POST['CreditoGarantia']);
$CreditoValoracion = VarClean($_POST['CreditoValoracion']);
$CreditoComentarios = VarClean($_POST['CreditoComentarios']);
$CreditoFechaContrato = VarClean($_POST['CreditoFechaContrato']);
$CreditoIvaTipo = VarClean($_POST['CreditoIvaTipo']);
$IdSeguro = VarClean($_POST['IdSeguro']);
// echo "IdSeguro=php=".$IdSeguro;
$SeguroCosto = Seguros_Costo($IdSeguro);

// Historia($RinteraUser, "PROYECCION", "Vio la proyeccion ".$Anio);
   //Todos los campos y Ejecutar Tablas aledañas
   $GRABAR = TRUE;
   // echo "FechaContrato=".$CreditoFechaContrato;
   if ($CreditoFechaContrato ==''){
      Toast("ERROR en la fecha del contrato",2,"");
      $GRABAR = FALSE;
   } 

   if ($CreditoCantidad =='' OR $CreditoCantidad=='0'){
      Toast("ERROR en la Cantidad",2,"");
      $GRABAR = FALSE;
   } 

   if ($CreditoPlazo =='' OR $CreditoPlazo=='0'){
      Toast("ERROR en el Plazo",2,"");
      $GRABAR = FALSE;
   } 

   // if ($CreditoValoracion ==''){
   //    Toast("ERROR Eliga una Valoracion",2,"");
   //    $GRABAR = FALSE;
   // } 


   if ($GRABAR == TRUE) {
   
         $n = 0;
         $NPlazo = 0;
         $CargoSeguro = 0;
         if ($CreditoFormaDePago==7){$NPlazo=$CreditoPlazo*4;}
         if ($CreditoFormaDePago==15){$NPlazo=$CreditoPlazo*2;}
         if ($CreditoFormaDePago==30){$NPlazo=$CreditoPlazo*1;}

         $Abono=$CreditoCantidad/$NPlazo;
         $Interes=(($CreditoCantidad/100)*$CreditoTasaInteres)*$CreditoPlazo;
         $Interes=$Interes/$NPlazo; //se reparte entre el numero de letras de pago

         $Impuestos = (($Abono  +  $Interes) /100) * $CreditoIvaTipo;
         
         $CargoSeguro = intval($SeguroCosto) / $CreditoPlazo;
         
         // var_dump($CargoSeguro, $SeguroCosto, $CreditoPlazo);
         $AbonoFinal=$Abono+$Interes + $Impuestos+$CargoSeguro;

         $UltimoPago=$CreditoCantidad-($Abono*$NPlazo);

         $UltimoPago=$Abono+$UltimoPago;
      
         $nodepago =1;
         $Saldo=$CreditoCantidad;
         $n=1;
         $finicio="";
         $ffin="";
         // echo "NPagos=".$NPlazo."<br>";
         // echo "FormadePago=".$CreditoFormaDePago."<br>";
         echo "
         <h3>Corrida Financiera:</h3>
         <table class='tabla'>";
         echo "<th>No</th>";
         echo "<th>Fecha de Pago</th>";
         echo "<th>Abono</th>";
         echo "<th>Interes</th>";
         echo "<th>IVA</th>";
         echo "<th>Seguro</th>";
         echo "<th>Total</th>";
         while($n<=$NPlazo){
            if ($n==1){ // si es el primer pago es la fecha del contrato
               $FechaSig = $CreditoFechaContrato;
            } else {
               $FechaSig = date('Y-m-d', strtotime("$FechaSig + ".$CreditoFormaDePago."day"));
            }
            
            if (dia($FechaSig) == "Sabado"){
               $FechaSig = date('Y-m-d', strtotime("$FechaSig + 2day"));

            }

            if (dia($FechaSig) == "Domingo"){
               $FechaSig = date('Y-m-d', strtotime("$FechaSig + 1day"));
            }

            echo "<tr>";
            $ffin=$FechaSig;
            $finicio = date('Y-m-d', strtotime("$FechaSig - 3day"));

            // echo "<td>".$n."</td><td>".dia($finicio)." ".$finicio." ~ ".dia($ffin)." ".$ffin."". "</td>";
            echo "<td>".$n."</td><td>"." ".$finicio." ~ "." ".$ffin."". "</td>";
            echo "<td>".Pesos($Abono). "</td>";
            echo "<td>".Pesos($Interes). "</td>";
            echo "<td>".Pesos($Impuestos). "</td>";
            echo "<td>".Pesos($CargoSeguro). "</td>";
            echo "<td>".Pesos($AbonoFinal). "</td>";
            


            echo "</tr>";
            


            $n = $n+1;
         }
         echo "</table>";

      // } else {
      //    Toast("Guardado con exito",2,"");
      // }
      // unset($sql);




   Toast("Corrida Financiera calculada",0,"");
} 
?>

<?php
// include("footer.php");
?>