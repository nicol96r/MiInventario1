<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../models/LoginModel.php";

class LoginController
{
    public $email;
    public $password;

    public function ctrLogin()
    {
        // Llamar correctamente a LoginModel en lugar de UsuarioModel
        $respuesta = LoginModel::mdlLogin($this->email, $this->password);

        if ($respuesta["codigo"] === "200") {
            // Guardar sesión
            $_SESSION['id_usuario'] = $respuesta['id_usuario'];
            $_SESSION['email'] = $this->email;

            header("Location: ../views/dashboard.php?msg=" . urlencode($respuesta["mensaje"]) . "&status=success");
            exit();
        } else {
            header("Location: ../views/login.php?msg=" . urlencode($respuesta["mensaje"]) . "&status=error");
            exit();
        }
    }
}

// Verificar que los datos lleguen correctamente y sanitizarlos
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $objLogin = new LoginController();
    $objLogin->email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $objLogin->password = trim($_POST["password"]);
    $objLogin->ctrLogin();
} else {
    header("Location: ../views/login.php?msg=" . urlencode("Faltan datos") . "&status=error");
    exit();
}
