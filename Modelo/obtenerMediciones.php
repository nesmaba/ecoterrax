<?php
/**
 * Obtiene todas las riegos de la base de datos
 */

require 'Medicion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $mediciones = Medicion::getAll();

    if ($riegos) {

        $datos["estado"] = 1;
        $datos["medicion"] = $mediciones;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error al obtener todas las mediciones."
        ));
    }
}
