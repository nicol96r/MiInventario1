<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

include_once "../models/ProductoModel.php";
include_once "../models/CategoriaModel.php";
include_once "../models/ProveedorModel.php";

$productos = ProductoModel::mdlListarProductos();
$categorias = CategoriaModel::mdlListarCategorias();
$proveedores = ProveedorModel::mdlListarProveedores();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
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
                    <a class="nav-link" href="proveedores.php">Proveedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categorias.php">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="productos.php">Productos</a>
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
        <h1>Gestión de Productos</h1>
        <a href="dashboard.php" class="btn btn-secondary">Volver al Panel</a>
    </div>

    <?php if (isset($_GET['success'])) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">
        <i class="bi bi-plus-circle me-1"></i> Agregar Producto
    </button>

    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $producto) : ?>
                <tr>
                    <td><?= htmlspecialchars($producto['id_producto']) ?></td>
                    <td><?= htmlspecialchars($producto['nombre_producto']) ?></td>
                    <td>
                        <?php if (!empty($producto['imagen_producto'])) : ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($producto['imagen_producto']) ?>" width="50">
                        <?php else : ?>
                            <span class="text-muted">Sin imagen</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($producto['descripcion_producto']) ?></td>
                    <td><?= number_format($producto['precio_producto'], 2) ?></td>
                    <td><?= htmlspecialchars($producto['cantidad_producto']) ?></td>
                    <td><?= htmlspecialchars($producto['estado_producto']) ?></td>
                    <td><?= htmlspecialchars($producto['nombre_categoria']) ?></td>
                    <td><?= htmlspecialchars($producto['nombre_proveedor']) ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarProducto(
                        <?= $producto['id_producto'] ?>,
                                '<?= addslashes($producto['nombre_producto']) ?>',
                                '<?= addslashes($producto['descripcion_producto']) ?>',
                        <?= $producto['precio_producto'] ?>,
                        <?= $producto['cantidad_producto'] ?>,
                                '<?= addslashes($producto['estado_producto']) ?>',
                        <?= $producto['id_categoria'] ?>,
                        <?= $producto['id_proveedor'] ?>
                                )">
                            <i class="bi bi-pencil-square me-1"></i> Editar
                        </button>
                        <a href="../controllers/ProductoController.php?action=eliminar&id=<?= $producto['id_producto'] ?>"
                           class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este producto?');">
                            <i class="bi bi-trash me-1"></i> Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar Producto -->
<div class="modal fade" id="modalAgregarProducto">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/ProductoController.php?action=agregar" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_categoria" class="form-label">Categoría</label>
                        <select class="form-control" id="id_categoria" name="id_categoria" required>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?= $categoria['id_categoria'] ?>"><?= htmlspecialchars($categoria['nombre_categoria']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_proveedor" class="form-label">Proveedor</label>
                        <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                            <?php foreach ($proveedores as $proveedor) : ?>
                                <option value="<?= $proveedor['id_proveedor'] ?>"><?= htmlspecialchars($proveedor['nombre_proveedor']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="modalEditarProducto">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/ProductoController.php?action=editar" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-imagen" class="form-label">Imagen (Dejar vacío para mantener la actual)</label>
                        <input type="file" class="form-control" id="edit-imagen" name="imagen" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="edit-descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="edit-descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-precio" class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="edit-precio" name="precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="edit-stock" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-estado" class="form-label">Estado</label>
                        <select class="form-control" id="edit-estado" name="estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-id_categoria" class="form-label">Categoría</label>
                        <select class="form-control" id="edit-id_categoria" name="id_categoria" required>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?= $categoria['id_categoria'] ?>"><?= htmlspecialchars($categoria['nombre_categoria']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-id_proveedor" class="form-label">Proveedor</label>
                        <select class="form-control" id="edit-id_proveedor" name="id_proveedor" required>
                            <?php foreach ($proveedores as $proveedor) : ?>
                                <option value="<?= $proveedor['id_proveedor'] ?>"><?= htmlspecialchars($proveedor['nombre_proveedor']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
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
    function editarProducto(id, nombre, descripcion, precio, stock, estado, id_categoria, id_proveedor) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nombre').value = nombre;
        document.getElementById('edit-descripcion').value = descripcion;
        document.getElementById('edit-precio').value = precio;
        document.getElementById('edit-stock').value = stock;
        document.getElementById('edit-estado').value = estado;
        document.getElementById('edit-id_categoria').value = id_categoria;
        document.getElementById('edit-id_proveedor').value = id_proveedor;

        let modal = new bootstrap.Modal(document.getElementById('modalEditarProducto'));
        modal.show();
    }
</script>
</body>
</html>