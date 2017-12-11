<?php
/**
 * Obtiene el detalle de una huerto especificada por
 * su identificador "idHuertos"
 */

require 'Medicion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Ejemplo de llamada http://localhost/EcoTerraX/Modelo/obtenerDetalleMedicion.php?idHuerto=1
    if (isset($_GET['idHuerto'])) {
        // print_r($_GET['idHuerto']);
        // Obtener parámetro idHuertos
        $parametro = $_GET['idHuerto'];

        // Tratar retorno
        $retorno = Medicion::getLastMedicionByIdHuerto($parametro);


        if ($retorno) {

            $huerto["estado"] = "1";
            $huerto["medicion"] = $retorno;
            // Enviar objeto json de la medición
            print json_encode($huerto);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvieron los detalles de la medición dada.'
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