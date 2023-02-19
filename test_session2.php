<?php
  session_start();  
  echo   "1".$_SESSION['RinteraUser'];
  session_regenerate_id();
echo   "2".$_SESSION['RinteraUser'];
?>