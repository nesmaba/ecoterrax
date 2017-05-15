<?php

/**
 * Representa el la estructura de los huertos
 * almacenadas en la base de datos
 */
require 'Database.php';

class Huerto
{
    function __construct(){
    
    }

    /**
     * Retorna en la fila especificada de la tabla 'Huertos'
     *
     * @param $idHuerto Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll(){
        $consulta = "SELECT * FROM Huertos";
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
     * Obtiene los campos de un huerto con un identificador
     * determinado
     *
     * @param $idHuerto Identificador del huerto
     * @return mixed
     */
    public static function getById($idHuerto)
    {
        // Consulta del huerto
        $consulta = "SELECT idHuerto,
                            nombre,
                            localizacion,
                            descripcion,
                            temperatura_ambiente,
                            humedad_ambiente,
                            humedad_huerto
                             FROM Huertos
                             WHERE idHuerto = ?";

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
            printf("ERROR: La consulta a la tabla Huertos ha fallado. ".$e);
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idHuerto      identificador
     * @param nombre      nuevo nombre
     * @param localizacion nueva localización
     * @param descripcion    nueva descripción
     * @param temperatura_ambiente temperatura del ambiente en tiempo real
     * @param humedad_ambiente humedad del ambiente en tiempo real
     * @param humedad_huerto humedad del huerto en tiempo real
     * @return PDOStatement
     */
    public static function update(
        $idHuerto,
        $nombre,
        $localizacion,
        $descripcion,
        $temperatura_ambiente,
        $humedad_ambiente,
        $humedad_huerto
    ){
        // Creando consulta UPDATE
        $consulta = "UPDATE Huertos" .
            " SET nombre=?, localizacion=?, descripcion=?, temperatura_ambiente=?"
                . ", humedad_ambiente=?, humedad_huerto=?" .
            "WHERE idHuerto=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($nombre, $localizacion, $descripcion, $temperatura_ambiente,
                                $humedad_ambiente, $humedad_huerto, $idHuerto));

        return $cmd;
    }

    /**
     * Insertar un nuevo huerto
     *
     * @param $idHuerto      identificador
     * @param nombre         nuevo nombre
     * @param localizacion   nueva localización
     * @param descripcion    nueva descripción
     * @param temperatura_ambiente temperatura del ambiente en tiempo real
     * @param humedad_ambiente humedad del ambiente en tiempo real
     * @param humedad_huerto humedad del huerto en tiempo real
     * @return PDOStatement
     */
    public static function insert(
        $nombre,
        $localizacion,
        $descripcion,
        $temperatura_ambiente,
        $humedad_ambiente,
        $humedad_huerto
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO Huertos ( " .
            "nombre," .
            " localizacion," .
            " descripcion," .
            " temperatura_ambiente," .
            " humedad_ambiente," .
            " huerto_huerto," .                
            " VALUES( ?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $nombre,
                $localizacion,
                $descripcion,
                $temperatura_ambiente,
                $humedad_ambiente,
                $humedad_huerto
            )
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idHuerto identificador del huerto
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idHuerto)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM Huertos WHERE idHuerto=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idHuerto));
    }
}

?>