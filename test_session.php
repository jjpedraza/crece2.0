<?php
  session_start();
  session_regenerate_id();    
  echo "Id: ".session_id();            


  $_SESSION['RinteraUser'] = "admin";
  
    echo   $_SESSION['RinteraUser'];
?>