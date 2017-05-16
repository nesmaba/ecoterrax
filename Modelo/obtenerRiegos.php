<?php
/**
 * Obtiene todas las riegos de la base de datos
 */

require 'Riegos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $riegos = Riego::getAll();

    if ($riegos) {

        $datos["estado"] = 1;
        $datos["riegos"] = $riegos;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error al obtener todos los riegos."
        ));
    }
}
