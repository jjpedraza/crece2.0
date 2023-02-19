<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$Anio = VarClean($_POST['year']);



        $sql = "select Anio, Mes, FORMAT(PagoCorriente,2)  as Esperado from proyeccion WHERE Anio > = ".$Anio;

    
   
        echo "Proyeccion sobre todos los años posibles de calculo<br>";
        if (ProyeccionCheck(1)==TRUE){

            $QueryG = "select DISTINCT a.Anio as Label,
	
            (select sum(PagoCorriente) from proyeccion where Anio = a.Anio) as Data,
            (select sum(Ingresos) from proyeccion where Anio = a.Anio) as Data2

        
            from proyeccion a WHERE Anio >=".$Anio." 
            order by Anio";
            $rF= $db1 -> query($QueryG);    
            $Datas = 0; $Labels=""; $Datas2 = 0;
            while($Fr = $rF -> fetch_array()) {   
                $Datas.= intval($Fr['Data']).", ";
                $Datas2.= intval($Fr['Data2']).", ";
                $Labels.="'".$Fr['Label']."',";
            }
            unset($rf);unset($Fr);
            $Datas = substr($Datas, 0, -1); //quita la ultima coma.
            $Datas2.=  substr($Datas2, 0, -1);
            $Labels = substr($Labels, 0, -1); //quita la ultima coma.
            
            echo '<div style="
            width: 40%;
            height: 400px;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 5px;
            border-radius: 4px;
            margin: 5px;
            display: inline-block;
            vertical-align: top;
            margin-bottom:100px;
            " class="">';
            GraficaProyeccion3($Labels, $Datas, $Datas2, "Proyeccion vs Ingresos","#000000");
            echo '</div>';




            $QueryG = "select 
            CONCAT(MES, ' ',Anio) as Label,
            PagoCorriente as Data,
            Ingresos as Data2
        
            from proyeccion a  WHERE Anio >=".$Anio." 
            order by Anio, M";
            $rF= $db1 -> query($QueryG);    
            $Datas = 0; $Labels="";$Datas2=0;
            while($Fr = $rF -> fetch_array()) {   
                $Datas.= intval($Fr['Data']).", ";
                $Datas2.= intval($Fr['Data2']).", ";
                $Labels.="'".$Fr['Label']."',";
            }
            unset($rf);unset($Fr);
            $Datas = substr($Datas, 0, -2); //quita la ultima coma.
            $Datas2 = substr($Datas2, 0, -2); //quita la ultima coma.
            
            // echo $Datas;
            
            $Labels = substr($Labels, 0, -1); //quita la ultima coma.
            
            // echo $Datas;
            // echo "<hr>";
            // echo $Labels;
     

            echo '<div style="
            width: 40%;
            height: 400px;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 5px;
            border-radius: 4px;
            margin: 5px;
            display: inline-block;
            vertical-align: top;
            margin-bottom:100px;
            " class="">';
            
            GraficaProyeccion2($Labels, $Datas, $Datas2, "Proyeccion vs Ingresos","#000000");
            echo '</div>';

        } else {
            echo '
            <div class="alert alert-warning" role="alert">
            Informacion insuficiente en la base de datos para generar una proyeccion
            </div>';
        }
   
    
    

    

?>

<?php
// include("footer.php");
?>