<?php

/**
 * Representa el la estructura de los riegos
 * almacenadas en la base de datos
 */
require 'Database.php';

class Riego
{
    function __construct(){
    
    }

    /**
     * Retorna en la fila especificada de la tabla 'Riegos'
     *
     * @param $idRiego Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll(){
        $consulta = "SELECT * FROM Riegos";
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
     * Obtiene los campos de un riego con un identificador
     * determinado
     *
     * @param $idRiego Identificador del riego
     * @return mixed
     */
    public static function getById($idRiego)
    {
        // Consulta de la meta
        $consulta = "SELECT idRiego,
                            idHuerto,
                            temperatura_ambiente,
                            humedad_ambiente,
                            humedad_huerto,
                            cont_riegos,
                            fecha,
                            hora
                             FROM Riegos
                             WHERE idRiego = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idRiego));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            printf("ERROR: La consulta a la tabla Riegos ha fallado. ".$e);
            return -1;
        }
    }
   
    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idRiego             identificador
     * @param idHuerto             nuevo id del huerto que se riega
     * @param temperatura_ambiente nueva temperatura del ambiente
     * @param humedad_ambiente     nueva humedad del ambiente
     * @param humedad_huerto       nueva humedad del huerto
     * @param cont_riegos          nuevo número de veces que se ha regado
     * @param fecha                nuevo fecha del riego
     * @param hora                 nueva hora del riego
     * @return PDOStatement
     */
    public static function update(
        $idRiego,
        $idHuerto,
        $temperatura_ambiente,
        $humedad_ambiente,
        $humedad_huerto,
        $cont_riegos,
        $fecha,
        $hora
    ){
        // Creando consulta UPDATE
        $consulta = "UPDATE Riegos" .
            " SET idHuerto=?, temperatura_ambiente=?, humedad_ambiente=?, "
                . "humedad_huerto=?, cont_riegos=?, fecha=?, hora=?" .
            "WHERE idRiego=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($idHuerto, $temperatura_ambiente, $humedad_ambiente,
                                $humedad_huerto, $cont_riegos, $fecha, $hora, $idRiego));
        return $cmd;
    }

    /**
     * Insertar un nuevo riego
     *
     * @param $idRiego             identificador
     * @param idHuerto             nuevo id del huerto que se riega
     * @param temperatura_ambiente nueva temperatura del ambiente
     * @param humedad_ambiente     nueva humedad del ambiente
     * @param humedad_huerto       nueva humedad del huerto
     * @param cont_riegos          nuevo número de veces que se ha regado
     * @param fecha                nuevo fecha del riego
     * @param hora                 nueva hora del riego
     * @return PDOStatement
     */
    public static function insert(
        $idRiego,
        $idHuerto,
        $temperatura_ambiente,
        $humedad_ambiente,
        $humedad_huerto,
        $cont_riegos,
        $fecha,
        $hora
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO Riegos ( " .
            "idHuerto," .
            " temperatura_ambiente," .
            " humedad_ambiente," .
            " humedad_huerto," .
            " fecha," .    
            " hora," .
            " VALUES(?,?,?,?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $idHuerto,
                $temperatura_ambiente,
                $humedad_ambiente,
                $humedad_huerto,
                $cont_riegos,
                $fecha,
                $hora
                    )
                );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idRiego identificador del riego
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idRiego)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM Riegos WHERE idRiego=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idRiego));
    }
}

?>