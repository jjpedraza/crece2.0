<?php
set_time_limit(1200);	
require("FormElement.php");

//FUNCIONES DE LAS APLICACIONES
function Proyeccion_CrearTabla($ALL = TRUE){
    require("rintera-config.php");
    if ($ALL == TRUE ){
        // echo "Calculando proyeccion basada en todos los pagos que se han recibido y los que aun no se pagan. Recomendable para analizar lineas
        // de proyeccion versus ingresos";
        $sql = "
        SET lc_time_names = 'es_ES';
        delete from proyeccion;
        insert proyeccion (
        select 
            DISTINCT 
                YEAR(Pagos.fecha) as Anio,
                MONTH(Pagos.fecha) as M,
                MONTHNAME(Pagos.fecha) as Mes,
                LAST_DAY(Pagos.fecha) as FechaCalculo,			
                0 as PagoCorriente,
                0 as PagoMoratorio,
                NOW() as Actualizacion
        from tblpagos Pagos
      
        );          
        ";  
        if (!$db1->multi_query($sql)) {
            
            echo "Falló la multiconsulta: (" . $mysqli->errno . ") " . $mysqli->error;
            return FALSE;
        } else {
            return TRUE;
        }
    } else {
        // echo "Calculando proyeccion sobre los pagos que aun se han pagado.";
        

      
        $sql = "
        SET lc_time_names = 'es_ES';
        delete from proyeccion;
        insert proyeccion (
        select 
            DISTINCT 
                YEAR(Pagos.fecha) as Anio,
                MONTH(Pagos.fecha) as M,
                MONTHNAME(Pagos.fecha) as Mes,
                LAST_DAY(Pagos.fecha) as FechaCalculo,			
                0 as PagoCorriente,
                0 as PagoMoratorio,
                NOW() as Actualizacion
        from tblpagos Pagos
        WHERE  EstadoPago='SIN PAGAR'
        );          
        ";  
        if (!$db1->multi_query($sql)) {
            
            echo "Falló la multiconsulta: (" . $mysqli->errno . ") " . $mysqli->error;
            return FALSE;
        } else {
            return TRUE;
        }
        
        
}
}


function Proyeccion_Generate($ALL){
require("rintera-config.php");
    
//1.- Crear la tabla de proyeccion, basada en los pagos activos (Sin Pagar)
// Proyeccion_CrearTabla(TRUE) <- Todos los pagos (historia de pagos y no pagados)
// Proyeccion_CrearTabla(FALSE) <-- cartera vencida, tabla con pagos que aun no se debe.

if (Proyeccion_CrearTabla($ALL)==TRUE){
    sleep(3);
    // echo "- Tabla creada de proyeccion: <br>";
    $r= $db1 -> query("select * from proyeccion");
    while($f = $r -> fetch_array()) {      
        if ($ALL == TRUE)  { //<-- se necesita el calculo completo de lo esperado incluso incluir lo pagado
            $QueryCalculo = "        
                SELECT	
                    
                sum(abono) + sum(interes) + sum(iva)  as PagoCorriente

                FROM
                tabladepagos
                WHERE 	
                    YEAR(fin) = ".$f['Anio']." and MONTH(fin) = ".$f['M']."
            ";
        } else{

        
            $QueryCalculo = "        
                SELECT	
                    
                sum(abono) + sum(interes) + sum(iva)  as PagoCorriente

                FROM
                tabladepagos
                WHERE 	
                estado<>'X' 
                and YEAR(fin) = ".$f['Anio']." and MONTH(fin) = ".$f['M']."
            ";
        }
        $PagoCorriente = 0; $OK = ""; $c = 0; $Ingresos = 0;
        $RCalc= $db1 -> query($QueryCalculo);
        if($Calculo = $RCalc -> fetch_array())
        {
            $PagoCorriente = $Calculo['PagoCorriente'];

            $QueryUpdate="UPDATE proyeccion  SET PagoCorriente='".$PagoCorriente."'  WHERE Anio='".$f['Anio']."' and M = '".$f['M']."'";            
            if ($db1->query($QueryUpdate) == TRUE)
            {$OK = "OK"; $c = $c+1; }
            else {$OK = "X";}
            unset($QueryCalculo);
        } 
      
        unset($RCalc, $Calculo, $QueryCalculo);


        //Calclo de ingresos
        $QueryCalculo = "        
            SELECT	
                
            sum(abono) + sum(interes) + sum(iva)  as Ingresos

            FROM
            tabladepagos
            WHERE 	
            estado='X' 
            and YEAR(fin) = ".$f['Anio']." and MONTH(fin) = ".$f['M']."
        ";
        $PagoCorriente = 0; $OK = ""; $c2 = 0; $Ingresos;
        $RCalc= $db1 -> query($QueryCalculo);
        if($Calculo = $RCalc -> fetch_array())
        {
            $Ingresos = $Calculo['Ingresos'];

            $QueryUpdate="UPDATE proyeccion  SET Ingresos='".$Ingresos."'  WHERE Anio='".$f['Anio']."' and M = '".$f['M']."'";            
            if ($db1->query($QueryUpdate) == TRUE)
            {$OK = "OK"; $c2 = $c2+1; }
            else {$OK = "X";}
            unset($QueryCalculo);
        } 

        ///TEST
        // echo "<br>".$f['FechaCalculo']."->".$PagoCorriente."->".$OK;
        unset($RCalc, $Calculo, $QueryCalculo);



    }
    if ($c>0){
        // DynamicTable_MySQL("select Anio, Mes, PagoCorriente from proyeccion", "DivProyeccion", "TblProyeccion", "tabla", 0, 1);
        return TRUE;
    } else {
        return FALSE;
    }

    
} else {
    Error("Error al crear al preparar la tabla para proyecciones");
}

}

function ProyeccionCheck($modo){
    require("rintera-config.php");   
    $AnioActual = date("Y");
    if ($modo==0){
        $sql = "select count(*) as n from proyeccion where Anio>=".$AnioActual;
    } else {
        $sql = "select count(*) as n from proyeccion";
    }
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    {
        if ($f['n']== 0 ){
            Toast("No hay informacion suficiente en la base de datos para calcular una proyeccion actual.",3,"");
            return FALSE;
        } else {
            return TRUE;
        }
        
    } else {
        return FALSE;
    }

}


function TableData($QueryM, $Tit="", $IdDiv="TableDataDiv", $IdTabla="TableData_table", $Clase="", $Tipo=2){
require("rintera-config.php");
	$IdDiv = $IdDiv.EasyName();
    $IdTabla = $IdTabla.EasyName();
        $r= $db1 -> query($QueryM);
        // echo $sql;
        // var_dump($r);
        
        $tbCont = '<div id="'.$IdDiv.'" class="container '.$Clase.'" style="    background-color: #ffffffc9;
        padding: 10px;
        border-radius: 5px;
        margin-top: 20px;">
        <h3>'.$Tit.' </h3>
        <table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';
    $tabla_titulos = ""; $cuantas_columnas = 0;
        $r2 = $db1 -> query($QueryM); 
        // echo $sql;
        // var_dump($r2);
        
        while($finfo = $r2->fetch_field())
        {//OBTENER LAS COLUMNAS

                /* obtener posición del puntero de campo */
                $currentfield = $r2->current_field;       
                $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
                $cuantas_columnas = $cuantas_columnas + 1;        
        }

        $tbCont = $tbCont."  
        <thead>
        <tr>
            ".$tabla_titulos."  
        </tr>
        </thead>"; //Encabezados
        $tbCont = $tbCont."<tbody class='tabla'>";
        $cuantas_filas=0;
        $r = $db1 -> query($QueryM); while($f = $r-> fetch_row())
        {//LISTAR COLUMNAS

            $tbCont = $tbCont."<tr>";        
            for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                $tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";       
                }

            $tbCont = $tbCont."</tr>";
            $cuantas_filas = $cuantas_filas + 1;        
        }

        $tbCont = $tbCont."</tbody>";
        $tbCont = $tbCont."</table></div>";
	
	echo  $tbCont;

	$Botones = "
	dom: 'Bfrtip',
	buttons: [
		{
			extend:    'copyHtml5',
			text:      '<i class=\"fa fa-files-o\"></i>',
			titleAttr: 'Copy'
		},
		{
			extend:    'excelHtml5',
			text:      '<i class=\"fa fa-file-excel-o\"></i>',
			titleAttr: 'Excel'
		},
		{
		    extend:    'csvHtml5',
		    text:      '<i class=\"fa fa-file-text-o\"></i>',
		    titleAttr: 'CSV'
		},
		{
		    extend:    'pdfHtml5',
		    text:      '<i class=\"fa fa-file-pdf-o\"></i>',
		    titleAttr: 'PDF'
		}
	]
	";
		switch ($Tipo) {
			case 1: //Scroll Vertical
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollY":        "200px",
							"scrollCollapse": true,
							"paging":         false,
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
				break;

			case 2: //Scroll Horizontal
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollX": true,
							"scrollCollapse": true,
							"paging":         true,
							"language": {
								"decimal": ",",
								"thousands": "."
								
							}
							,responsive: true
							,'.$Botones.'
						} );
					} );
					</script>';
				break;
			
			default:
				echo '<script>
				$(document).ready(function() {
					$("#'.$IdTabla.'").DataTable( {
						"language": {
							"decimal": ",",
							"thousands": "."
						}
					} );
				} );
				</script>';
		}
       

}



function NoSol_existe($nosol){
require("rintera-config.php");   
    $sql = "select count(*) as n from cuentas where nosol='".$nosol."'";
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    {
        if ($f['n'] > 0 ) {
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}

function NoSol_to_Curp($nosol){
require("rintera-config.php");   
    $sql = "select * from cuentas where nosol='".$nosol."'";
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    {
        return $f['curp'];
    } else {
        return "";
    }
}


function NoSol_generar($IdSucursal){
require("rintera-config.php");   
    //NOMECLATURA DE CONTRATO O SOLICITUD
    // YEARMMDDIDN0000
    // AÑO-MES-DIA-IDSUCURSAL-CONSECUTIVO
    $Anio = date('Y');
    $Mes = date('m');
    $Dia = date('j');
    $Dia = str_pad($Dia,2,0,STR_PAD_LEFT); //Llena de 0 los 5 espacios, 1 -> 00001

    $ProximoNo_sql = "select count(*) + 1 as ProximoNo  from cuentas where IdSucursal =  ".$IdSucursal;
    // echo $ProximoNo_sql;
    $r = $db1->query($ProximoNo_sql);
    if ($f = $r->fetch_array()){
        $ProximoNo = $f['ProximoNo'];
    } else {
        $ProximoNo = 0;
    }
    unset($r,$f);
    
    $ProximoNo = str_pad($ProximoNo,5,0,STR_PAD_LEFT); //Llena de 0 los 5 espacios, 1 -> 00001
    $NoSol = $Anio.$Mes.$Dia.$IdSucursal.$ProximoNo;

    return $NoSol;
    // $no_sol = date('Ymj').EasyName($LoPrimero="");

    // while (NoSol_existe($no_sol) == TRUE) {
    //     $no_sol = date('Ymj').EasyName($LoPrimero="");
    // } 
    // return $no_sol;
}


function Cliente_Nombre($IdCliente){
    require("rintera-config.php");   
        $sql = "select nombre as valor from clientes where curp='".$IdCliente."'";
        $rc= $db1 -> query($sql);    
        if($f = $rc -> fetch_array())
        { 
            return $f['valor'];
        } else { return '';}
    
        
}

    
function Cliente_Grupo_cargo($IdCliente){
    require("rintera-config.php");   
        $sql = "select * from clientes where curp='".$IdCliente."'";
        $rc= $db1 -> query($sql);    
        if($f = $rc -> fetch_array())
        { 
            return $f['grupo_cargo'];
        } else { return '';}
    
        
}

    
function Cliente_IdGrupo($IdCliente){
    require("rintera-config.php");   
        $sql = "select * from clientes where curp='".$IdCliente."'";
        $rc= $db1 -> query($sql);    
        if($f = $rc -> fetch_array())
        { 
            return $f['IdGrupo'];
        } else { return '';}
    
        
}
     

function Cuenta_NPagos($nosol){
    require("rintera-config.php");   
        $sql = "select count(*) as n from cartera where nosol='".$nosol."'";
        $rc= $db1 -> query($sql);    
        if($f = $rc -> fetch_array())
        { 
            return $f['n'];
        } else { return '';}
    
        
}

function Cliente_Telefono($IdCliente){
require("rintera-config.php");   
    $sql = "select telefono as valor from clientes where curp='".$IdCliente."'";
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['valor'];
    } else { return '';}

    
}

function Cliente_Domicilio($IdCliente){
require("rintera-config.php");   
    $sql = "select CONCAT(domicilio, ', ',municipio,'. ',estado) as valor from clientes where curp='".$IdCliente."'";
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['valor'];
    } else { return '';}

    
}


function Solicitud_FechaUltimoPago($NoSol){
require("rintera-config.php");   
    $sql = "select fin as valor from tabladepagos where nosol='".$NoSol."' order by no DESC limit 1";
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['valor'];
    } else { return '';}

    
}

function DiasAmigables($sum) {
    $years = floor($sum / 365);
    $months = floor(($sum - ($years * 365))/30.5);
    $days = ($sum - ($years * 365) - ($months * 30.5));
    // echo “Days received: ” . $sum . “ days <br />”;
    return $years . " años, " . $months . " meses, ". round($days) . " dias";
}

function NDebe($NoSol){
    require("rintera-config.php");   
    $sql = "select count(*) as n from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' order by NPago + 0";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['n'];
    } else { return 0;}
    
        
}

function DebeTotal($NoSol){
    require("rintera-config.php");   
    $sql = "select sum(TOTAL) as total from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' order by NPago + 0";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['total'];
    } else { return 0;}
    
        
}

function DebePago($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "select sum(TOTAL) as total from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' and NPago='".$NPago."'";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['total'];
    } else { return 0;}
    
        
}


function DebePago_moratorios($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "select sum(mora_debe) as total from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' and NPago='".$NPago."'";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['total'];
    } else { return 0;}
    
        

}


function DescuentosList_mora($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "
    select 
        GROUP_CONCAT(Resumen) as Descuentos
        from descuentos     
    WHERE nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento='1'";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Descuentos'];
    } else { return "";}
    
        
}


function DescuentosMoratorios($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "
    select 
        sum(cantidad) as Descuentos
    from descuentos     
    WHERE nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento='1'";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Descuentos'];
    } else { return 0;}
    
        
}



function DebePago_cargosemanal($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "select sum(CargoSemanal) as total from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' and NPago='".$NPago."'";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['total'];
    } else { return 0;}
    
        
}


function DescuentosList_cargosemanal($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "
    select 
        GROUP_CONCAT(Resumen) as Descuentos
        from descuentos     
    WHERE nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=4";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Descuentos'];
    } else { return "";}
    
        
}


function DebePago_cargoextraordinarios($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "select sum(CargoExtraOrdinario_cantidad) as total from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' and NPago='".$NPago."'";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['total'];
    } else { return 0;}
    
        
}


function DescuentosList_cargoextraordinarios($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "
    select 
        GROUP_CONCAT(Resumen) as Descuentos
        from descuentos     
    WHERE nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=3";        
    
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Descuentos'];
    } else { return "";}
    
        
}


function DebePago_financiamiento($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "select sum(interes) as total from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' and NPago='".$NPago."'";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['total'];
    } else { return 0;}
    
        
}


function DescuentosList_financiamiento($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "
    select 
        GROUP_CONCAT(Resumen) as Descuentos
        from descuentos     
    WHERE nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=2";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Descuentos'];
    } else { return "";}
    
        
}

function DebePago_capital($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "select sum(abono) as total from cartera WHERE nosol='".$NoSol."' and EstadoPago='SIN PAGAR' and NPago='".$NPago."'";        
    echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['total'];
    } else { return 0;}
    
        
}


function DescuentosList_capital($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "
    select 
        GROUP_CONCAT(Resumen) as Descuentos
        from descuentos     
    WHERE nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=5";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Descuentos'];
    } else { return "";}
    
        
}


function DescuentosList_($NoSol,$NPago){
    require("rintera-config.php");   
    $sql = "
    select 
        GROUP_CONCAT(Resumen) as Descuentos
        from descuentos     
    WHERE nosol='".$NoSol."' and no='".$NPago."' and IdTipoDescuento=0";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Descuentos'];
    } else { return "";}
    
        
}



function IdCorte(){
    require("rintera-config.php");   
    $sql = "select max(id)+1 as id from corte";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['id'];
    } else { return 0;}
    
        
}

function NPago_Moratorio($NoSol, $NPago){
    require("rintera-config.php");   
    $sql = "select sum(mora_debe) as resultado from cartera WHERE nosol='".$NoSol."' and NPago='".$NPago."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['resultado'];
    } else { return 0;}
    
        
}

function NPago_Descuento($NoSol, $NPago){
    require("rintera-config.php");   
    $sql = "select sum(Descuento_cantidad) as resultado from cartera WHERE nosol='".$NoSol."' and NPago='".$NPago."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['resultado'];
    } else { return 0;}
    
        
}

function NPago_ExtraOrdinario($NoSol, $NPago){
    require("rintera-config.php");   
    $sql = "select sum(CargoExtraOrdinario_cantidad) as resultado from cartera WHERE nosol='".$NoSol."' and NPago='".$NPago."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['resultado'];
    } else { return 0;}
    
        
}
function NoSol_Ahorro($NoSol){
    require("rintera-config.php");   
    $sql = "select 
    (sum(ahorro) - sum(ahorro_retiro)) as AhorroTotal    
    from corte where 
    nosol='".$NoSol."'";
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['AhorroTotal'];
    } else { return 0;}
    
        
}


function NPago_CargoSemanal($NoSol, $NPago){
    require("rintera-config.php");   
    $sql = "select sum(CargoSemanal) as resultado from cartera WHERE nosol='".$NoSol."' and NPago='".$NPago."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['resultado'];
    } else { return 0;}
    
        
}

function PorcentajeFi($NoSol){
    require("rintera-config.php");   
    $sql = "select * from cuentas WHERE nosol='".$NoSol."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['tasa_interes'];
    } else { return 0;}
    
        
}

function CargoSeguro($NoSol){
    require("rintera-config.php");   
    $sql = "select * from cuentas WHERE nosol='".$NoSol."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['CargoSeguro'];
    } else { return 0;}
    
        
}

function Valoracion($NoSol){
    require("rintera-config.php");   
    $sql = "select * from cuentas WHERE nosol='".$NoSol."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['valoracion'];
    } else { return '';}
    
        
}

function NoSol_to_IdSucursal($NoSol){
    require("rintera-config.php");   
    $sql = "select * from cuentas WHERE nosol='".$NoSol."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['IdSucursal'];
    } else { return '';}
    
        
}


function UltimaActSaldos(){
    require("rintera-config.php");   
    $sql = "select CONCAT(act_fecha,': ',act_hora) as act from saldos limit 1";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['act'];
    } else { return '';}
    
        
}


function UltimoPago($NoSol){
    require("rintera-config.php");   
    $sql = "select CONCAT(fecha,' por ',valor,' no=',no) as UltimoPago from corte where nosol='".$NoSol."' order by fecha DESC limit 1";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['UltimoPago'];
    } else { return '';}
    
        
}


function Tickets($NoSol, $NPago){
    require("rintera-config.php");   
    $sql="select * from corte where nosol='".$NoSol."' and no='".$NPago."' order by fecha";
    $r= $db1 -> query($sql);
        echo "<div style='
        font-family: Regular; font-size:10pt; background-color:#e3e3e3; border-radius:5px; padding:10px; width:100%; margin:5px;
        '>Tickets correspondientes al contrato ".$NoSol." y pago No. ".$NPago.": <br>";
        while($f = $r -> fetch_array()) {      
            echo " <a title='Haz clic aqui para imprimir el Ticket' target=_blank class='btn btn-primary' href='print_ticket.php?id=".$f['id']."'><img src='iconos/embarques_print2.png' style='width:18px;'> ".$f['id']."</a> ";
        }
        echo "</div>";
}

function TicketsHoy($NoSol){
    require("rintera-config.php");   
    $sql="select * from corte where nosol='".$NoSol."'  order by id DESC";
    $r= $db1 -> query($sql);
        echo "<div style='
        font-family: Regular; font-size:10pt; background-color:#e3e3e3; border-radius:5px; padding:10px; margin:5px;
        '>Tickets: (Contrato:".$NoSol.": )<br>";
        echo "<table class='tabla'>";
        echo "<th>IdTicket</th>";
        echo "<th>Fecha</th>";
        echo "<th>Valor</th>";
        echo "<th>Imprimir</th>";
        while($f = $r -> fetch_array()) {      
            echo "<tr>";
            echo "<td>".$f['id']."</td>";
            echo "<td>".$f['fecha']."</td>";
            echo "<td>".$f['valor']."</td>";
            echo "<td>";
            echo " <a title='Haz clic aqui para imprimir el Ticket' target=_blank class='btn btn-primary' href='print_ticket.php?id=".$f['id']."'><img src='iconos/embarques_print2.png' style='width:18px;'> ".$f['id']."</a> ";
            echo "</td>";            
            echo "</tr>";
            
        }
        echo "</table>";
        echo "</div>";
}


function Ahorro_retiro($NoSol, $NPago, $Descuento, $Concepto, $IdSucursal){
    require("rintera-config.php");   
    $RinteraUser = $_SESSION['RinteraUser'];
     //Descontar del Ahorro
     $IdCorte = IdCorte();
     $sqlA = "INSERT INTO corte (id, fecha, usuario, nosol, ahorro_retiro, comentario, IdSucursal ) 
     VALUES ('".$IdCorte."','".$fecha."', '".$RinteraUser."', '".$NoSol."', '".$Descuento."','".$Concepto."','".$IdSucursal."')";                
     if ($db1->query($sqlA) == TRUE)
     {
             Toast("retiro ".$Descuento." -> Como Descuento para ".$NPago." Guardado Correctamente ",4,"");
             Toast("<a   target=_blank href=print_ticket.php?id=".$IdCorte.">Imprimir Ticket ".$IdCorte."</a>",5,"");
             Historia($RinteraUser, "CAJA", "Paso Ahorro del contrato ".$NoSol." por ".$NPago." como descuento para el pago No. ".$NPago."  SQL = ".addslashes($sqlA));
             return TRUE;

     }
     else {
        return FALSE;
     
     }

}


function Descuento_crear($NoSol, $NPago, $Descuento, $Concepto){
    $RinteraUser = $_SESSION['RinteraUser'];
    require("rintera-config.php");   
     //Descontar del Ahorro
     
    //  $IdCorte = IdCorte();
     $sqlIn="INSERT INTO descuetos (nosol, no, concepto, cantidad, act_user, act_fecha, act_hora, IdTipoDescuento) VALUES (
         '".$NoSol."',
         '".$NPago."',
         '".$Concepto."',
         '".$Descuento."',
         '".$RinteraUser."',
         '".$fecha."',
         '".$hora."',
         '0')";
     if ($db1->query($sqlIn) == TRUE)
     {
             Toast("Descuento ".$Descuento." - ".$Concepto." Guardado Correctamente ",4,"");
            //  Toast("<a   target=_blank href=print_ticket.php?id=".$IdCorte.">Imprimir Ticket ".$IdCorte."</a>",5,"");
             Historia($RinteraUser, "CAJA", "Descuento para el contrato ".$NoSol." por ".$Descuento." como descuento para el pago No. ".$NPago."  SQL = ".addslashes($sqlIn));
             return TRUE;

     }
     else {
        return FALSE;
     
     }

}


function Contrato_Curp($NoSol){
    require("rintera-config.php");   
        $sql = "select * from cuentas where nosol='".$NoSol."'";
        $rc= $db1 -> query($sql);    
        if($f = $rc -> fetch_array())
        { 
            return $f['curp'];
        } else { return '';}
    
        
}

function Contrato_Nombre($NoSol){
    require("rintera-config.php");   
        $sql = "select * from clientes where curp='".Contrato_Curp($NoSol)."'";
        // echo $sql;
        $rc= $db1 -> query($sql);    
        if($f = $rc -> fetch_array())
        { 
            return $f['nombre'];
        } else { return '';}
        
}

function Contrato_Grupo($NoSol){
    require("rintera-config.php");   
        $sql = "select * from cuentas where nosol='".$NoSol."'";
        $rc= $db1 -> query($sql);    
        if($f = $rc -> fetch_array())
        { 
            return $f['grupo'];
        } else { return '';}
    
        
}

function Contrato_cambioTitular($NoSol, $CurpNuevo){
require("rintera-config.php");
$RinteraUser = $_SESSION['RinteraUser'];
$CurpActual = Contrato_Curp($NoSol);

    $QueryUpdate="UPDATE cuentas  SET curp='".$CurpNuevo."'  WHERE nosol='".$NoSol."'";
    if ($db1->query($QueryUpdate) == TRUE)
    {
        Historia($RinteraUser, "CONTRATO", "Cambio de Titular el Contrato ".$NoSol." de ".$CurpActual." a ".$CurpNuevo);
        return TRUE;

        // $QueryUpdate2="UPDATE tabladepagos  SET curp='".$CurpNuevo."'  WHERE nosol='".$NoSol."'";
        // if ($db1->query($QueryUpdate2) == TRUE)
        // {
        //     return TRUE;
        // }  else {
        //     return FALSE;
        // }
        
    }
    else {
        return FALSE;
    }
    unset($QueryCalculo);
}


function MiembroDelGrupo($NoSol, $Curp){
    require("rintera-config.php");
    $RinteraUser = $_SESSION['RinteraUser']; 
    $sql = "select count(*) as n from clientes where grupo=(select grupo from cuentas where nosol='".$NoSol."') and curp='".$Curp."'";
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        if ($f['n']==0){
            return FALSE;
        } else {
            return TRUE;
        }
    } else { return FALSE;}

}


function Contrato_Activo($NoSol){
    require("rintera-config.php");
    $RinteraUser = $_SESSION['RinteraUser']; 
    $sql = "select IdEstatus from cuentas where nosol='".$NoSol."'";
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        if ($f['IdEstatus']==0){
            return TRUE;
        } else {
            return FALSE;
        }
    } else { return FALSE;}

}
  
function CancelarContrato($NoSol){
    require("rintera-config.php");
    $RinteraUser = $_SESSION['RinteraUser']; 

    $QueryUpdate="UPDATE cuentas SET IdEstatus=1 WHERE nosol='".$NoSol."'";
    if ($db1->query($QueryUpdate) == TRUE)
    {
        Historia($RinteraUser, "CONTRATOS", "Cancelo el contrato ".$NoSol);
        return TRUE;
    }
    else {
        return FALSE;
    }
    unset($QueryCalculo);
}


function ActivarContrato($NoSol){
    require("rintera-config.php");
    $RinteraUser = $_SESSION['RinteraUser']; 

    $QueryUpdate="UPDATE cuentas SET IdEstatus=0 WHERE nosol='".$NoSol."'";
    if ($db1->query($QueryUpdate) == TRUE)
    {
        Historia($RinteraUser, "CONTRATOS", "Activo el contrato ".$NoSol);
        return TRUE;
    }
    else {
        return FALSE;
    }
    unset($QueryCalculo);
}

function UserIdSucursal($IdUser){
    require("rintera-config.php");   
        $sql = "select * from users where IdUser='".$IdUser."'";
        $rc= $db0 -> query($sql);    
        if($f = $rc -> fetch_array())
        {
            return $f['IdSucursal'];
        } else {
            return "";
        }
}

function SucursalName($IdSucursal){
    require("rintera-config.php");   
        $sql = "select * from sucursales where IdSucursal='".$IdSucursal."'";
        $rc= $db0 -> query($sql);    
        if($f = $rc -> fetch_array())
        {
            return $f['Sucursal'];
        } else {
            return "";
        }
}

function UserSucursal($IdUser){
    require("rintera-config.php");   
    $IdSucursal = UserIdSucursal($IdUser);
    return SucursalName($IdSucursal);
}
  
function IdGrupo_to_IdSucursal($IdGrupo){
    require("rintera-config.php");   
    $sql = "select * from grupos_html WHERE IdGrupo='".$IdGrupo."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['IdSucursal'];
    } else { return '';}
    
        
}

  
function GrupoName($IdGrupo){
    require("rintera-config.php");   
    $sql = "select * from grupos_html WHERE IdGrupo='".$IdGrupo."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Grupo'];
    } else { return '';}
    
        
}

function Grupo_Miembros($IdGrupo){
    require("rintera-config.php");   
    $sql = "select * from grupos_html WHERE IdGrupo='".$IdGrupo."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Miembros'];
    } else { return 0;}
    
        
}


function Grupo_Contratos($IdGrupo){
    require("rintera-config.php");   
    $sql = "select * from grupos_html WHERE IdGrupo='".$IdGrupo."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['Contratos'];
    } else { return 0;}
    
        
}


function Grupo_delete($IdGrupo){
    require("rintera-config.php");   
    
    if (Grupo_Contratos($IdGrupo)==0 ){
        if (Grupo_Miembros($IdGrupo)==0 ){
            $sql="delete from grupos where IdGrupo='".$IdGrupo."'";
            if ($db1->query($sql) == TRUE){                   
                    return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }

    } else {        
        return FALSE;
    }
    
        
}

function Grupo_Cargo($IdGrupo, $Cargo,$MiCurp){
    require("rintera-config.php");   
    $sql = "select * from gruposinfo WHERE IdGrupo='".$IdGrupo."' and grupo_cargo='".$Cargo."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return TRUE;
    } else { return FALSE;}
    
        
}


function Grupo_CuentasActivas($IdGrupo){
    require("rintera-config.php");   
    $sql = "select * from grupos_html WHERE IdGrupo='".$IdGrupo."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['CuentasActivas'];
    } else { return 0;}
    
        
}

function Seguros_Costo($IdSeguro){
    require("rintera-config.php");   
    $sql = "select * from seguros_config WHERE IdSeguro='".$IdSeguro."'";        
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['costo'];
    } else { return '';}
    
        
}


function NoSol_to_CurpCliente($NoSol){
    require("rintera-config.php");   
    $sql = "select * from cuentas WHERE nosol='".$NoSol."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['curp'];
    } else { return '';}
    
        
}


function NoSol_to_IdSucrusal($NoSol){
    require("rintera-config.php");   
    $sql = "select * from cuentas WHERE nosol='".$NoSol."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['IdSucursal'];
    } else { return '0';}
    
        
}



function RepresentanteLegal($IdSucursal){
    require("rintera-config.php");   
    $sql = "select * from sucursales WHERE IdSucursal='".$IdSucursal."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['representante'];
    } else { return '';}
    
        
}


function es_lunes_martes_miercoles($fecha) {
    // Definimos los días de la semana en ambos idiomas
    $dias_semana = array(
        'es' => array('lunes', 'martes', 'miércoles'),
        'en' => array('monday', 'tuesday', 'wednesday')
    );
    // Convertimos la fecha a su día de la semana en el idioma correspondiente
    $dia_semana_fecha = strtolower(date('l', strtotime($fecha)));
    // Detectamos automáticamente el idioma de la fecha
    $idioma = in_array($dia_semana_fecha, $dias_semana['es']) ? 'es' : 'en';
    // Verificamos si el día de la semana está en el arreglo correspondiente al idioma
    $dia_valido = in_array($dia_semana_fecha, $dias_semana[$idioma]);
    return $dia_valido;
}



function es_lunes($fecha) {
    // Convertimos la fecha a su día de la semana como un número (1 para lunes, 2 para martes, etc.)
    $dia_semana_fecha = date('N', strtotime($fecha));
    // Verificamos si el día de la semana es lunes
    $es_lunes = ($dia_semana_fecha == 1);
    return $es_lunes;
}

function es_miercoles($fecha) {
    // Convertimos la fecha a su día de la semana como un número (1 para lunes, 2 para martes, etc.)
    $dia_semana_fecha = date('N', strtotime($fecha));
    // Verificamos si el día de la semana es miércoles
    $es_miercoles = ($dia_semana_fecha == 3);
    return $es_miercoles;
}

function validar_fechadeinicio($FechaDeInicio, $CreditoFechaContrato) {
    // Validar que la fecha sea mayor que $CreditoFechaContrato
    if (strtotime($FechaDeInicio) <= strtotime($CreditoFechaContrato)) {
        return false;
    }
    // Validar que la fecha sea un lunes
    if (!es_miercoles($FechaDeInicio)) {
        return false;
    }
    // Si pasó todas las validaciones, la fecha es válida
    return true;
}


function idgrupo($nosol){
    require("rintera-config.php");   
    $sql = "select * from historial_contrato WHERE nosol='".$nosol."'";        
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
            return $f['idgrupo'];
        
    } else { return'';}
    
        
}



function InfoGrupo_html($idgrupo){
require("rintera-config.php");
$sql="select c.IdGrupo,
(select Grupo from grupos where IdGrupo = c.IdGrupo) as Grupo,
c.grupo_cargo, c.curp, nombre


from clientes c 
where IdGrupo='".$idgrupo."'";




$r= $db1 -> query($sql);
$html ='<table width=100%>';
$titulo='';
while($f = $r -> fetch_array()) {      
    $titulo = $f['Grupo'];
    $html.='<tr>';
    $html.='<td>'.$f['nombre'].'</td><td>'.$f['grupo_cargo'].'</td><td>'.$f['curp'].'</td>';
    $html.='</tr>';

}
$html.='</table>';
$final = '<h1> Grupo:'.$titulo.' ['.$idgrupo.']</h1><br>'.$html;

return $final;
}

function FechaLarga($fecha) {
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $fecha_unix = strtotime($fecha);
    $dia_semana = date('w', $fecha_unix);
    $dia_mes = date('d', $fecha_unix);
    $mes = date('n', $fecha_unix);
    $anio = date('Y', $fecha_unix);

    $fecha_larga = $dias[$dia_semana]." ".$dia_mes." de ".$meses[$mes-1]. " del ".$anio;

    return $fecha_larga;
}

function EncuentraMiercoles($fecha, $sumadias) {
    $fecha_unix = strtotime($fecha);
    $dia_semana = date('w', $fecha_unix);
    $dias_para_miercoles = 3 - $dia_semana;
    if ($dias_para_miercoles < 0) {
        $dias_para_miercoles += 7;
    }
    $fecha_miercoles = strtotime("+".$dias_para_miercoles." days", $fecha_unix);
    $fecha_sumada = strtotime("+".$sumadias." days", $fecha_miercoles);
    $dia_semana_sumado = date('w', $fecha_sumada);
    $dias_para_miercoles_sumado = 3 - $dia_semana_sumado;
    if ($dias_para_miercoles_sumado < 0) {
        $dias_para_miercoles_sumado += 7;
    }
    $fecha_proximo_miercoles = strtotime("+".$dias_para_miercoles_sumado." days", $fecha_sumada);
    return date('Y-m-d', $fecha_proximo_miercoles);
}


function MiembrosDeUnGrupo($IdGrupo){
    require("rintera-config.php");    
    $sql = "select count(*) as miembros from gruposinfo where IdGrupo='".$IdGrupo."'";
    // echo $sql;
    $rc= $db1 -> query($sql);    
    if($f = $rc -> fetch_array())
    { 
        return $f['miembros'];
    } else { return 0;}

}

?>