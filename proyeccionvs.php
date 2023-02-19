<?php
include("head.php");

include("header.php");

$AnioActual = date("Y");
?>
<h2 style=" 
    color:white;


" >Proyeccion vs Ingresos <br>
<cite>
    <!-- <button onclick="LoadProyeccionOld();" class="btn btn-secondary" style="font-size:10pt; cursor:pointer;">Calcular los años posibles</button> -->
    <a href="proyeccion.php" class="btn btn-primary" style="font-size:10pt; cursor:pointer;">Proyeccion Normal</a>
    
</cite>
 </h2>

<div class="container">
  <div class="row">
    <div class="col-xl bg-white" style="
        margin: 5px;
        border-radius: 5px;
        padding: 10px;
    " id="DivGrafica">
    
    </div>
   </div>
   <div class="row">
    <div class="col-xl bg-warning" style ="
        margin: 5px;
        border-radius: 5px;
        padding: 10px;
    " id="DivData">
     Data
    </div>
  </div>
</div>


<script>



function LoadProyeccionOld(){
    $('#PreLoader').show();
        $.ajax({
            url: 'proyeccion_datavsingresos.php',
            type: 'post',
            data: {    
                year:0           
            },
            success: function(data) {
                $('#DivData').html(data);
                $('#PreLoader').hide();
            }
        });
        LoadProyeccionOld_grafica();
}
LoadProyeccionOld();

function LoadProyeccionOld_grafica(){
    $('#PreLoader').show();
        $.ajax({
            url: 'proyeccion_data_grafica2.php',
            type: 'post',
            data: {    
                year:0           
            },
            success: function(data) {
                $('#DivGrafica').html(data);
                $('#PreLoader').hide();
            }
        });
}



</script>

<?php
// include("footer.php");
?>