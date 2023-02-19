<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");


// 
$CreditoCantidad = VarClean($_POST['CreditoCantidad']);
$CreditoPlazo = VarClean($_POST['CreditoPlazo']);
$CreditoFormaDePago = VarClean($_POST['CreditoFormaDePago']);
$CreditoTasaInteres = VarClean($_POST['CreditoTasaInteres']);
$CreditoTasaMoratorio = VarClean($_POST['CreditoTasaMoratorio']);
$CreditoFechaInicio = VarClean($_POST['CreditoFechaInicio']);


//TEST
// $CreditoCantidad = 1000;
// $CreditoPlazo = 3;
// $CreditoFormaDePago = 15;
// $CreditoTasaInteres = 1.19;
// $CreditoTasaMoratorio = 5;
// $CreditoFechaInicio = $fecha;


$CreditoIvaTipo = 0;

// Historia($RinteraUser, "PROYECCION", "Vio la proyeccion ".$Anio);
   //Todos los campos y Ejecutar Tablas aledañas
   $GRABAR = TRUE;
   // echo "FechaContrato=".$CreditoFechaContrato;
   if ($CreditoFechaInicio ==''){
      Toast("ERROR en la fecha de inicio",2,"");
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
         if ($CreditoFormaDePago==7){$NPlazo=$CreditoPlazo*4;}
         if ($CreditoFormaDePago==15){$NPlazo=$CreditoPlazo*2;}
         if ($CreditoFormaDePago==30){$NPlazo=$CreditoPlazo*1;}

         $Abono=$CreditoCantidad/$NPlazo;
         $Interes=(($CreditoCantidad/100)*$CreditoTasaInteres)*$CreditoPlazo;
         $Interes=$Interes/$NPlazo; //se reparte entre el numero de letras de pago

         $Impuestos = (($Abono  +  $Interes) /100) * $CreditoIvaTipo;
         
         $AbonoFinal=$Abono+$Interes + $Impuestos;

         $UltimoPago=$CreditoCantidad-($Abono*$NPlazo);

         $UltimoPago=$Abono+$UltimoPago;
      
         $nodepago =1;
         $Saldo=$CreditoCantidad;
         $n=1;
         $finicio="";
         $ffin="";
         // echo "NPagos=".$NPlazo."<br>";
         // echo "FormadePago=".$CreditoFormaDePago."<br>";
         $htmlPDF = "";

         $htmlPDF.= "<h3>Corrida Financiera:</h3>
         <table class='tabla'>";
        //  echo "<h3>Corrida Financiera:</h3>
        //  <table class='tabla'>";

         $htmlPDF.= "<th>No</th>";
         $htmlPDF.= "<th>Fecha de Pago</th>";
         $htmlPDF.= "<th>Abono</th>";
         $htmlPDF.= "<th>Interes</th>";
         $htmlPDF.= "<th>IVA</th>";
         $htmlPDF.= "<th>Total</th>";


         echo "<hr><table class='tabla'><th>No</th>";
         echo "<th>Fecha de Pago</th>";
         echo "<th>Abono</th>";
         echo "<th>Interes</th>";
         echo "<th>IVA</th>";
         echo "<th>Total</th>";
         while($n<=$NPlazo){
            if ($n==1){ // si es el primer pago es la fecha del contrato
               $FechaSig = $CreditoFechaInicio;
            } else {
               $FechaSig = date('Y-m-d', strtotime("$FechaSig + ".$CreditoFormaDePago."day"));
            }
            
            if (dia($FechaSig) == "Sabado"){
               $FechaSig = date('Y-m-d', strtotime("$FechaSig + 2day"));

            }

            if (dia($FechaSig) == "Domingo"){
               $FechaSig = date('Y-m-d', strtotime("$FechaSig + 1day"));
            }

            
            $ffin=$FechaSig;
            $finicio = date('Y-m-d', strtotime("$FechaSig - 3day"));

            // echo "<td>".$n."</td><td>".dia($finicio)." ".$finicio." ~ ".dia($ffin)." ".$ffin."". "</td>";
            
            echo "<tr>";
            echo "<td>".$n."</td><td>".fecha_larga($ffin)."". "</td>";
            echo "<td>".Pesos($Abono). "</td>";
            echo "<td>".Pesos($Interes). "</td>";
            echo "<td>".Pesos($Impuestos). "</td>";
            echo "<td>".Pesos($AbonoFinal). "</td>";
            echo "</tr>";
            
           $htmlPDF.= "<tr>";
           $htmlPDF.= "<td>".$n."</td><td>"."  ".fecha_larga($ffin)."". "</td>";
           $htmlPDF.= "<td>".Pesos($Abono). "</td>";
           $htmlPDF.= "<td>".Pesos($Interes). "</td>";
           $htmlPDF.= "<td>".Pesos($Impuestos). "</td>";
           $htmlPDF.= "<td>".Pesos($AbonoFinal). "</td>";
           $htmlPDF.= "</tr>";
            


            $n = $n+1;
         }
         echo "</table>";

         echo "<a 
         class='btn btn-secondary'
         download='corridafinanciera.pdf'
         href='simularcorrida_data_pdf.php?CreditoCantidad=".$CreditoCantidad."&CreditoPlazo=".$CreditoPlazo."&CreditoFormaDePago=".$CreditoFormaDePago."&CreditoTasaInteres=".$CreditoTasaInteres."&CreditoTasaMoratorio=".$CreditoTasaMoratorio."&CreditoFechaInicio=".$CreditoFechaInicio."'>";
         echo "<img src='iconos/pdf.png' class='icon' style='width:23px;'> Descargar";
         echo "</a>";
         $htmlPDF.="</table>";

      // } else {
      //    Toast("Guardado con exito",2,"");
      // }
      // unset($sql);

   //  $PDFTitulo="SIMULACION DE CORRIDA FINANCIERA";
    

   //  $PDFSubTitulo="";
   //  $PDFSubTitulo2="";
   //  include("_print_head.php");
      
   //  include("_print_footer.php");



   Toast("Corrida Financiera calculada",0,"");
} 
?>

<?php
// include("footer.php");
?>