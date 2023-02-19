<?php
include("head.php");
include("header.php");
?>
<h2>SIMULADOR DE CORRIDA FINANCIERA </h2>

<div style='width:90%; background-color:white; margin:10px; padding:20px; display:inline-block; border-radius:10px;' class='container'>
<?php
FormElement_input("Fecha de Inicio: ",$fecha,"", "","date","CreditoFechaInicio");
FormElement_input("Cantidad de Credito: ",0,"", "","text","CreditoCantidad");
FormElement_input("Plazo (meses): ",1,"", "","number","CreditoPlazo");


echo "<div style='width:40%; display:inline-block;'><label>Forma de Pago:</label> <br><select id='CreditoFormaDePago' class='form-control' style='font-size:9pt; margin-top:-7px;'>";           
           
                echo "<option value='7' selected>SEMANAL</option>";
                echo "<option value='15'>QUINCENAL</option>";
                echo "<option value='30'>MENSUAL</option>";
           

echo "</select></div>";

FormElement_input("Interes Mensual: ",1.19,"", "","text","CreditoTasaInteres");
FormElement_input("Interes Moratorio: (mensual) ",5,"", "","text","CreditoTasaMoratorio");


?>
<br>
<button class="btn btn-success" onclick="CorridaFake();">Calcular Corrida</button>
<div id='RV'></div>
</div>
<script>
function CorridaFake(){
   //Variables


   CreditoCantidad = $('#CreditoCantidad').val();
   CreditoPlazo = $('#CreditoPlazo').val();
   CreditoFormaDePago = $('#CreditoFormaDePago').val();
   CreditoTasaInteres = $('#CreditoTasaInteres').val();
   CreditoTasaMoratorio = $('#CreditoTasaMoratorio').val();
   CreditoFechaInicio = $('#CreditoFechaInicio').val();
   

   

   $('#PreLoader').show();
            $.ajax({
                url: 'simularcorrida_data.php',
                type: 'post',
                data: {
                   CreditoCantidad:CreditoCantidad,
                   CreditoPlazo:CreditoPlazo,
                   CreditoFormaDePago:CreditoFormaDePago,
                   CreditoTasaInteres:CreditoTasaInteres,
                   CreditoTasaMoratorio:CreditoTasaMoratorio,
                   CreditoFechaInicio:CreditoFechaInicio
       
                },
                success: function(data) {
                    $('#RV').html(data);
                    $('#PreLoader').hide();
                }
            });
}
</script>
<?php

include("footer.php");
?>