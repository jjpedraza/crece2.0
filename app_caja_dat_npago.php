<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol = VarClean($_POST['NoSol']);
$NPago = VarClean($_POST['NPago']);
$sql = "select *  from cartera WHERE nosol='".$NoSol."' and NPago='".$NPago."'";        
    // echo $sql;
$rc= $db1 -> query($sql);    
if($Sol = $rc -> fetch_array())
{     
    echo "<div id='Info_".$Sol['NPago']."'  style='font-size:10pt; font-family:auto;'>";
    echo "<h5 style='color: black;text-align: center; border-top-left-radius: 6px; border-top-right-radius: 6px; margin-top: -9px; margin-right: -22px;margin-left: -24px;padding: 6px; '>Detalles del Pago No.".$Sol['NPago'].":</h5>";        
    echo "<table class='tabla' style='font-size:12pt;'>";
    echo "<tr style='font-size: 7pt; text-align: left; font-weight: initial; background-color: #c8c7c7; padding-left: 7px;'><th></th><th>Debe</th><th>Descuento</th><th style='text-align:center;' >Guardar</th><th></th></tr>";


    //Moratorios
    echo "<tr style='height:50px;'>";
    echo "<td valign=top style='text-align:left; font-size:10pt;'>Moratorios</td>";
        $UltimoPago = UltimoPago($NoSol);
        if ($UltimoPago == ''){
            echo "<td  valign=top  align=left id='_".$Sol['NPago']."_Mora_txt"."' title='".$Sol['mora_dias']." dias de Atraso'>".Pesos($Sol['mora_debe']);
        } else {
            echo "<td style='cursor:pointer; '  valign=top  align=left id='_".$Sol['NPago']."_Mora_txt"."' title='".$Sol['mora_dias']." dias de Atraso, Ultimo Pago: ".$UltimoPago."'>".Pesos($Sol['mora_debe']);
        }
        
        $DescuentosAutorizados = DescuentosMoratorios($NoSol,$NPago);
        if ($DescuentosAutorizados <>""){
            echo "<a class='' style='padding:2px; margin-left:2px;' href='#Descuentosde".$NPago."' rel=MyModal:open title='Descuento Autorizado = ".$DescuentosAutorizados.", haz clic para ver mas...'><img src='iconos/alerta2.png' style='width:16px;'></a>";
            echo "<div id='Descuentosde".$NPago."' class='MyModal'>";
                $sql="
                    select 
                    d.cantidad AS Descuento,
                	d.act_fecha as Fecha,
            	    (select cat_tipodescuento.TipoDescuento from cat_tipodescuento WHERe IdTipoDescuento =  d.IdTipoDescuento) as Tipo

                    from descuentos d where nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=1";
                    
                TableData($sql, "Descuentos Autorizados del Pago ".$Sol['NPago']);
        
            echo "<a href='app_solicitud.php?n=".$NoSol."' class='btn btn-secondary'>Gestionar Descuentos de este Contrato</a>";
            echo "</div>";
        }       
        echo "</td>";
        echo "<td  valign=top  align=center  width=30%>        
        <input style='font-size: 10pt; background-color: orange; color: white;' id='_".$Sol['NPago']."_Mora_Descuento' placeholder='' class='form-control' type='number' min='1' max='".$Sol['mora_debe']."' style='' value='0'>";
        echo "</td>";    
        echo "<td width=70px valign=top align=right>
        <img onclick='DescontarMora_save(".$Sol['NPago'].");'  src='iconos/check3.png' style='width:30px; cursor:pointer;'></td>";    
    echo "</tr>";



    //CargosSemanales
    echo "<tr style='height:50px;'>";
    echo "<td valign=top style='font-size:10pt;text-align:left;'>Cargos Semanales</td>";
        $UltimoPago = UltimoPago($NoSol);
        if ($UltimoPago == ''){
            echo "<td  valign=top  align=left id='_".$Sol['NPago']."_Mora_txt"."' title='".$Sol['Semanas']." semanas de Atraso * ".$Sol['CargoSemana']."'>".Pesos($Sol['CargoSemanal']);
        } else {
            echo "<td style='cursor:pointer; '  valign=top  align=left id='_".$Sol['NPago']."_Mora_txt"."' title='".$Sol['Semanas']." semanas de Atraso * ".$Sol['CargoSemana']."'>".Pesos($Sol['CargoSemanal']);
        }
        
        $DescuentosAutorizados = DescuentosList_cargosemanal($NoSol,$NPago);
        if ($DescuentosAutorizados <> ""){
            echo "<a class='' style='padding:2px; margin-left:2px;' href='#Descuentosde_cargosemanal".$NPago."' rel=MyModal:open title='Descuento Autorizado = ".$DescuentosAutorizados.", haz clic para ver mas...'><img src='iconos/alerta2.png' style='width:16px;'></a>";
            echo "<div id='Descuentosde_cargosemanal".$NPago."' class='MyModal'>";
                $sql="
                    select 
                    d.cantidad AS Descuento,
                	d.act_fecha as Fecha,
            	    (select cat_tipodescuento.TipoDescuento from cat_tipodescuento WHERe IdTipoDescuento =  d.IdTipoDescuento) as Tipo

                    from descuentos d where nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=4";
                    
                TableData($sql, "Descuentos Autorizados del Pago ".$Sol['NPago']);
        
            echo "<a href='app_solicitud.php?n=".$NoSol."' class='btn btn-secondary'>Gestionar Descuentos de este Contrato</a>";
            echo "</div>";
        }       
        echo "</td>";
        echo "<td  valign=top  align=center  width=30%>        
        <input style='font-size: 10pt; background-color: orange; color: white;' id='_".$Sol['NPago']."_CargoSemanal_Descuento' placeholder='' class='form-control' type='number' min='1' max='".$Sol['CargoSemanal']."' style='' value='0'>";
        echo "</td>";    
        echo "<td width=70px valign=top align=right>
        <img onclick='DescontarCargoSemanal_save(".$Sol['NPago'].");'  src='iconos/check3.png' style='width:30px; cursor:pointer;'></td>";    
    echo "</tr>";




    //Cargos Extraordinarios
    echo "<tr style='height:50px;'>";
    echo "<td align=left valign=top  ><a class='btn-Link' style='font-size:10pt;cursor:pointer;' onclick='CargoExtraOrdinario_agregar(".$NPago.");'  title='Clic aqui para agregar un cargo'>Cargos ExtraOrdinarios</a>";
    if ($Sol['CargoExtraOrdinario_cantidad'] > 0){
        echo "<a class='' style='padding:2px; margin-left:2px;' href='#List_cargoextraordinario".$NPago."' rel=MyModal:open title='Ver los cargos...'><img src='iconos/alerta2.png' style='width:16px;'></a>";
    }
    echo "</td>";

        
        
        echo "<td  valign=top  align=left id='_".$Sol['NPago']."_Mora_txt"."' title='".$Sol['CargoExtraOrdinario_concepto']."'>".Pesos($Sol['CargoExtraOrdinario_cantidad']);
        
        
        echo "<div id='List_cargoextraordinario".$NPago."' class='MyModal'>";
                $sql="
                select * from extraordinarios 

                where nosol='".$NoSol."' and no='".$NPago."' ";
                    
                TableData($sql, "Cargos Extraordinarios de No. ".$Sol['NPago']);
        
            
        echo "</div>";
        
        $DescuentosAutorizados = DescuentosList_cargoextraordinarios($NoSol,$NPago);
        if ($DescuentosAutorizados <> ""){
            echo "<a class='' style='padding:2px; margin-left:2px;' href='#Descuentosde_cargoextraordinario".$NPago."' rel=MyModal:open title='Descuento Autorizado = ".$DescuentosAutorizados.", haz clic para ver mas...'><img src='iconos/alerta2.png' style='width:16px;'></a>";
            echo "<div id='Descuentosde_cargoextraordinario".$NPago."' class='MyModal'>";
                $sql="
                    select 
                    d.cantidad AS Descuento,
                	d.act_fecha as Fecha,
            	    (select cat_tipodescuento.TipoDescuento from cat_tipodescuento WHERe IdTipoDescuento =  d.IdTipoDescuento) as Tipo

                    from descuentos d where nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=3";
                    
                TableData($sql, "Descuentos Autorizados del Pago ".$Sol['NPago']);
        
            echo "<a href='app_solicitud.php?n=".$NoSol."' class='btn btn-secondary'>Gestionar Descuentos de este Contrato</a>";
            echo "</div>";
        }       
        echo "</td>";
        echo "<td  valign=top  align=center  width=30%>        
        <input style='font-size: 10pt; background-color: orange; color: white;' id='_".$Sol['NPago']."_CargoExtraOrdinario_Descuento' placeholder='' class='form-control' type='number' min='1' max='".$Sol['CargoExtraOrdinario_cantidad']."' style='' value='0'>";
        echo "</td>";    
        echo "<td width=70px valign=top align=right>
        <img onclick='DescontarCargoExtraOrdinario_save(".$Sol['NPago'].");'  src='iconos/check3.png' style='width:30px; cursor:pointer;'></td>";    
    echo "</tr>";



    
    //Interes de Financiamiento
    echo "<tr style='height:50px;'>";
    echo "<td valign=top style='text-align:left; font-size:10pt; cursor:pointer;' title='Interes de Financiamiento'><b>Fi</b>nanciamiento<br> <span style='font-size:7pt;'> (".PorcentajeFi($NoSol)."% Mensual)</span></td>";
        $UltimoPago = UltimoPago($NoSol);
        if ($UltimoPago == ''){
            echo "<td  valign=top  align=left id='_".$Sol['NPago']."_Mora_txt"."' title=''>".Pesos($Sol['interes']);
        } else {
            echo "<td style='cursor:pointer; '  valign=top  align=left id='_".$Sol['NPago']."_Mora_txt"."' title=''>".Pesos($Sol['interes']);
        }
        
        $DescuentosAutorizados = DescuentosList_financiamiento($NoSol,$NPago);
        if ($DescuentosAutorizados <>""){
            echo "<a class='' style='padding:2px; margin-left:2px;' href='#DescuentosFide".$NPago."' rel=MyModal:open title='Descuento Autorizado = ".$DescuentosAutorizados.", haz clic para ver mas...'><img src='iconos/alerta2.png' style='width:16px;'></a>";
            echo "<div id='DescuentosFide".$NPago."' class='MyModal'>";
                $sql="
                    select 
                    d.cantidad AS Descuento,
                	d.act_fecha as Fecha,
            	    (select cat_tipodescuento.TipoDescuento from cat_tipodescuento WHERe IdTipoDescuento =  d.IdTipoDescuento) as Tipo

                    from descuentos d where nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=2";
                    
                TableData($sql, "Descuentos Autorizados del Pago ".$Sol['NPago']);
        
            echo "<a href='app_solicitud.php?n=".$NoSol."' class='btn btn-secondary'>Gestionar Descuentos de este Contrato</a>";
            echo "</div>";
        }       
        echo "</td>";
        echo "<td  valign=top  align=center  width=30%>        
        <input style='font-size: 10pt; background-color: orange; color: white;' id='_".$Sol['NPago']."_Fi_Descuento' placeholder='' class='form-control' type='number' min='1' max='".$Sol['mora_debe']."' style='' value='0'>";
        echo "</td>";    
        echo "<td width=70px valign=top align=right>
        <img onclick='DescontarFi_save(".$Sol['NPago'].");'  src='iconos/check3.png' style='width:30px; cursor:pointer;'></td>";    
    echo "</tr>";



    //Capital
    echo "<tr style='height:50px;'>";
    echo "<td valign=top style='text-align:left; font-size:10pt; cursor:pointer;' title='Interes de Financiamiento'>Capital</td>";
        echo "<td  valign=top  align=left id='_".$Sol['NPago']."_Mora_txt"."' title=''>".Pesos($Sol['abono']);
        
        $DescuentosAutorizados = DescuentosList_capital($NoSol,$NPago);
        if ($DescuentosAutorizados <>""){
            echo "<a class='' style='padding:2px; margin-left:2px;' href='#DescuentosCapitalde".$NPago."' rel=MyModal:open title='Descuento Autorizado = ".$DescuentosAutorizados.", haz clic para ver mas...'><img src='iconos/alerta2.png' style='width:16px;'></a>";
            echo "<div id='DescuentosCapitalde".$NPago."' class='MyModal'>";
                $sql="
                    select 
                    d.cantidad AS Descuento,
                	d.act_fecha as Fecha,
            	    (select cat_tipodescuento.TipoDescuento from cat_tipodescuento WHERe IdTipoDescuento =  d.IdTipoDescuento) as Tipo

                    from descuentos d where nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=5";
                    
                TableData($sql, "Descuentos Autorizados del Pago ".$Sol['NPago']);
        
            echo "<a href='app_solicitud.php?n=".$NoSol."' class='btn btn-secondary'>Gestionar Descuentos de este Contrato</a>";
            echo "</div>";
        }       
        echo "</td>";
        echo "<td  valign=top  align=center  width=30%>        
        <input style='font-size: 10pt; background-color: orange; color: white;' id='_".$Sol['NPago']."_Capital_Descuento' placeholder='' class='form-control' type='number' min='1' max='".$Sol['mora_debe']."' style='' value='0'>";
        echo "</td>";    
        echo "<td width=70px valign=top align=right>
        <img onclick='DescontarCapital_save(".$Sol['NPago'].");'  src='iconos/check3.png' style='width:30px; cursor:pointer;'></td>";    
    echo "</tr>";




    //Seguro 
    echo "<tr style='height:50px;'>";
    echo "<td valign=top style='text-align:left; font-size:10pt; cursor:pointer;' title='Interes de Financiamiento'>Seguro</td>";
        echo "<td  valign=top  align=left id='_".$Sol['NPago']."_seguro"."' title=''>".Pesos($Sol['cargoseguro']);
        
        echo "</td>";
        echo "<td  valign=top  align=center  width=30%>        
        ";
        echo "</td>";    
        echo "<td width=70px valign=top align=right>
        ";
    echo "</tr>";



    echo "<tr style='height:50px; background-color:green;'>";
    echo "<td align=left>TOTAL</td>";
    echo "<td align=left>";
    echo "<b>". Pesos(DebePago($NoSol,$NPago))."</b>";

    $DescuentosAutorizados = DescuentosList_($NoSol,$NPago);
        if ($DescuentosAutorizados <>""){
            echo "<a class='' style='padding:2px; margin-left:2px;' href='#Descuentos0de".$NPago."' rel=MyModal:open title='Descuento Autorizado = ".$DescuentosAutorizados.", haz clic para ver mas...'><img src='iconos/alerta2.png' style='width:16px;'></a>";
            echo "<div id='Descuentos0de".$NPago."' class='MyModal'>";
                $sql="
                    select 
                    d.cantidad AS Descuento,
                    d.concepto,
                	d.act_fecha as Fecha,
            	    (select cat_tipodescuento.TipoDescuento from cat_tipodescuento WHERe IdTipoDescuento =  d.IdTipoDescuento) as Tipo

                    from descuentos d where nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=0";
                    
                TableData($sql, "Descuentos Autorizados del Pago ".$Sol['NPago']);
        
            echo "<a href='app_solicitud.php?n=".$NoSol."' class='btn btn-secondary'>Gestionar Descuentos de este Contrato</a>";
            echo "</div>";
        }       

    echo "</td>";
    echo "<td  valign=top  align=center  width=30%>";    
    echo "</td>";    
    echo "<td width=70px valign=top align=right>";    
    echo "</tr>";




    echo "</table>";

    echo "</div>";
}
?>

<?php
// include("footer.php");
?>