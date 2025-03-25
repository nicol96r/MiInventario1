<?php

include_once "Conexion.php";

class ProveedorModel
{
    public static function mdlAgregarProveedor($nombre, $direccion, $telefono)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("INSERT INTO proveedor (nombre_proveedor, direccion_proveedor, telefono_proveedor) VALUES (:nombre, :direccion, :telefono)");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public static function mdlListarProveedores()
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("SELECT * FROM proveedor");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public static function mdlEliminarProveedor($id)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("DELETE FROM proveedor WHERE id_proveedor = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public static function mdlEditarProveedor($id, $nombre, $direccion, $telefono)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("UPDATE proveedor SET nombre_proveedor = :nombre, direccion_proveedor = :direccion, telefono_proveedor = :telefono WHERE id_proveedor = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}

