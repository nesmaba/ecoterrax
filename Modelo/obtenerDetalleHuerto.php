<?php
/**
 * Obtiene el detalle de una huerto especificada por
 * su identificador "idHuertos"
 */

require 'Huertos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['idHuerto'])) {

        // Obtener parámetro idHuertos
        $parametro = $_GET['idHuerto'];

        // Tratar retorno
        $retorno = Huertos::getById($parametro);


        if ($retorno) {

            $huerto["estado"] = "1";
            $huerto["huerto"] = $retorno;
            // Enviar objeto json de la huerto
            print json_encode($huerto);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvieron los detalles del huerto dado.'
                )
            );
        }

    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}