<?php

/**
 * Representa el la estructura de los Huerto
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
        $consulta = "SELECT * FROM Huerto";
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
                            provincia,
                            pais,
                            superficie,
                            descripcion
                            FROM Huerto
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
     * @param $nombre      nuevo nombre
     * @param $provincia nueva provincia
     * @param $pais  nuevo pais
     * @param $superficie  superficie del huerto
     * @param $descripcion    nueva descripción
     * @return PDOStatement
     */
    
    public static function update(
        $idHuerto,
        $nombre,
        $provincia,
        $pais,
        $superficie,
        $descripcion
    ){
        // Creando consulta UPDATE
        $consulta = "UPDATE Huerto" .
            " SET nombre=?, provincia=?, pais=?, superficie=?, descripcion=?" .
            "WHERE idHuerto=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($nombre, $provincia, $pais, $superficie, $descripcion, $idHuerto));

        return $cmd;
    }

    /**
     * Insertar un nuevo huerto
     *
     * @param $idHuerto      identificador
     * @param nombre         nuevo nombre
     * @param $nombre      nuevo nombre
     * @param $provincia nueva provincia
     * @param $pais  nuevo pais
     * @param $superficie  superficie del huerto
     * @param $descripcion    nueva descripción
     * @return PDOStatement
     */
    
    public static function insert(
        $nombre,
        $provincia,
        $pais,
        $superficie,
        $descripcion
        )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO Huerto ( " .
            "nombre," .
            " provincia," .
            " pais," .
            " superficie," .
            " descripcion," .
            " VALUES(?,?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $nombre,
                $provincia,
                $pais,
                $superficie,
                $descripcion
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
        $comando = "DELETE FROM Huerto WHERE idHuerto=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idHuerto));
    }
}

?>