<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");

if (isset($_GET['id'])){
    $NoSol = VarClean($_GET['id']);
    $Curp = NoSol_to_Curp($NoSol);
    $Cliente = Cliente_Nombre($Curp);

    if ($NoSol <> ''){
        Historia($RinteraUser, "PRINT", "Descargo la Estado de Cuenta de Ahorro NoSol=".$NoSol."");
        $sql="select 
        a.id,
        a.nosol,
        a.fecha,
        a.usuario,
        a.ahorro,
        a.ahorro_retiro,
        (
            (select sum(ahorro) from corte where nosol='20140522425' and id <= a.id order by id ASC) 
            - 
            (select sum(ahorro_retiro) from corte where nosol='20140522425' and id <= a.id order by id ASC) 
        ) as saldo,        
        a.comentario as concepto        
        from corte a
        where nosol='".$NoSol."'
        order by fecha ASC
        ";
        // echo $sql;
        $r = $db1->query($sql);    
        if ($db1->query($sql) == TRUE){   
            $PDFTitulo="ESTADO DE CUENTA AHORRO";
            $PDFSubTitulo="No. ".$NoSol."";
            $PDFSubTitulo2=$Cliente;
            include("_print_head.php");
            $htmlPDF = '<table style="
                    border:1px solid gray;
                    font-size:8pt;

                ">';

            $htmlPDF.='<tr 
                style="
                    
                    font-size:8pt; text-align:center;
                "
            >';
            $htmlPDF.='<td style="background-color: #878787; color:white;">id'.'</td>'; //1                            
            $htmlPDF.='<td style="background-color: #878787; color:white;">Fecha'.'</td>'; //1                            
            $htmlPDF.='<td style="background-color: #878787; color:white;">Atendio'.'</td>'; //1                            
            $htmlPDF.='<td style="background-color: #878787; color:white;">Ahorro'.'</td>'; //1                            
            $htmlPDF.='<td style="background-color: #878787; color:white;">Retiro'.'</td>'; //1                            
            $htmlPDF.='<td style="background-color: #878787; color:white;">Saldo por Fecha'.'</td>'; //1                            
            $htmlPDF.='<td style="background-color: #878787; color:white;">Concepto'.'</td>'; //1                            
            $htmlPDF.='</tr>';
            $c = 0;
            while($Ahorro= $r -> fetch_array()) { 
                $htmlPDF.='<tr>';
            if ($c%2==0){ 
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #ebebeb; ">'.$Ahorro['id'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #ebebeb; ">'.$Ahorro['fecha'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #ebebeb; ">'.$Ahorro['usuario'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #ebebeb; ">'.$Ahorro['ahorro'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #ebebeb; ">'.$Ahorro['ahorro_retiro'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #ebebeb; ">'.$Ahorro['saldo'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #ebebeb;font-size:8px; ">'.$Ahorro['concepto'].'</td>'; //1  
                
            } else {
                

                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #dbdbdb; ">'.$Ahorro['id'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #dbdbdb; ">'.$Ahorro['fecha'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #dbdbdb; ">'.$Ahorro['usuario'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #dbdbdb; ">'.$Ahorro['ahorro'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #dbdbdb; ">'.$Ahorro['ahorro_retiro'].'</td>'; //1                            
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #dbdbdb; ">'.$Ahorro['saldo'].'</td>'; //1  
                $htmlPDF.='<td style="border: 1px solid #e0e0e0; background-color: #dbdbdb; font-size:8px;">'.$Ahorro['concepto'].'</td>'; //1  
                
            }

            $htmlPDF.='</tr>';
                $c = $c+1;
            }
            $htmlPDF.='</table>';
            include("_print_footer.php");



        } else {
            echo "ERROR en la base de datos";
        }
        unset($r,$sql);
             
    } else { echo "ERROR; Parametros incompletos";}
} else { echo "ERROR; Parametros no definidos";}


unset($rx, $sqlX, $Pagos);

?>