<?php
require("var_clean.php");
require("tokens.php");
require("app_funciones.php");
require_once("preference.php");

define("Version","1.0"); 


function es_lunes($fecha) {
    // Convertimos la fecha a su día de la semana como un número (1 para lunes, 2 para martes, etc.)
    $dia_semana_fecha = date('N', strtotime($fecha));
    // Verificamos si el día de la semana es lunes
    $es_lunes = ($dia_semana_fecha == 1);
    return $es_lunes;
}


$fecha = "2023-02-14"; // Ejemplo de fecha a validar
if (es_lunes($fecha)) {
    echo "La fecha {$fecha} es un lunes";
} else {
    echo "La fecha {$fecha} NO es un lunes";
}


?>