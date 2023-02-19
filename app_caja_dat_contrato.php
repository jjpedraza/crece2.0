<?php
include("seguridad.php");  
require ("rintera-config.php");
require ("components.php");
// require ("app_funciones.php");

$NoSol = VarClean($_POST['NoSol']);
$PagosQueDebe = NDebe($NoSol);
if (Contrato_Activo($NoSol)==FALSE){
    Toast("Este Contrato ".$NoSol." no disponible ",2,"");
} else {

if ($PagosQueDebe<= 0){
    Toast("El Contrato ".$NoSol." no debe ningun pago",2,"");
    echo "<script>AhorroDiv();</script>";
} 

    $NSelect = VarClean($_POST['n']);

    if ($NSelect == 0) {

        if (isset($_POST['mode'])){
            $sql = "select * from cartera WHERE nosol='".$NoSol."'  order by NPago + 0";
        } else {
            $sql = "select * from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' order by NPago + 0";
        }
        // echo $sql;
        $r= $db1 -> query($sql);
        if (isset($_POST['mode'])){
            echo "<img title='PAGOS QUE DEBE' onclick='CargaContrato(0);' src='iconos/arriba.png' style='width:12px; cursor:pointer;'>";
        } else {
            echo "<img title='TODOS LOS PAGOS' onclick='CargaContrato_full(0);' src='iconos/abajo.png' style='width:12px; cursor:pointer;'>";
            

        }
        echo "<table class='tabla'>";
        echo "<th>No</th>";
        echo "<th>Debe</th>";
        echo "<th>Atraso | Fecha</th>";
        
        $Curp = "";
        $GranTotal = 0;

        while($Sol = $r -> fetch_array()) {          

            if ($Sol['CarteraEstatus']=='VENCIDO'){
                echo "<tr style='background-color:red;'>";
            } else {
                if ($Sol['CarteraEstatus']=='PAGADO'){
                    echo "<tr style='background-color:green;'>";
                } else {
                    echo "<tr>";
                }
                
            }
            
            echo "<td>
            <a title='Haz clic aqui para Ver Detalles de Este Pago'  class='btn-Link' style='font-size:9pt;cursor:pointer;' 
            onclick='CajaNPago(".$Sol['nosol'].",".$Sol['NPago'].")';
            >".
            $Sol['NPago'].
            "</a></td>";
            
            
            echo "<td><a title='Haz clic aqui para escribir esta cantidad en RECIBIR' style='font-size:9pt;cursor:pointer;' class='btn-Link' onclick='CajaComponents(".$Sol['NPago'].");'>".Pesos($Sol['TOTAL'])."</a></td>";
            if ($Sol['CarteraEstatus']=='VENCIDO'){            
                echo "<td>".DiasAmigables($Sol['mora_dias'])."</td>";
            } else {
                echo "<td>".$Sol['fecha']."</td>";
            }
            

            echo "</tr>";
            $Curp = $Sol['CURP'];
            $GranTotal = $GranTotal + $Sol['TOTAL'];
        }
        if ($GranTotal<=0){$GranTotal=0;}
        echo "<td colspan='3' style='background-color:orange; cursor:pointer;' onclick='CajaComponents(0);'>
        <b style='font-size:14pt;'>".Pesos($GranTotal)."</b><br>
        <cite>".NumToLetras_Moneda($GranTotal)."</cite>
        </td>";
        echo "</table>";


                        
            

            

        echo "<hr><a target=_blank class='btn btn-warning' href='print_edocuenta.php?id=".$NoSol."'>Edo.Cuenta</a> ";
        echo "<a title='Estado de cuenta con descripcion muy detallada' target=_blank class='btn btn-warning' href='print_edocuenta.php?id=".$NoSol."&full='><img src='iconos/correcto1.png' style='width:25px;'></a><br> ";
        echo "<a target=_blank class='btn btn-secondary' href='app_solicitud.php?n=".$NoSol."'>Cuenta</a> ";
        echo "<a target=_blank class='btn btn-secondary' href='app_carnet.php?id=".$Curp."'>Cliente</a>";

        unset($r,$sql, $Sol);

        TicketsHoy($NoSol);
        echo "<script>CajaComponents(0);</script>";



    } else {//Selecciono un pago

    }
}
?>


<script>
    function DescontarMora_save(NPago){
        NoSol = $('#NoSol').val();
        
        Descuento = $('#_'+NPago+'_Mora_Descuento').val();
        console.log('Descuento='+Descuento);
        $('#PreLoader').show();           
        $.ajax({
            url: 'app_descuento_mora.php',
            type: 'post',        
            data: {
                NoSol:NoSol, NPago:NPago, Descuento:Descuento
                
            },
        success: function(data){
            $('#R').html(data);                
            $('#PreLoader').hide();
            
        }
        });

        
    }

    function DescontarCargoSemanal_save(NPago){
        NoSol = $('#NoSol').val();
        
        Descuento = $('#_'+NPago+'_CargoSemanal_Descuento').val();
        console.log('Descuento='+Descuento);
        $('#PreLoader').show();           
        $.ajax({
            url: 'app_descuento_cargosemanal.php',
            type: 'post',        
            data: {
                NoSol:NoSol, NPago:NPago, Descuento:Descuento
                
            },
        success: function(data){
            $('#R').html(data);                
            $('#PreLoader').hide();
            
        }
        });

        
    }

    function DescontarCargoExtraOrdinario_save(NPago){
        NoSol = $('#NoSol').val();
        
        Descuento = $('#_'+NPago+'_CargoExtraOrdinario_Descuento').val();
        console.log('Descuento='+Descuento);
        $('#PreLoader').show();           
        $.ajax({
            url: 'app_descuento_cargoextraordinario.php',
            type: 'post',        
            data: {
                NoSol:NoSol, NPago:NPago, Descuento:Descuento
                
            },
        success: function(data){
            $('#R').html(data);                
            $('#PreLoader').hide();
            
        }
        });

        
    }


    function DescontarFi_save(NPago){
        NoSol = $('#NoSol').val();
        
        Descuento = $('#_'+NPago+'_Fi_Descuento').val();
        console.log('Descuento='+Descuento);
        $('#PreLoader').show();           
        $.ajax({
            url: 'app_descuento_fi.php',
            type: 'post',        
            data: {
                NoSol:NoSol, NPago:NPago, Descuento:Descuento
                
            },
        success: function(data){
            $('#R').html(data);                
            $('#PreLoader').hide();
            
        }
        });

        
    }

    function DescontarCapital_save(NPago){
        NoSol = $('#NoSol').val();
        
        Descuento = $('#_'+NPago+'_Capital_Descuento').val();
        
        $('#PreLoader').show();           
        $.ajax({
            url: 'app_descuento_capital.php',
            type: 'post',        
            data: {
                NoSol:NoSol, NPago:NPago, Descuento:Descuento
                
            },
        success: function(data){
            $('#R').html(data);                
            $('#PreLoader').hide();
            
        }
        });

        
    }



    function CargoExtraOrdinario_agregar(NPago){
        NoSol = $('#NoSol').val();
        var Cargo_concepto = prompt("Concepto del Cargo ExtraOrdinario", "");
        if (Cargo_concepto != ''){
            var Cargo_cantidad = prompt("Cantidad para " + Cargo_concepto, "");
            
            if (Cargo_cantidad > 0){
                    $('#PreLoader').show();           
                    $.ajax({
                        url: 'app_dat_cargoextraordinario_agregar.php',
                        type: 'post',        
                        data: {
                            NoSol:NoSol, NPago:NPago, Cargo_concepto:Cargo_concepto, Cargo_cantidad:Cargo_cantidad
                            
                        },
                    success: function(data){
                        $('#R').html(data);                
                        $('#PreLoader').hide();
                        
                    }
                    });
            } else {
                $.toast('Cargo '+Cargo_concepto+' cancelado');   
            }
            

    } else {
        $.toast('Cargo cancelado');   
    }
        
    }

    function DescontarMora_calcular(NPago){
        Moratorios = $('#_'+NPago+'_Mora_debe').val();
        Porcentaje = $('#_'+NPago+'_Mora_DescontarPorciento').val();
        
        // console.log('NPago'+NPago);
        // console.log('Moratorios = '+Moratorios);
        // console.log('Porcentaje = '+Porcentaje);
        
        Descuento = Moratorios / 100 * Porcentaje;
        
        
        // console.log('Descuento = '+Descuento);
        
  

        $('#_'+NPago+'_Mora_Descuento').val(Descuento.toFixed(2));




    }
</script>
<?php
// include("footer.php");
?>