<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "Conexion.php";

class LoginModel {
    public static function mdlLogin($email, $password)
    {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("SELECT * FROM Usuario WHERE email = :email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado && password_verify($password, $resultado['password'])) {
                // Guardar datos en sesión
                $_SESSION['id_usuario'] = $resultado['id_usuario'];
                $_SESSION['nombre'] = $resultado['nombre'];
                $_SESSION['apellido'] = $resultado['apellido'];

                // Redirigir a dashboard.php
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                return array(
                    "codigo" => "401",
                    "mensaje" => "Usuario no existe o contraseña incorrecta, por favor verifique los datos introducidos"
                );
            }
        } catch (Exception $e) {
            return array(
                "codigo" => "500",
                "mensaje" => "Error en la conexión: " . $e->getMessage()
            );
        }
    }

    public static function mdlObtenerUsuarioPorId($id_usuario) {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM Usuario WHERE id_usuario = :id_usuario");
            $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener usuario: " . $e->getMessage();
            return false;
        }
    }

    public static function mdlObtenerRolesUsuario($id_usuario) {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT r.id_rol, r.nombre 
                FROM rol_usuario r 
                INNER JOIN usuario_rol ur ON r.id_rol = ur.id_rol 
                WHERE ur.id_usuario = :id_usuario
            ");
            $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener roles: " . $e->getMessage();
            return [];
        }
    }

    public static function mdlActualizarUsuario($datos) {
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE Usuario SET 
                tipo_documento = :tipo_documento,
                documento = :documento,
                nombre = :nombre,
                apellido = :apellido,
                fecha_nacimiento = :fecha_nacimiento,
                genero = :genero,
                email = :email
                WHERE id_usuario = :id_usuario");

            $stmt->bindParam(":tipo_documento", $datos['tipo_documento'], PDO::PARAM_STR);
            $stmt->bindParam(":documento", $datos['documento'], PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(":apellido", $datos['apellido'], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_nacimiento", $datos['fecha_nacimiento'], PDO::PARAM_STR);
            $stmt->bindParam(":genero", $datos['genero'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
            $stmt->bindParam(":id_usuario", $datos['id_usuario'], PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar usuario: " . $e->getMessage();
            return false;
        }
    }

    public static function mdlCambiarPassword($id_usuario, $password_nueva) {
        try {
            $password_hash = password_hash($password_nueva, PASSWORD_DEFAULT);

            $stmt = Conexion::conectar()->prepare("UPDATE Usuario SET 
                password = :password
                WHERE id_usuario = :id_usuario");

            $stmt->bindParam(":password", $password_hash, PDO::PARAM_STR);
            $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al cambiar contraseña: " . $e->getMessage();
            return false;
        }
    }

    public static function mdlVerificarPassword($id_usuario, $password_actual) {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT password FROM Usuario WHERE id_usuario = :id_usuario");
            $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado && password_verify($password_actual, $resultado['password'])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al verificar contraseña: " . $e->getMessage();
            return false;
        }
    }
}