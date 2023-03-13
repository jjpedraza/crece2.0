<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol = VarClean($_POST['NoSol']);
$CreditoTipo = VarClean($_POST['CreditoTipo']);
$ClienteCurp = NoSol_to_CurpCliente($NoSol);

$CreditoCantidad = VarClean($_POST['CreditoCantidad']);
$CreditoPlazo = VarClean($_POST['CreditoPlazo']);
$CreditoFormaDePago = VarClean($_POST['CreditoFormaDePago']);

$CreditoTasaInteres = VarClean($_POST['CreditoTasaInteres']);
$CreditoTasaMoratorio = VarClean($_POST['CreditoTasaMoratorio']);
$CreditoCargoPorSemana = VarClean($_POST['CreditoCargoPorSemana']);
$CreditoCargoPorSemana_indi = $CreditoCargoPorSemana;
$IdGrupo = Cliente_IdGrupo($ClienteCurp);
$Miembros = MiembrosDeUnGrupo($IdGrupo);
if ($CreditoTipo=="GRUPAL"){
   $CreditoCargoPorSemana = $CreditoCargoPorSemana_indi * $Miembros;
}

$CreditoGarantia = VarClean($_POST['CreditoGarantia']);
$CreditoValoracion = VarClean($_POST['CreditoValoracion']);
$CreditoComentarios = VarClean($_POST['CreditoComentarios']);
$CreditoFechaContrato = VarClean($_POST['CreditoFechaContrato']);
$CreditoFechaInicio = VarClean($_POST['CreditoFechaInicio']);

echo "Inicio".$CreditoFechaInicio."|";
echo "Contrato".$CreditoFechaContrato;

if (validar_fechadeinicio($CreditoFechaInicio, $CreditoFechaContrato)) {
    echo "La fecha {$CreditoFechaInicio} es un lunes, martes o miércoles";

$CreditoIvaTipo = VarClean($_POST['CreditoIvaTipo']);
$IdSeguro = VarClean($_POST['IdSeguro']);
$SeguroCosto = Seguros_Costo($IdSeguro);

$AvalCurp1 = VarClean($_POST['AvalCurp1']);
$AvalNombre1 = VarClean($_POST['AvalNombre1']);
$AvalCurp2 = VarClean($_POST['AvalCurp2']);
$AvalNombre2 = VarClean($_POST['AvalNombre2']);

// Historia($RinteraUser, "PROYECCION", "Vio la proyeccion ".$Anio);
// if ($CreditoValoracion == "NOT" OR $CreditoValoracion=="APROBADO"){
if (Valoracion($NoSol)=="APROBADO") {  
   //Solo puede guardar Cargo Semanal y Garantia
   $sql = "UPDATE cuentas SET
   garantia = '".$CreditoGarantia."',
   cargoporsemana = '".$CreditoCargoPorSemana."',
   cargoporsemana_indi = '".$CreditoCargoPorSemana_indi."',
   comentario='".$CreditoComentarios."'
   WHERE nosol = '".$NoSol."'
   ";
   echo $sql;
   if ($db1->query($sql) == TRUE){
      Toast("Actualizado con exito, (cargo Semanal, Garantia y Comentarios)",4,"");      
      Historia($RinteraUser,"CLIENTES","Actualizo Cargo Semanal = ".$CreditoCargoPorSemana.", Garantia = ".$CreditoGarantia.", Comentarios=".$CreditoComentarios);      
   } else {
      Toast("Guardado con exito",4,"");
   }
   unset($sql);
   
} else { //addslashes($str);
   //Todos los campos y Ejecutar Tablas aledañas
   $GRABAR = TRUE;
   // echo "FechaContrato=".$CreditoFechaContrato;
   if ($CreditoFechaContrato ==''){
      Toast("ERROR en la fecha del contrato",2,"");
      $GRABAR = FALSE;
   } 

   if ($CreditoFechaInicio ==''){
      Toast("ERROR en la fecha inicio del contrato",2,"");
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

   if ($CreditoValoracion ==''){
      Toast("ERROR Eliga una Valoracion",2,"");
      $GRABAR = FALSE;
   } 


   if ($GRABAR == TRUE) {
   if ($CreditoValoracion=='APROBADO') {
      $sql = "UPDATE cuentas SET
      garantia = '".$CreditoGarantia."',
      cargoporsemana = '".$CreditoCargoPorSemana."',
      cargoporsemana_indi = '".$CreditoCargoPorSemana_indi."',
      tipo='".$CreditoTipo."',
      cantidad='".$CreditoCantidad."',
      plazo ='".$CreditoPlazo."',
      formadepago='".$CreditoFormaDePago."',
      tasa_interes='".$CreditoTasaInteres."',
      tasa_moratorio='".$CreditoTasaMoratorio."',
      valoracion='".$CreditoValoracion."',
      fechacontrato='".$CreditoFechaContrato."',
      comentario='".$CreditoComentarios."',
      iva_tipo='".$CreditoIvaTipo."',
      fechainicio ='".$CreditoFechaInicio."',
      IdSeguro='".$IdSeguro."',
      CargoSeguro='".$SeguroCosto."',
      aval_curp='".$AvalCurp1."',
      aval_nombre='".$AvalNombre1."',
      aval_curp2='".$AvalCurp2."',
      aval_nombre2='".$AvalNombre2."'



      WHERE nosol = '".$NoSol."'
      ";
      
      if ($db1->query($sql) == TRUE){
         Toast("Actualizado con exito, (".$CreditoValoracion.")",4,"");      
         Historia($RinteraUser,"CLIENTES","Actualizo Cuenta = ".addslashes($sql));      

         //CHECAR si hay una corrida y limpiarla
         $CorridaEncontrada=0;
         $sqlC = "select count(*) as n
         from tabladepagos
         where nosol='".$NoSol."'" ;    
         $rC= $db1 -> query($sqlC); if($C = $rC -> fetch_array()){
            $CorridaEncontrada = $C['n'];
         }
         unset($sqlC, $rC, $C);


         $HacerCorrida = TRUE;
         if ($CorridaEncontrada >0) {//Si encontramos una corrida financiera previa
            //Eliminamos la Corrida
            $sqlDel = "DELETE FROM  tabladepagos                     
                     WHERE nosol='".$NoSol."'  
                     ";
                     if ($db1->query($sqlDel) == TRUE){                        
                        Toast("Se actualizo la corrida",3,"");      
                        Historia($RinteraUser,"TABLADEPAGOS","ActualizoCorrida = ".addslashes($sqlDel));      
                        $HacerCorrida = TRUE;
                     }  else {
                        $HacerCorrida = FALSE;
                     }
         }  else {
            $HacerCorrida = TRUE;
         }

         //CREAR CORRIDA FINANCIERA:
         if ($HacerCorrida == TRUE){
               $n = 0;
               $NPlazo = 0;
               if ($CreditoFormaDePago==7){$NPlazo=$CreditoPlazo*4;}
               if ($CreditoFormaDePago==15){$NPlazo=$CreditoPlazo*2;}
               if ($CreditoFormaDePago==30){$NPlazo=$CreditoPlazo*1;}

               $Abono=$CreditoCantidad/$NPlazo;
               $Interes=(($CreditoCantidad/100)*$CreditoTasaInteres)*$CreditoPlazo;
               $Interes=$Interes/$NPlazo; //se reparte entre el numero de letras de pago

               $CargoSeguro = $SeguroCosto / $NPlazo;

               $Impuestos = (($Abono  +  $Interes) /100) * $CreditoIvaTipo;
               
               $AbonoFinal=$Abono+$Interes + $Impuestos + $CargoSeguro;

               $UltimoPago=$CreditoCantidad-($Abono*$NPlazo);

               $UltimoPago=$Abono+$UltimoPago;
            
            

               $nodepago =1;
               $Saldo=$CreditoCantidad;
               $n=1;
               $finicio="";
               $ffin="";
               // echo "NPagos=".$NPlazo."<br>";
               // echo "FormadePago=".$CreditoFormaDePago."<br>";
               // echo "
               // <h3>Corrida Financiera:</h3>
               // <table class='tabla'>";
               // echo "<th>No</th>";
               // echo "<th>Fecha de Pago</th>";
               // echo "<th>Abono</th>";
               // echo "<th>Interes</th>";
               // echo "<th>IVA</th>";
               // echo "<th>Total</th>";
               $nOK=0;
               $msgT = "";
               $n=1;
               while($n<=$NPlazo){
                  if ($n<=1){ // si es el primer pago es la fecha del contrato
                     // $FechaSig = $CreditoFechaContrato;
                     $FechaSig = $CreditoFechaInicio;

                  } else {
                     // $FechaSig = date('Y-m-d', strtotime("$FechaSig + ".$CreditoFormaDePago."day"));
                     $FechaSig = EncuentraMiercoles($FechaSig, $CreditoFormaDePago);
                  }
                  

                  // if (dia($FechaSig) == "Sabado"){
                  //    $FechaSig = date('Y-m-d', strtotime("$FechaSig + 2day"));

                  // }

                  // if (dia($FechaSig) == "Domingo"){
                  //    $FechaSig = date('Y-m-d', strtotime("$FechaSig + 1day"));
                  // }

                  // echo "<tr>";
                  $ffin=$FechaSig;
                  $finicio = date('Y-m-d', strtotime("$FechaSig - 2day"));
          

                  $sqlIn = "INSERT INTO tabladepagos
                  (
                     nosol,
                     cuenta_interna,
                     curp,
                     no,
                     fin,
                     abono,
                     interes,
                     iva,               
                     inicio,
                     usuario,
                     act_fecha,
                     act_hora,
                     cargoseguro

                  )
                  VALUES (
                     '".$NoSol."',
                     '',
                     '".$ClienteCurp."',
                     '".$n."',
                     '".$ffin."',
                     '".$Abono."',
                     '".$Interes."',
                     '".$Impuestos."',
                     '".$finicio."',
                     '".$RinteraUser."',
                     '".$fecha."',
                     '".$hora."',
                     '".$CargoSeguro."'
                  )
                  ";
                  echo $sqlIn;
                  
                  if ($db1->query($sqlIn) == TRUE){
                     $nOK= $nOK + 1;
                     // Toast("Actualizado con exito, (".$CreditoValoracion.")",4,"");      
                     Historia($RinteraUser,"TABLADEPAGOS","Inserto Corrida Financiera = ".addslashes($sqlIn));      
                     // $msgT.="Generado pago ".$n."<br>";
                  } else {
                     $msgT.="Error en Tabla, pago ".$n."<br>";
                     
                  }
                  unset($sqlIn);

                  if ($msgT==''){
                     echo "<script>location.reload();</script>";
                     Toast("Tabla de Pagos Guardad Correctamente",4,"");
                  } else {
                     Toast("ERROR al guardar tabla de pagos ".$msgT,2,"");
                  }
                  // echo "<td>".$n."</td><td>".dia($finicio)." ".$finicio." ~ ".dia($ffin)." ".$ffin."". "</td>";
                  // echo "<td>".$n."</td><td>"." ".$finicio." ~ "." ".$ffin."". "</td>";
                  // echo "<td>".Pesos($Abono). "</td>";
                  // echo "<td>".Pesos($Interes). "</td>";
                  // echo "<td>".Pesos($Impuestos). "</td>";
                  // echo "<td>".Pesos($AbonoFinal). "</td>";
                  


                  // echo "</tr>";
                  


                  $n = $n+1;
               }
         } else{
            Toast ("Error al crear la Corrida Financiera",2,"");
         }

         if ($nOK > 0){
            Toast("Se insertaron ".$nOK." letras de pago a la corrida de la Cuenta ".$NoSol,4,"");
         } else {
            Toast("Ha habido un error al Insertar la Corrida Financiera",2,"");
         }
         // echo "</table>";

      } else {
         echo $sql;
         Toast("Error al guardar",2,"");
      }
      unset($sql);




   } else { //RECHAZADO
   $sql = "UPDATE cuentas SET
      garantia = '".$CreditoGarantia."',
      cargoporsemana = '".$CreditoCargoPorSemana."',
      cargoporsemana_indi = '".$CreditoCargoPorSemana_indi."',
      tipo='".$CreditoTipo."',
      cantidad='".$CreditoCantidad."',
      plazo ='".$CreditoPlazo."',
      formadepago='".$CreditoFormaDePago."',
      tasa_interes='".$CreditoTasaInteres."',
      tasa_moratorio='".$CreditoTasaMoratorio."',
      valoracion='".$CreditoValoracion."',
      fechacontrato='".$CreditoFechaContrato."',
      comentario='".$CreditoComentarios."',
      IdSeguro='".$IdSeguro."',
      CargoSeguro='".$SeguroCosto."'


      WHERE nosol = '".$NoSol."'
      ";
      if ($db1->query($sql) == TRUE){
         Toast("Actualizado con exito, (".$CreditoValoracion.")",4,"");      
         Historia($RinteraUser,"CLIENTES","Actualizo Cuenta = ".addslashes($sql));      
      } else {
         Toast("Guardado con exito",4,"");
      }
      unset($sql);
   }
} else {
   Toast("ERROR al guardar",2,"");
}
}

} else {
   echo "La fecha {$CreditoFechaInicio} NO es un Miercoles";
   Toast("La fecha de inicio {$CreditoFechaInicio} Debe ser un Miercoles y debe ser Mayor que la de Contrato",2,"");
}

?>

<?php
// include("footer.php");
?>