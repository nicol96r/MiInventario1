<?php
include_once "../models/ProductoModel.php";

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'agregar':
            if (!empty($_POST['nombre']) && !empty($_POST['descripcion']) && !empty($_POST['precio']) &&
                !empty($_POST['stock']) && !empty($_POST['estado']) && !empty($_POST['id_categoria']) &&
                !empty($_POST['id_proveedor'])) {

                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = $_POST['precio'];
                $cantidad = $_POST['stock'];
                $estado = $_POST['estado'];
                $id_categoria = $_POST['id_categoria'];
                $id_proveedor = $_POST['id_proveedor'];

                // Manejo de imagen
                $imagen = null;
                if (isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0) {
                    $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
                }

                $resultado = ProductoModel::mdlAgregarProducto($nombre, $imagen, $descripcion, $precio, $cantidad, $estado, $id_categoria, $id_proveedor);

                if ($resultado) {
                    header("Location: ../views/productos.php?success=Producto agregado");
                } else {
                    header("Location: ../views/productos.php?error=No se pudo agregar el producto");
                }
            } else {
                header("Location: ../views/productos.php?error=Todos los campos son obligatorios");
            }
            break;

        case 'editar':
            if (!empty($_POST['id']) && !empty($_POST['nombre']) && !empty($_POST['descripcion']) &&
                !empty($_POST['precio']) && !empty($_POST['stock']) && !empty($_POST['estado']) &&
                !empty($_POST['id_categoria']) && !empty($_POST['id_proveedor'])) {

                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = $_POST['precio'];
                $cantidad = $_POST['stock'];
                $estado = $_POST['estado'];
                $id_categoria = $_POST['id_categoria'];
                $id_proveedor = $_POST['id_proveedor'];

                // Manejo de imagen
                $imagen = null;
                if (isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0) {
                    $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
                } else {
                    // Mantener la imagen actual si no se carga una nueva
                    $productoActual = ProductoModel::mdlObtenerProductoPorId($id);
                    if ($productoActual) {
                        $imagen = $productoActual['imagen_producto'];
                    }
                }

                $resultado = ProductoModel::mdlEditarProducto($id, $nombre, $imagen, $descripcion, $precio, $cantidad, $estado, $id_categoria, $id_proveedor);

                if ($resultado) {
                    header("Location: ../views/productos.php?success=Producto actualizado");
                } else {
                    header("Location: ../views/productos.php?error=No se pudo actualizar el producto");
                }
            } else {
                header("Location: ../views/productos.php?error=Todos los campos son obligatorios");
            }
            break;

        case 'eliminar':
            if (!empty($_GET['id'])) {
                $id = $_GET['id'];
                $resultado = ProductoModel::mdlEliminarProducto($id);

                if ($resultado) {
                    header("Location: ../views/productos.php?success=Producto eliminado");
                } else {
                    header("Location: ../views/productos.php?error=No se pudo eliminar el producto");
                }
            }
            break;
    }
}
?>