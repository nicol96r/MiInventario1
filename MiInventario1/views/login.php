<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: dashboard.php");
    exit();
}

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluye Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="login-page">

<!-- Contenedor principal para los formularios -->
<div class="form-wrapper">
    <!-- Formulario de Inicio de Sesión -->
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="../controllers/LoginController.php" method="POST">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" name="login">Iniciar Sesión</button>
        </form>
    </div>

    <!-- Formulario de Registro -->
    <div class="registro-container">
        <h2>Registrar Usuario</h2>
        <form action="../controllers/RegisterController.php" method="POST">
            <select name="tipo_documento" required>
                <option value="Cédula">Cédula</option>
                <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                <option value="Pasaporte">Pasaporte</option>
            </select>
            <input type="text" name="documento" placeholder="Número de documento" required>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="date" name="fecha_nacimiento" required>
            <select name="genero" required>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" name="register">Registrar</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const msg = "<?php echo $msg; ?>";
        const status = "<?php echo $status; ?>";

        if (msg && status) {
            Swal.fire({
                icon: status === 'success' ? 'success' : 'error',
                title: status === 'success' ? 'Éxito' : 'Error',
                text: msg
            });
        }
    });
</script>

</body>
</html>