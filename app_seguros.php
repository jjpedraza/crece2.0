    <?php
include("head.php");
include("header.php");
?>
<h2>Configuracion de Seguros </h2>


 <?php
 if ($RinteraUser =='admin'){
  echo '
  <div class="container">
   
   <br />
   

   <div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            
            <div class="col-md-12 m-b-20">
                <input type="button" value="Nuevo" id="btnNuevo" class="btn btn-info pull-right">
            </div>
        </div>

    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table id="personal" class="table table-bordered table-striped">
       <thead>
        <tr>
         <th>IdSeguro</th>
         <th>Seguro</th>
         <th>Cant. Asegurada</th>
         <th>Costo</th>
         <th>Meses</th>
        </tr>
       </thead>
       <tbody></tbody>
      </table>
     </div>
    </div>
   </div>
</div>
  ';
 } else {
  MsgBox("ERRROR: No Esta Autorizado para esta sección","index.php", "Continuar");
 }
?>



  <br />
  <br />



<script>
    $(document).ready(function(){

var dataTable = $('#personal').DataTable({
 "language": {
 "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
 },
 "processing" : true,
 "serverSide" : true,
 "order" : [],
 "ajax" : {
  url:"app_seguros_dat.php",
  type:"POST"
 }
});

$('#personal').on('draw.dt', function(){
 $('#personal').Tabledit({
  url:'app_seguros_dat2.php',
  dataType:'json',
  columns:{
   identifier : [0, 'idseguro'],
   editable:[[1, 'tag'], [2, 'cantidad_asegurada'], [3, 'costo'], [4,'nmeses']]
  },
  restoreButton:false,
  onSuccess:function(data, textStatus, jqXHR)
  {
   if(data.action == 'delete')
   {
    $('#' + data.idp).remove();
    $('#personal').DataTable().ajax.reload();
   }
  }
 });
}); 
});


$("#btnNuevo").on('click', function () {
  // Getting value 
 
  $.ajax({
    type: "POST",
    url: "app_seguros_dat3.php",
    datatype: 'html',    
    success: function (data) {
 
      // Add 'html' data to table
    //   $('#personal tbody').html(data);
      $('#personal').DataTable().ajax.reload();
 
      // Update Tabledit plugin
      $('#personal').Tabledit('update');
 
    },
    error: function () {
 
    }
  })
});


</script>

<?php
?>
<?php
include("footer.php");
?>