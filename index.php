<?php include("head.php"); ?>


<?php
    if (isset($RinteraUser)){
    $MiToken = MiToken($RinteraUser, "Search");
    if ($MiToken == '') {
        $MiToken = MiToken_Init($RinteraUser, "Search");
    }
    } else {
     
    }
  

// echo "Token: ".$MiToken."";
?>





<?php
include("header.php");
?>

<section id='Busqueda' style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
'>

<table width=100%><tr><td>
    <?php
    if (isset($_GET['q'])) {
        echo '<input id="InputBusqueda" list="busquedas"     data-min-length="1" style="background-color: '.Preference("ColorPrincipal", "", "").';"
        class="InputBusqueda flexdatalist" type="text" placeholder="¿Que reporte necesitas?"  value="' . VarClean($_GET['q']) . '">';

    } else {
        echo '<input id="InputBusqueda" list="busquedas"  data-min-length="1" style="background-color: '.Preference("ColorPrincipal", "", "").';"
        class="InputBusqueda flexdatalist" type="text" placeholder="¿Que reporte necesitas?" >';
    }

    if (isset($_GET['i1'])) {
        Toast("Guardado correctamente " . VarClean($_GET['q']), 1, "");
    }

    if (isset($_GET['e1'])) {
        Toast("ERROR:Al localizar el Reporte " . VarClean($_GET['e1']), 2, "");
    }
    ?>

</td>
<td width=50px align=right valign=middle 
    style='background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;'>
    <button  class="Mbtn btn-Success"  onclick="Search();" style="
    background-color:  <?php echo Preference("ColorResaltado", "", ""); ?>;
    box-shadow: 0 3px  #4d4c49; margin:10px;

    "> 
    <img src='iconos/busqueda.png' style='width:24px;'></button>
</td>
</tr>
</table>

<div style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
text-align: center;
color: white;
font-size: 10pt;  height:22px;

-webkit-box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
-moz-box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
margin-top:  -21px;
'>
    <div id='PreloaderBuscando' style='display:none;'>
        Cargando <img src='img/loader_bar.gif'><br>
        ...Este proceso tardara unos momentos...
    </div>
</div>

</section>
<?php
if (Preference("MostrarApps", "", "")=='TRUE'){
    echo '
    <div class="row" style="margin:0px;">
    <section id="Resultados" >
    

    </section>

    <section id="MisApp" >
    ';
   
   
    echo '

    </section>
    </div>
    ';
} else {
    echo '
    
    <section id="Resultados" style="width:100%">    

    </section>

    
    ';
}
?>

<div id='Dashboard' style='
  background-image:url(img/wallmoney.jpg);
    " >
'>
    <div id="DashboardCol1"  style="vertical-align: top; text-align:left; color:white;">
    
    <!-- <button onclick='CargaGraficas();' class='btn btn-secondary' title='Cargar Graficas'><img src='iconos/more.png' style='width:18px'></button> -->

    
    <?php
     if ($RinteraUser =='admin'){
    echo '
        <div class="menudropdown">
        <span> <img src="iconos/config.png" style="width:32px;"> Configuracion </span>';
        echo '<div class="menudropdown-content">';
            
        
        

        echo  "<a href='app_sucursales.php' title='' style='font-size:8pt; color:gray;'
       
        >Representantes de Sucursales</a><br>
        ";  

        echo  "<a href='app_seguros.php' title='' style='font-size:8pt; color:gray;'       
        >Configuracion de Seguros</a>
        ";  

        echo  "<br><a href='users.php' title='' style='font-size:8pt; color:gray;'       
        >Configuracion de Usuarios</a>
        ";  


        
    echo '</div></div>';
    }
    
    ?>


</div>


    <div id="DashboardCol2" >
    

    <?php
     $rF= $db0 -> query("select * from reportes where Portada=1");    
     $repos = 0; $repolist="";
     while($Fr = $rF -> fetch_array()) {   
         $repolist.= "<a          
         href='r.php?id=".$Fr['id_rep']."' title='Haga Clic aqui para ver el reporte' class='btn btn-info'
         style='
            // background-color: #e6e6e6;
            // color: #625f5f;
            width: 100%;
            font-size: 10pt;
            text-align:left;
            margin-bottom:5px;
         '
         >".$Fr['rep_name']."</a>";
         $repos = $repos + 1;
     }


     $repolist.= "
     <div style='
     background-color: #28a745;
     padding: 5px;
     border-radius: 6px
     '>
     
     
     <input type='text' id='txtCurp' placeholder='CURP' size='16' class='form-control'>
     
     
     
     <button onclick='ClienteNuevo();' title='Haga Clic aqui para ver el reporte' class='btn btn-primary'
     style='
        // background-color: #e6e6e6;
        // color: #625f5f;       
        font-size: 10pt;
        text-align:left;
        margin-top:5px;
     '
     >
     
    
     
     <b style='font-size:8pt;'>Registrar Cliente:</b>

     </button>
     
     </div>
     <br><br>";

     $repolist.= "<a href='app_caja.php' title='Haga Clic aqui para ver el reporte' class='btn btn-success'
     style='
        
        width: 100%;
        font-size: 10pt;
        text-align:left;
     '
     >Caja</a>
     ";
     $repolist.= "
     <a href='app_solicitud.php' title='Haga Clic aqui para ver' class='btn '
     style='
        background-color: #ff8007;
        color: white;
        width: 100%;
        font-size: 10pt;
        text-align:left;
        margin-top:10px;
     '
     >Cuentas</a>


     <a href='app_grupos.php' title='Haga Clic aqui para ver' class='btn btn-secondary'
     style='
        // background-color: #e6e6e6;
        // color: #625f5f;
        width: 100%;
        font-size: 10pt;
        text-align:left;
        margin-top:10px;
     '
     >Grupos</a>


        

     <a href='simularcorrida.php' title='' class='btn btn-secondary'
     style='
        // background-color: #e6e6e6;
        // color: #625f5f;
        width: 100%;
        font-size: 10pt;
        text-align:left;
        margin-top:10px;
     '
     >Simulador de Corrida</a>

     ";


     if ($RinteraUser =='admin'){
    //    $repolist.= "<a href='app_sucursales.php' title='' class='btn btn-secondary'
    //    style='
    //       // background-color: #e6e6e6;
    //       // color: #625f5f;
    //       width: 100%;
    //       font-size: 10pt;
    //       text-align:left;
    //       margin-top:10px;
    //    '
    //    >Representantes de<br> Sucursales</a>
    //    ";  
     }

     $repolist.='
     


     ';
    
     unset($rf);unset($Fr);
     if ($repos > 0 ){
         echo "<h6 style='font-size: 8pt;
         opacity: 0.6;'>Recomendados</h6>";
         echo $repolist;
     }

     
    ?>


    </div>

     <script>
     function ClienteNuevo(){
        Curp = $('#txtCurp').val();
        console.log(Curp);
        if (Curp == ''){
            $.toast('Escriba el Curp del cliente nuevo');
        } else {
            window.location.assign("app_carnet.php?id="+Curp);
        }
        
     }
     </script>


    
</div>

<?php
UltimasBusquedas_buble($RinteraUser);

if (UserAdmin($RinteraUser) == TRUE) {
    if (Preference("NuevosReportes", "", "")=='TRUE'){
    echo "<div class='btnMas' title='Haz clic aquí para crear un nuevo reporte'>
    <a href='nuevo.php' > <img src='src/mas.png' style='width:100%;'>
    </a>
    </div>";
    }

}
?>




<?php
echo "
<script> 
$('.InputBusqueda').css('background-color','".Preference("ColorPrincipal", "", "")."');
$('.InputBusqueda').css('color','white');
</script>
";
echo "
    <script>
    function Search(){
        var busqueda = $('#InputBusqueda').val();
         $('#PreLoaderBuscando').show();                
            $.ajax({
                url: 'search.php',
                type: 'post',        
                data: {IdUser:'" . $RinteraUser . "', Token: '" . $MiToken . "',
                    busqueda:busqueda

                },
            success: function(data){
                $('#Resultados').html(data);
                
                $('#PreLoaderBuscando').hide();
                $('#Dashboard').hide();
            }
            });
        
       


            
    }
    
    // Search();
    </script>

";
if (isset($_GET['q'])){
    if ($_GET['q']<>''){
        echo '
        <script>
            Search();
            $("#Dashboard").hide();
        </script>
        ';
    }
}
?>

<!-- <a href='#DivModal' rel=MyModal:open onclick='URLModal(1)' class='icon'><img src='iconos/check3.png'></a> -->

<!-- <a href="app_detalles.php?id=1&amp;tipo=AROMA&amp;var1=1" rel="MyModal:open" class="icon"><img src="iconos/info.png"></a> -->
<script>
    function Saldos(){
        console.log(':)')        ;
         $('#PreLoader').show();                
            $.ajax({
                url: 'saldos.php',
                type: 'post',        
                data: {

                },
            success: function(data){
                $('#R').html(data);
                
                $('#PreLoader').hide();
       
            }
            });
        
       
            
    }

    function CargaGraficas(){
        
         $('#PreLoader').show();                
            $.ajax({
                url: 'graficas.php',
                type: 'post',        
                data: {

                },
            success: function(data){
                $('#DashboardCol1').html(data);
                
                $('#PreLoader').hide();
       
            }
            });
        
       
            
    }
    
    
</script>
<?php
Historia($RinteraUser, "HOME", "Acceso a la pagina principal");





include ("footer.php");
?>
