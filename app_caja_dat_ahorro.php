<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol = VarClean($_POST['NoSol']);
if ($NoSol <> '') {
    echo "<div style='
        width:100%;
        background-image: url(img/ahorrar.png);
        background-size: cover;
        height: 342px;
        border-radius:5px;
        background-position: center;
        margin-top:20px;
        background-size: 125%;
        text-align: left;
        padding: 10px;

    '>";
    echo "<h4 style='
    color: white;
    font-size: 13pt;
    '>Ahorro para el contrato $NoSol</h4>";
    echo "<table width=100% border=0>";

    echo "<tr><td width=30%>";

    echo "<input type='number' id='CantidadAhorro' placeholder='Cuanto Ahorraras?' style='
        height: 50px;
        font-size: 14pt;
        border-radius: 5px;
        border: 0px;
    '>";
    echo "</td><td align=left width=30px>";

    echo "<button class='btn btn-success' style='
        height:50px;
        margin-top: -7px;
        margin-left: 6px;
    ' onclick='Ahorrar();'>Ahorrar!</button><br>";

    echo '</td><td ></td></tr>';

    echo "<tr><td align=center>";
    echo "<input type='number' id='CantidadAhorro_retirar' placeholder='Cuanto?' style='
        height: 50px;
        font-size: 14pt;
        border-radius: 5px;
        border: 0px;
    '>";
    echo "</td><td align=left width=30px>";
    echo "<button class='btn btn-warning' style='
        height:50px;
        margin-top: -5px;
        margin-left: 6px;
        background-color: #ffc107a1;
        color: white;
    ' onclick='Ahorrar_retiro();'>Retirar</button>
    ";

    echo "</td><td align=left>";
    echo "

      <button class='btn btn-warning' style='
        height:50px;
        margin-top: -5px;
        margin-left: 6px;
        background-color: #ffc107a1;
        color: white; font-size:9pt;
    ' onclick='Ahorrar_crearDescuento();'><b>Ahorro <img src='iconos/derecha.png' style='width:12px;'>Descuento</b></button>
    
    ";
    echo "</td></tr></table>";
    

    echo "<br><br>";
    // echo "<a class='btn btn-primary' style='
    //     height:50px;
    //     margin-top: -7px;
    //     margin-left: 6px;
    // ' 
    // href='print_ahorro.php?id=".$NoSol."'

    // >Reporte de Ahorro</a>";

    $MiAhorro = NoSol_Ahorro($NoSol);
    if ($MiAhorro>0){
        echo "<div style='
        background-color: #4d041fb3;
        margin: 10px;
        padding: 10px;
        border-radius: 5px;
        white-space: break-spaces;
        color: white;

        '>Felicidades lleva ahorrado ".Pesos($MiAhorro)."</b>";
        echo "<a class='btn btn-primary' style='
        
        margin-top: 6px;
        margin-left: 6px;
    '
    target=_blank 
    href='print_ahorro.php?id=".$NoSol."'

    >Reporte de Ahorro</a>";

        echo "</div>";
    }
    
    echo "</div>";
}


?>

<?php
// include("footer.php");
?>