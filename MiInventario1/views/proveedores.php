<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
include_once "../models/ProveedorModel.php";
$proveedores = ProveedorModel::mdlListarProveedores();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/main.css">
    <!-- Estilos específicos para arreglar el logo -->
    <style>
        .navbar-logo {
            height: 40px !important;
            width: auto !important;
            object-fit: contain !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md custom-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
            <!-- Verificando la ruta de la imagen -->
            <img src="../public/logo/logo.png" alt="Logo" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="proveedores.php">Proveedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categorias.php">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="productos.php">Productos</a>
                </li>
            </ul>
            <div class="dropdown ms-auto">
                <button class="btn dropdown-toggle profile-button" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i> Ver perfil
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="usuarios.php">Ver datos</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Proveedores</h1>
        <a href="dashboard.php" class="btn btn-secondary">Volver al Panel</a>
    </div>

    <?php if (isset($_GET["msg"])): ?>
        <div class="alert alert-<?php echo $_GET["status"] == "success" ? "success" : "danger"; ?>">
            <?php echo $_GET["msg"]; ?>
        </div>
    <?php endif; ?>

    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalAgregarProveedor">
        <i class="bi bi-plus-circle me-1"></i> Agregar Proveedor
    </button>

    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($proveedores as $proveedor): ?>
                <tr>
                    <td><?php echo $proveedor["id_proveedor"]; ?></td>
                    <td><?php echo $proveedor["nombre_proveedor"]; ?></td>
                    <td><?php echo $proveedor["direccion_proveedor"]; ?></td>
                    <td><?php echo $proveedor["telefono_proveedor"]; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm btnEditar"
                                data-id="<?php echo $proveedor["id_proveedor"]; ?>"
                                data-nombre="<?php echo $proveedor["nombre_proveedor"]; ?>"
                                data-direccion="<?php echo $proveedor["direccion_proveedor"]; ?>"
                                data-telefono="<?php echo $proveedor["telefono_proveedor"]; ?>"
                                data-bs-toggle="modal" data-bs-target="#modalEditarProveedor">
                            <i class="bi bi-pencil-square me-1"></i> Editar
                        </button>
                        <a href="../controllers/ProveedorController.php?id_proveedor=<?php echo $proveedor["id_proveedor"]; ?>"
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-1"></i> Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar Proveedor -->
<div class="modal fade" id="modalAgregarProveedor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Agregar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/ProveedorController.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre_proveedor" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion_proveedor" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion_proveedor" name="direccion_proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="telefono_proveedor" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono_proveedor" name="telefono_proveedor">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Proveedor -->
<div class="modal fade" id="modalEditarProveedor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/ProveedorController.php" method="POST">
                    <input type="hidden" id="edit_id_proveedor" name="id_proveedor">
                    <div class="mb-3">
                        <label for="edit_nombre_proveedor" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit_nombre_proveedor" name="nombre_proveedor" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_direccion_proveedor" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="edit_direccion_proveedor" name="direccion_proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="edit_telefono_proveedor" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="edit_telefono_proveedor" name="telefono_proveedor">
                    </div>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer inspirado en daisyUI -->
<footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center mb-4 mb-md-0">
                <div class="d-flex align-items-center">
                    <div class="footer-logo bg-secondary d-flex align-items-center justify-content-center">
                        <i class="bi bi-database text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Admin Panel</h5>
                        <p class="mb-0">Sistema de gestión personalizado</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="subscribe-form">
                    <h6>Recibe actualizaciones y noticias</h6>
                    <div class="input-group mb-2">
                        <input type="email" class="form-control" placeholder="email@sitio.com">
                        <button class="btn btn-dark" type="button">Suscribirse</button>
                    </div>
                    <p class="privacy-text">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        No compartimos tu correo electrónico con nadie
                    </p>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-md-6">
                <div class="social-icons">
                    <a href="#"><i class="bi bi-github"></i></a>
                    <a href="#"><i class="bi bi-discord"></i></a>
                    <a href="#"><i class="bi bi-npm"></i></a>
                    <a href="#"><i class="bi bi-box-seam"></i></a>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">Desarrollado por <strong>Tu Empresa</strong> &copy; 2025</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let editButtons = document.querySelectorAll(".btnEditar");
        editButtons.forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("edit_id_proveedor").value = this.getAttribute("data-id");
                document.getElementById("edit_nombre_proveedor").value = this.getAttribute("data-nombre");
                document.getElementById("edit_direccion_proveedor").value = this.getAttribute("data-direccion");
                document.getElementById("edit_telefono_proveedor").value = this.getAttribute("data-telefono");
            });
        });
    });
</script>
</body>
</html>