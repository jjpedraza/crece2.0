<?php
include("head.php");
include("header.php");

// if (isset($_GET['g'])){
//     $txtGrupo = VarClean($_GET['g']);
//     $sqlIn = "INSERT INTO grupos (nombre) VALUES ('".$txtGrupo."')";
//     if ($db1->query($sqlIn) == TRUE){
//         Toast("Grupo ".$txtGrupo." creado correctamente",4,"");
//         Historia($RinteraUser,"GRUPOS","Creo al grupo ".$txtGrupo);
//     } else {
//         Toast("Error al crear el grupo ".$txtGrupo."",2,"");

//     }
// }

if (isset($_GET['IdGrupo'])){
    $IdGrupo = $_GET['IdGrupo'];
    $Grupo = GrupoName($IdGrupo);
    echo "<div id='DivGrupo' class='container' style='

    background-color: white;
    padding: 10px;
    border-radius: 6px;
    margin-top: 30px;
    '>

    ";
    echo "<h1>Grupo ".$Grupo."</h1>";
    echo "<a href='app_grupos.php'>Ver todos los grupos</a>";


    $sqlC = "select nombre_html,grupo_cargo,Sucursal from clientescongrupo where IdGrupo='".$IdGrupo."'";
    DynamicTable_MySQL($sqlC, "DivProyeccion", "TblProyeccion", "tabla", 0, 1);

    echo "</div>";
} else {



    echo "<div id='DivGrupos' class='container' style='

    background-color: white;
    padding: 10px;
    border-radius: 6px;
    margin-top: 30px;
    '>

    ";



    if ($IdSucursal == 0){
        $sql=" 
        select 
        g.IdGrupo,
        g.Grupo_html as Grupo,
        g.Miembros,
        g.Contratos,
        (select Sucursal from sucursales where IdSucursal = g.IdSucursal) as Sucursal,
        g.Grupo_eliminar_html as Eliminar
        
        
        from grupos_html g
        
        
        ";
        echo "<h1>Grupos registrados: </h1>";
        DynamicTable_MySQL($sql, "DivProyeccion", "TblProyeccion", "tabla", 0, 1);

        echo "<br><br>";
    } else {
        $sql=" 
        select 
        g.IdGrupo,
        g.Grupo_html as Grupo,
        g.Miembros,
        g.Contratos,
        (select Sucursal from sucursales where IdSucursal = g.IdSucursal) as Sucursal,
        g.Grupo_eliminar_html as Eliminar


        from grupos_html g

        where IdSucursal = '".$IdSucursal."'
        ";
        echo "<h1>Grupos registrados en esta Sucursal:</h1>";
        DynamicTable_MySQL($sql, "DivProyeccion", "TblProyeccion", "tabla", 0, 1);

        echo "<br><br>";
    }




    echo "</div>";
    echo "
    <div class='container' style='
    background-color: white;
    padding: 10px;
    border-radius: 6px;
    margin-top: 30px;
    '>
    <input type='text' id='g' name='g' placeholder='Nombre del Grupo' class='form-control' style='width:70%; display:inline-block;' required>

    <button onclick='Grupo_Crear();' title='Haga Clic aqui para ver el reporte' class='btn btn-success'
    style='
    // background-color: #e6e6e6;
    // color: #625f5f;
    width: 200px;
    font-size: 10pt;
    text-align:left;
    '
    >
    Crear Grupo</button>
    </div>

    ";
}
?>

<script>
function Grupo_Crear(){    
    GrupoName = $('#g').val();
    IdSucursal = '<?php echo $IdSucursal; ?>';
    $('#PreLoader').show();
            $.ajax({
                url: 'app_grupo_dat1.php',
                type: 'post',
                data: {
                    GrupoName:GrupoName, IdSucursal:IdSucursal
       
                },
                success: function(data) {
                    $('#R').html(data);
                    Grupo_Refresh();
                    $('#PreLoader').hide();
                }
            });
}

function EliminarG(IdGrupo){    
    
    IdSucursal = '<?php echo $IdSucursal; ?>';
    $('#PreLoader').show();
            $.ajax({
                url: 'app_grupo_dat3.php',
                type: 'post',
                data: {
                    IdGrupo:IdGrupo, IdSucursal:IdSucursal
       
                },
                success: function(data) {
                    $('#R').html(data);
                    Grupo_Refresh();
                    $('#PreLoader').hide();
                }
            });
}


function Grupo_Refresh(){    
    IdSucursal = '<?php echo $IdSucursal; ?>';
    $('#PreLoader').show();
            $.ajax({
                url: 'app_grupo_dat2.php',
                type: 'post',
                data: {
                    IdSucursal:IdSucursal
       
                },
                success: function(data) {
                    $('#DivGrupos').html(data);
                    $('#PreLoader').hide();
                }
            });
}

</script>

<?php
include("footer.php");
?>