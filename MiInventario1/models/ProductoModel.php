<?php
include_once "Conexion.php";

class ProductoModel
{
    public static function mdlListarProductos()
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("SELECT p.*, c.nombre_categoria, pr.nombre_proveedor 
                                        FROM producto p
                                        INNER JOIN categoria c ON p.id_categoria = c.id_categoria
                                        INNER JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al listar productos: " . $e->getMessage());
        }
    }

    public static function mdlObtenerProductoPorId($id)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("SELECT * FROM producto WHERE id_producto = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener producto: " . $e->getMessage());
        }
    }

    public static function mdlAgregarProducto($nombre, $imagen, $descripcion, $precio, $cantidad, $estado, $id_categoria, $id_proveedor)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("INSERT INTO producto 
                (nombre_producto, imagen_producto, descripcion_producto, precio_producto, cantidad_producto, estado_producto, fecha_ingreso, id_categoria, id_proveedor) 
                VALUES (:nombre, :imagen, :descripcion, :precio, :cantidad, :estado, CURDATE(), :id_categoria, :id_proveedor)");

            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $imagen, PDO::PARAM_LOB);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":precio", $precio, PDO::PARAM_STR);
            $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
            $stmt->bindParam(":id_proveedor", $id_proveedor, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error al agregar producto: " . $e->getMessage());
        }
    }

    public static function mdlEditarProducto($id, $nombre, $imagen, $descripcion, $precio, $cantidad, $estado, $id_categoria, $id_proveedor)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("UPDATE producto 
                SET nombre_producto = :nombre, 
                    imagen_producto = :imagen,
                    descripcion_producto = :descripcion, 
                    precio_producto = :precio, 
                    cantidad_producto = :cantidad, 
                    estado_producto = :estado,
                    id_categoria = :id_categoria, 
                    id_proveedor = :id_proveedor 
                WHERE id_producto = :id");

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $imagen, PDO::PARAM_LOB);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":precio", $precio, PDO::PARAM_STR);
            $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
            $stmt->bindParam(":id_proveedor", $id_proveedor, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error al editar producto: " . $e->getMessage());
        }
    }

    public static function mdlEliminarProducto($id)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("DELETE FROM producto WHERE id_producto = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error al eliminar producto: " . $e->getMessage());
        }
    }
}