<?php
require("FormElement.php");

//Buscar Color: 
$ColorHex = Colorin_Search('Rojo');
$ColorRGB = Colorin_Search('Rojo','rgb');
echo "<div style='background-color:".$ColorHex.";'>".$ColorHex."</div>";
echo "<div style='background-color:rgb(".$ColorRGB.");'>".$ColorRGB."</div>";
echo "<div style='background-color:rgba(".$ColorRGB.",0.5);'>".$ColorRGB."a</div>";





?>