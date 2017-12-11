<?php

/**
 * Representa el la estructura de las mediciones
 * almacenadas en la base de datos
 */
require 'Database.php';

class Medicion
{
    function __construct(){
    
    }

    /**
     * Retorna en la fila especificada de la tabla 'Medicion'
     *
     * @param $idMedicion Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll(){
        $consulta = "SELECT * FROM Medicion";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una medición con un identificador
     * determinado
     *
     * @param $idMedicion Identificador de la medicion
     * @return mixed
     */
    public static function getById($idMedicion)
    {
        // Consulta de la medicion
        $consulta = "SELECT idMedicion,
                            idHuerto,
                            tempAmb,
                            humAmb,
                            humTierra,
                            fecha,
                            hora, 
                            esRegado
                             FROM Medicion
                             WHERE idMedicion = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idMedicion));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            printf("ERROR: La consulta a la tabla Medicion ha fallado. ".$e);
            return -1;
        }
    }

    /**
     * Obtiene los campos de la última medición con un identificador
     * determinado de un huerto determinado
     *
     * @param $idHuerto Identificador del huerto
     * @return mixed
     */
    public static function getLastMedicionByIdHuerto($idHuerto)
    {
        // Consulta de la meta
        $consulta = "SELECT tempAmb,
                            humAmb,
                            humTierra,                            
                            fecha,
                            hora,
                            esRegado
                             FROM Medicion
                             WHERE idHuerto = ? 
                             HAVING idMedicion=MAX(idMedicion)";
        

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idHuerto));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            printf("ERROR: La consulta a la tabla Medicion ha fallado. ".$e);
            return -1;
        }
    }
    
    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idMedicion             identificador
     * @param $idHuerto             nuevo id del huerto que se riega
     * @param $tempAmb nueva temperatura del ambiente
     * @param $humAmb     nueva humedad del ambiente
     * @param $humTierra       nueva humedad del huerto
     * @param $fecha                nuevo fecha del riego
     * @param $hora                 nueva hora del riego
     * @param $esRegado             ¿se ha regado en esta medición?
     * @return PDOStatement
     */
    public static function update(
        $idMedicion,
        $idHuerto,
        $tempAmb,
        $humAmb,
        $humTierra,
        $fecha,
        $hora,
        $esRegado
    ){
        // Creando consulta UPDATE
        $consulta = "UPDATE Medicion" .
            " SET idHuerto=?, tempAmb=?, humAmb=?, "
                . "humTierra=?, fecha=?, hora=?, esRegado=?" .
            "WHERE idMedicion=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($idHuerto, $tempAmb, $humAmb,
                                $humTierra, $fecha, $hora, $esRegado, $idMedicion));
        return $cmd;
    }

    /**
     * Insertar un nuevo riego
     *
     * @param $idMedicion             identificador
     * @param $idHuerto             nuevo id del huerto que se riega
     * @param $tempAmb nueva temperatura del ambiente
     * @param $humAmb     nueva humedad del ambiente
     * @param $humTierra       nueva humedad del huerto
     * @param $fecha                nuevo fecha del riego
     * @param $hora                 nueva hora del riego
     * @param $esRegado             ¿se ha regado en esta medición?
     * @return PDOStatement
     */
    public static function insert(
        $idHuerto,
        $tempAmb,
        $humAmb,
        $humTierra,
        $fecha,
        $hora,
        $esRegado
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO Medicion ( " .
            "idHuerto," .
            " tempAmb," .
            " humAmb," .
            " humTierra," .
            " fecha," .    
            " hora," .
            " esRegado" .
            " VALUES(?,?,?,?,?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $idHuerto,
                $tempAmb,
                $humAmb,
                $humTierra,
                $fecha,
                $hora,
                $esRegado
                    )
                );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idMedicion identificador de la medición
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idMedicion)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM Medicion WHERE idMedicion=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idMedicion));
    }
}

?>