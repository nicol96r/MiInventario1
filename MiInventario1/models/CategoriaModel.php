<?php

include_once "Conexion.php";

class CategoriaModel
{
    public static function mdlAgregarCategoria($nombre, $descripcion)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("INSERT INTO categoria (nombre_categoria, descripcion_categoria) VALUES (:nombre, :descripcion)");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public static function mdlListarCategorias()
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("SELECT * FROM categoria");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public static function mdlEliminarCategoria($id)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("DELETE FROM categoria WHERE id_categoria = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public static function mdlEditarCategoria($id, $nombre, $descripcion)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("UPDATE categoria SET nombre_categoria = :nombre, descripcion_categoria = :descripcion WHERE id_categoria = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
