<?php
include("head.php");

include("header.php");

$AnioActual = date("Y");
?>
<h2 style=" 
    color:white;


" >Proyeccion <br>

<cite>
    <b class="btn btn-info" style="cursor:pointer; color:cyan;" onclick="LoadProyeccion();"><?php echo $AnioActual;?></b>
    <button onclick="LoadProyeccionOld();" class="btn btn-secondary" style="font-size:10pt; cursor:pointer;">Calcular los años posibles</button>
    <a href="proyeccionvs.php" class="btn btn-primary" style="font-size:10pt; cursor:pointer;">Proyeccion vs Ingresos</a>
    
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
    <div class="col-xl bg-info" style ="
        margin: 5px;
        border-radius: 5px;
        padding: 10px;
    " id="DivData">
     Data
    </div>
  </div>
</div>


<script>
function LoadProyeccion(){
    $('#PreLoader').show();
        $.ajax({
            url: 'proyeccion_data.php',
            type: 'post',
            data: {    
                year:'<?php echo $AnioActual;?>'           
            },
            success: function(data) {
                $('#DivData').html(data);
                $('#PreLoader').hide();
            }
        });
        LoadProyeccion_grafica();
}
LoadProyeccion();


function LoadProyeccionOld(){
    $('#PreLoader').show();
        $.ajax({
            url: 'proyeccion_data.php',
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


function LoadProyeccionOld_grafica(){
    $('#PreLoader').show();
        $.ajax({
            url: 'proyeccion_data_grafica.php',
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



function LoadProyeccion_grafica(){
    $('#PreLoader').show();
        $.ajax({
            url: 'proyeccion_data_grafica.php',
            type: 'post',
            data: {    
                year:'<?php echo $AnioActual;?>'   
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