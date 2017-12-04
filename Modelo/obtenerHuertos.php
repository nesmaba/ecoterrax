<?php
/**
 * Obtiene todas los huertos de la base de datos
 */

require 'Huerto.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $huertos = Huerto::getAll();

    if ($huertos) {

        $datos["estado"] = 1;
        $datos["huerto"] = $huertos;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error al obtener todos los huertos."
        ));
    }
}