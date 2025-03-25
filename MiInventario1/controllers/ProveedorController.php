<?php
include_once "../models/ProveedorModel.php";

class ProveedorController
{
    public function ctrAgregarProveedor()
    {
        if (isset($_POST["nombre_proveedor"])) {
            $nombre = $_POST["nombre_proveedor"];
            $direccion = $_POST["direccion_proveedor"];
            $telefono = $_POST["telefono_proveedor"];

            $respuesta = ProveedorModel::mdlAgregarProveedor($nombre, $direccion, $telefono);

            if ($respuesta) {
                header("Location: ../views/proveedores.php?msg=Proveedor agregado correctamente&status=success");
            } else {
                header("Location: ../views/proveedores.php?msg=Error al agregar proveedor&status=error");
            }
            exit();
        }
    }

    public function ctrEliminarProveedor()
    {
        if (isset($_GET["id_proveedor"])) {
            $id = $_GET["id_proveedor"];
            $respuesta = ProveedorModel::mdlEliminarProveedor($id);

            if ($respuesta) {
                header("Location: ../views/proveedores.php?msg=Proveedor eliminado&status=success");
            } else {
                header("Location: ../views/proveedores.php?msg=Error al eliminar proveedor&status=error");
            }
            exit();
        }
    }

    public function ctrEditarProveedor()
    {
        if (isset($_POST["id_proveedor"])) {
            $id = $_POST["id_proveedor"];
            $nombre = $_POST["nombre_proveedor"];
            $direccion = $_POST["direccion_proveedor"];
            $telefono = $_POST["telefono_proveedor"];

            $respuesta = ProveedorModel::mdlEditarProveedor($id, $nombre, $direccion, $telefono);

            if ($respuesta) {
                header("Location: ../views/proveedores.php?msg=Proveedor actualizado correctamente&status=success");
            } else {
                header("Location: ../views/proveedores.php?msg=Error al actualizar proveedor&status=error");
            }
            exit();
        }
    }

}

// Manejo de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_proveedor"])) {
        $proveedor = new ProveedorController();
        $proveedor->ctrEditarProveedor();
    } else {
        $proveedor = new ProveedorController();
        $proveedor->ctrAgregarProveedor();
    }
} elseif (isset($_GET["id_proveedor"])) {
    $proveedor = new ProveedorController();
    $proveedor->ctrEliminarProveedor();
}
