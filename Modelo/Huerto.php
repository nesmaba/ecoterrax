<?php

/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
require 'Database.php';

class Meta
{
    function __construct(){
    
    }

    /**
     * Retorna en la fila especificada de la tabla 'meta'
     *
     * @param $idMeta Identificador del registro
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
     * Obtiene los campos de una meta con un identificador
     * determinado
     *
     * @param $idHuerto Identificador del huerto
     * @return mixed
     */
    public static function getById($idHuerto)
    {
        // Consulta de la meta
        $consulta = "SELECT idHuerto,
                            nombre,
                            localizacion,
                            descripcion
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
     * @param nombre      nuevo titulo
     * @param localizacion nueva descripcion
     * @param descripcion    nueva fecha limite de cumplimiento
     * @return PDOStatement
     */
    public static function update(
        $idHuerto,
        $nombre,
        $localizacion,
        $descripcion
    ){
        // Creando consulta UPDATE
        $consulta = "UPDATE Huertos" .
            " SET nombre=?, localizacion=?, descripcion=? " .
            "WHERE idHuerto=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($nombre, $localizacion, $descripcion, $idHuerto));

        return $cmd;
    }

    /**
     * Insertar un nuevo huerto
     *
     * @param $idHuerto      identificador
     * @param nombre         nuevo titulo
     * @param localizacion   nueva descripcion
     * @param descripcion    nueva fecha limite de cumplimiento
     * @return PDOStatement
     */
    public static function insert(
        $titulo,
        $descripcion,
        $fechaLim,
        $categoria,
        $prioridad
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO meta ( " .
            "titulo," .
            " descripcion," .
            " fechaLim," .
            " categoria," .
            " prioridad)" .
            " VALUES( ?,?,?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $titulo,
                $descripcion,
                $fechaLim,
                $categoria,
                $prioridad
            )
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idMeta identificador de la meta
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idMeta)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM meta WHERE idMeta=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idMeta));
    }
}

?>