<?php
require_once '../models/UsuarioModel.php';

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new UsuarioModel();
    }

    public function index() {
        $usuarios = $this->model->getUsuarios();
        include '../views/usuarios.php';
    }

    public function edit($id) {
        $usuario = $this->model->getUsuarioById($id);
        $roles_usuario = $this->model->getRolesUsuario($id);
        $todos_roles = $this->model->getAllRoles();

        // Obtener los IDs de roles del usuario
        $roles_ids = array_map(function($rol) {
            return $rol['id_rol'];
        }, $roles_usuario);

        include '../views/editar_usuario.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_usuario'];

            $datos = [
                'tipo_documento' => $_POST['tipo_documento'],
                'documento' => $_POST['documento'],
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'genero' => $_POST['genero'],
                'email' => $_POST['email'],
                'password' => $_POST['password'] ?? '',
                'roles' => $_POST['roles'] ?? []
            ];

            if ($this->model->updateUsuario($id, $datos)) {
                header('Location: ../views/usuarios.php?mensaje=Usuario actualizado correctamente');
            } else {
                header('Location: ../views/editar_usuario.php?id=' . $id . '&error=Error al actualizar usuario');
            }
            exit;
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {
            $id = $_POST['id_usuario'];

            if ($this->model->deleteUsuario($id)) {
                header('Location: ../views/usuarios.php?mensaje=Usuario eliminado correctamente');
            } else {
                header('Location: ../views/usuarios.php?error=Error al eliminar usuario');
            }
            exit;
        }
    }
}

// Manejar las peticiones
if (isset($_GET['action'])) {
    $controller = new UsuarioController();

    switch ($_GET['action']) {
        case 'index':
            $controller->index();
            break;
        case 'edit':
            if (isset($_GET['id'])) {
                $controller->edit($_GET['id']);
            }
            break;
        case 'update':
            $controller->update();
            break;
        case 'delete':
            $controller->delete();
            break;
        default:
            $controller->index();
            break;
    }
} else {
    $controller = new UsuarioController();
    $controller->index();
}
?>