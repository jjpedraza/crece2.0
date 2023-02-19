<?php
// include("head.php");

// include("header.php");
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");


?>


<?php
     $Datas = ""; $Labels="";
     $QueryG = "
     select DISTINCT c.tipo, (select count(*) from contratos where tipo = c.tipo) as Contratos from contratos c where tipo <> ''
     ";
     $rF= $db1 -> query($QueryG);    
     $Datas = ""; $Labels="";
     while($Fr = $rF -> fetch_array()) {   
         $Datas.= $Fr['Contratos'].", ";
         $Labels.="'".$Fr['tipo']."',";
     }
     unset($rf);unset($Fr);
     $Datas = substr($Datas, 0, -1); //quita la ultima coma.
     $Labels = substr($Labels, 0, -1); //quita la ultima coma.
         echo '<div style="" class="Graficas">';
         GraficaPie($Labels,$Datas,"Tipos de Creditos",1);
         echo '</div>';


       $QueryG = "
            select * from estadistica
        ";
        $rc= $db1 -> query($QueryG);    
        if($f = $rc -> fetch_array())
        { 
            $Datas= $f['CarteraActiva_recuperacion'].", ".$f['CarteraVencida_recuperacion'];
            $Labels="'Saldo', 'Moratorios'";
        } else { return '';}
        
        unset($rc, $f, $QueryG);

            echo '<div style="" class="Graficas">';
            GraficaBar($Labels,$Datas,"Saldos y Moratorios");
            echo '</div>';
        unset($rF, $Datas, $Labels);
    ?>


    <?php
        $Datas = ""; $Labels="";
        $QueryG = "
            select * from estadistica
        ";
        $rc= $db1 -> query($QueryG);    
        if($f = $rc -> fetch_array())
        { 
            $Datas= $f['CarteraActiva'].", ".$f['CarteraVencida'];
            $Labels="'Contratos con Saldo ', 'Contratos Vencidos'";
        } else { return '';}
       
        unset($rc, $f, $QueryG);
        // $Datas = substr($Datas, 0, -1); //quita la ultima coma.
        // $Labels = substr($Labels, 0, -1); //quita la ultima coma.
        // echo $Datas.' | '.$Labels;
            echo '<div style="" class="Graficas">';
            GraficaPie($Labels,$Datas,"Cartera Activa y Vencida ");
            echo '</div>';
        ?>




        
    <?php
        $QueryG = "
             
      
	
        -- SET lc_time_names = 'es_MX'
        select DISTINCT CONCAT(MONTHNAME(a.fechacontrato), YEAR(a.fechacontrato)) as MES,	 
        (select count(*) from cuentas where MONTHNAME(fechacontrato) = MONTHNAME(a.fechacontrato) and YEAR(fechacontrato) = YEAR(a.fechacontrato) )as contratos
        
        
        from cuentas a WHERE fechacontrato<>'0000-00-00' order by fechacontrato
   
        ";
        $rF= $db1 -> query($QueryG);    
        $Datas = ""; $Labels="";
        while($Fr = $rF -> fetch_array()) {   
            $Datas.= $Fr['contratos'].", ";
            $Labels.="'".$Fr['MES']."',";
        }
        unset($rf);unset($Fr);
        $Datas = substr($Datas, 0, -1); //quita la ultima coma.
        $Labels = substr($Labels, 0, -1); //quita la ultima coma.
            echo '<div style="" class="Graficas">';
            GraficaBarLine($Labels,$Datas,"Contrataciones",1);
            echo '</div>';
        ?>



        
    <?php
        // $QueryG = "
             
      
	
        // select DISTINCT c.tipo, (select count(*) from contratos where tipo = c.tipo) as Contratos from contratos c where tipo <> ''
   
        // ";
        // $rF= $db1 -> query($QueryG);    
        // $Datas = ""; $Labels="";
        // while($Fr = $rF -> fetch_array()) {   
        //     $Datas.= $Fr['contratos'].", ";
        //     $Labels.="'".$Fr['MES']."',";
        // }
        // unset($rf);unset($Fr);
        // $Datas = substr($Datas, 0, -1); //quita la ultima coma.
        // $Labels = substr($Labels, 0, -1); //quita la ultima coma.
        //     echo '<div style="" class="Graficas">';
        //     GraficaBarLine($Labels,$Datas,"Contrataciones",1);
        //     echo '</div>';
        ?>

    

<?php
// include("footer.php");
?>