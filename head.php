
<?php
require ("rintera-config.php");
require ("components.php");
    include("seguridad.php");   
    if (isset($RinteraUser)){
        MiToken_CloseALL($RinteraUser);
    }
    



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRECE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" href="src/default.css">
    <link rel="stylesheet" href="FormElement.css">
    <link rel="stylesheet" href="lib/dataTables.bootstrap.min.css">

    

    <!-- JQUERY -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>

    
    <!-- BOOTSTRAP -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">    
    <script src="node_modules/popper.js/dist/popper.min.js"></script>

    <!-- CSS only -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
<!-- JavaScript Bundle with Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> -->



    <!-- Para Tabla Edit -->
   <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
   <!-- <link rel="stylesheet" href="lib/bootstrap3.3.6/css/bootstrap.min.css" /> -->

   <!-- <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script> -->
    
    
    
    
    
    <!-- DATATABLE -->
    <script src="lib/datatables.min.js"></script>
    <!-- <script src="lib/jquery.dataTables.min.js"></script> -->
    <script src="lib/dataTables.fixedColumns.min.js"></script>    
    <script src="lib/dataTables.buttons.min.js"></script>    
    <script src="lib/jszip.min.js"></script>    
    <script src="lib/pdfmake.min.js"></script>    
    <script src="lib/vfs_fonts.js"></script>    
    <script src="lib/buttons.html5.min.js"></script>    
    <!-- <script src="lib/datetime.js"></script>     -->
    
        <!-- Instanciar MsgBox php -->
        <link rel="stylesheet" href="lib/php-MsgBox.min.css">   
        <?php require("lib/php-MsgBox.min.php"); ?>
    
   
    
    
    <link rel="stylesheet" href="lib/jquery.dataTables.min.css">    
    <link rel="stylesheet" href="lib/buttons.dataTables.min.css">    
    
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    

    
   


    <!-- TOAST -->
    <link rel="stylesheet" href="lib/jquery.toast.min.css">
    <script type="text/javascript" src="lib/jquery.toast.min.js"></script>

    <!-- Modal -->
    <script src="lib/jquery.modalpdz.js"></script> 
    <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />

    <!-- ChatJS -->
    <script src="node_modules/chart.js/dist/Chart.bundle.js"></script> 
    <link rel="stylesheet" href="node_modules/chart.js/dist/Chart.css" />

    
    
    <!-- <link href="lib/jquery.flexdatalist.css" rel="stylesheet" type="text/css">
    <script src="lib/jquery.flexdatalist.js"></script> -->
    <!-- <script src="lib/jcanvas.min.js"></script> --> 
    <!-- <script src="lib/apexcharts.min.js"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    
    
    <link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
    <script type="text/javascript" src="lib/datatables.min.js"></script>
    <script src="lib/jquery.modalpdz.js"></script> 
    <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" /> -->

    <script src="lib/jquery.formatCurrency.js"></script> 
    <script src="lib/tableedit/jquery.tabledit.js"></script> 
   
 

<link rel="icon" href="data:;base64,iVBORw0KGgo=">
<link rel="shortcut icon" href="favicon.ico">
<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
</head>
<body style="
background-color: <?php echo Preference("ColorDeFondo", "", ""); ?>;
text-align:center;
">
<?php
// Init();
?>

<div id='PreLoader' style='
    background-color: <?php echo Preference("ColorPrincipal", "", ""); ?> ;
    opacity: 0.7;
'>
    <div id='Loader' style='
        left: 30%;
        top: 26%;
        
        '>
        <!-- <img src='img/loader5.gif' style='width:100px;'><br> -->
        <b style='color:orange; font-size:10pt;'>Cargando</b> <img src='img/loader_bar.gif' style='width:13px;'><br>
    </div>
</div>