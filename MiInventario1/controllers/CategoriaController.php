<?php
include_once "../models/CategoriaModel.php";

class CategoriaController
{
    public function ctrAgregarCategoria()
    {
        if (isset($_POST["nombre"]) && isset($_POST["descripcion"])) {
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];

            $respuesta = CategoriaModel::mdlAgregarCategoria($nombre, $descripcion);

            if ($respuesta) {
                header("Location: ../views/categorias.php?msg=Categoría agregada correctamente&status=success");
            } else {
                header("Location: ../views/categorias.php?msg=Error al agregar categoría&status=error");
            }
            exit();
        }
    }

    public function ctrEliminarCategoria()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $respuesta = CategoriaModel::mdlEliminarCategoria($id);

            if ($respuesta) {
                header("Location: ../views/categorias.php?msg=Categoría eliminada&status=success");
            } else {
                header("Location: ../views/categorias.php?msg=Error al eliminar categoría&status=error");
            }
            exit();
        }
    }

    public function ctrEditarCategoria()
    {
        if (isset($_POST["id"]) && isset($_POST["nombre"]) && isset($_POST["descripcion"])) {
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];

            $respuesta = CategoriaModel::mdlEditarCategoria($id, $nombre, $descripcion);

            if ($respuesta) {
                header("Location: ../views/categorias.php?msg=Categoría actualizada correctamente&status=success");
            } else {
                header("Location: ../views/categorias.php?msg=Error al actualizar categoría&status=error");
            }
            exit();
        }
    }
}

// Manejo de la acción en la URL
if (isset($_GET["action"])) {
    $categoria = new CategoriaController();

    switch ($_GET["action"]) {
        case "agregar":
            $categoria->ctrAgregarCategoria();
            break;
        case "editar":
            $categoria->ctrEditarCategoria();
            break;
        case "eliminar":
            $categoria->ctrEliminarCategoria();
            break;
        default:
            header("Location: ../views/categorias.php?msg=Acción no válida&status=error");
            exit();
    }
}
?>
