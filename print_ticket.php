<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");

if (isset($_GET['id'])){ //Ticket
    $IdCorte = VarClean($_GET['id']);
    $sql = "select * from corte WHERE id ='".$IdCorte."'";        
    $rc= $db1 -> query($sql);
    if($f = $rc -> fetch_array())
    {   
        $Curp = NoSol_to_Curp($f['nosol']);
        $Cliente = Cliente_Nombre($Curp);    
        $IdGrupo = Cliente_IdGrupo($Curp);
        $Grupo = GrupoName($IdGrupo);

        echo '<p>';
        echo'<img border="0" src="img/logo_color.png"  width="120" height="80" style="margin-left:50px;"/>
        <br></p>';

        
        echo '<b style="font-size:12pt; font-family:courier new;">'.$Cliente.'</b><br>';
        echo '<b style="font-size:10pt; font-family:courier new;">'.$Curp.'</b><br>';
        echo '<b style="font-size:10pt; font-family:courier new;">('.$IdGrupo.')'.$Grupo.'</b><br>';
        echo '<b style="font-size:10pt; font-family:courier new;">Contrato: '.$f['nosol'].'</b><br>';
        echo '<b style="font-size:10pt; font-family:courier new;">IdTicket: '.$f['id'].'</b><br>';
        echo '<b style="font-size:10pt; font-family:courier new;">No: '.$f['no'].'/'.Cuenta_NPagos($f['nosol']).'</b>';

        echo '<p style="font-size:8pt;  font-family:courier new;">';

        if ($f['ahorro']>0) {
            echo 'Ahorro: '.Pesos($f['ahorro']).'<br>';            
            echo'------------------------------------<br>';
            echo "TOTAL AHORRADO: ".Pesos(NoSol_Ahorro($f['nosol']))."<br>";
        } else {

            if ($f['ahorro_retiro']>0) {
                echo 'Retiro Ahorro: '.Pesos($f['ahorro_retiro']).'<br>';            
                echo'------------------------------------<br>';
                echo "TOTAL AHORRADO: ".Pesos(NoSol_Ahorro($f['nosol']))."<br>";

            } else {
                echo 'Morat: '.Pesos($f['moratorio']).'<br>';
                echo 'C.Sem: '.Pesos($f['cargosemanal']).'<br>';
                echo 'Extra: '.Pesos($f['extras']).' <br>';        
                echo 'Int.Fi: '.Pesos($f['interes']).'<br>';
                echo 'IVA: '.Pesos($f['impuesto']).'<br>';        
                echo 'Cap: '.Pesos($f['capital']).'<br>';
                echo 'Seg.: '.Pesos($f['cargoseguro']).'<br>';
                echo'------------------------------------<br>';
                echo 'Pago: '.Pesos($f['valor']).'<br>';
            }
        }
        
        echo '<br><br>Recibido: '.$f['fecha'].'<br>';
        // echo 'Pago: '.Pesos($f['valor']).'<br>';
        // echo 'Pago: '.Pesos($f['valor']).'<br>';
        

        echo "Descuento: ".NPago_Descuento($f['nosol'],$f['no'])."<br>";
        echo "".$f['comentario']."<br>";
        echo "Retiro: ".$f['ahorro_retiro']."<br>";


        echo '</p>';

        echo '<br><p style="font-size:7.5pt; text-transform:uppercase; font-family:courier new;">Contratar prestamos <br>por arriba de tu capacidad de pago,<br>puede afectar tu patrimonio<br>y tu historial crediticio.<br></p>';
        
        echo '<p style="font-size:8pt; text-transform:uppercase; font-family:courier new;">';

        echo 'Imp. '.$fecha.':'.$hora.'<br>';
        echo 'usuario: '.$RinteraUser;
        echo '</p>';

        

    } else {
        echo "ERROR; Ticket ",$IdCorte." no encontrado";
    }
    unset($sql, $rc, $f);

} else{
    if (isset($_GET['nosol'])){// Buscar uno o varios etiquetados del mismo pago
        $NoSol = VarClean($_GET['nosol']);
        $NPago = VarClean($_GET['n']);
        $Curp = NoSol_to_Curp($NoSol);
        $Cliente = Cliente_Nombre($Curp);
    }
    
}



?>
<script>window.print();</script>    