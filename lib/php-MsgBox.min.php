<?php
function MsgBox($Mensaje, $URLDestino = "", $TextoBoton1 = "Aceptar", $TextoBoton2="Cancelar", $Tipo = 0, $ValorGET = "" ){
if ($URLDestino == ""){    
    // $URLActual = full_url( $_SERVER );  
    $URLDestino = "index.php"; ///Defina aqui su index del proyecto
}
echo '<div id="phpMsgBox_modal"></div>';
switch ($Tipo) {
    
    case 0:       
        echo '<div id="phpMsgBox">';
            echo '<p>'.$Mensaje.'</p>';
            echo     '<a class="btn btn-primary" href="'.$URLDestino.'">'.$TextoBoton1.'</a>  ';        
        echo '</div>';
        
        break;
    case 1: //Cuestion
        echo '<div id="phpMsgBox">';
        echo '<p>'.$Mensaje.'</p>';
        echo     '<a class="btn btn-success" href="'.$URLDestino.'&cuestion=TRUE" title="Aceptar">'.$TextoBoton1.'</a>';        
        echo     ' <a class="btn btn-danger" href="'.$URLDestino.'&cuestion=FALSE" title="Cancelar">'.$TextoBoton2.'</a>';        
        echo '</div>';
        break;
    case 2:
        echo "i es igual a 2";
        break;
    default:
       echo "i no es igual a 0, 1 ni 2";
}




}



function url_origin2($s, $use_forwarded_host=false) {

    $ssl = ( ! empty($s['HTTPS']) && $s['HTTPS'] == 'on' ) ? true:false;
    $sp = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/'  )) . ( ( $ssl ) ? 's' : '' );
  
    $port = $s['SERVER_PORT'];
    $port = ( ( ! $ssl && $port == '80' ) || ( $ssl && $port=='443' ) ) ? '' : ':' . $port;
    
    $host = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
  
    return $protocol . '://' . $host;
  
  }
  
  function full_url2( $s, $use_forwarded_host=false ) {
    return url_origin2( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
  }
  
  
?>