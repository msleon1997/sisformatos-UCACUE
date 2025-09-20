<?php
require_once '../config.php';

class RecuperarContrasena extends DBConnection {

    public function checkUserExists($cedula) {
        $cedula = trim($cedula);
        if(empty($cedula)) return false;

        $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE cedula = ?");
        $stmt->bind_param('s', $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function updatePassword($cedula, $password) {
        if(!$this->checkUserExists($cedula)) {
            echo "<script>alert('Usuario no encontrado.')</script>";
            return false;
        }

        // Validación 
        if(strlen($password) < 8) {
            echo "<script>alert('La contraseña debe tener al menos 8 caracteres.')</script>";
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE cedula = ?");
        $stmt->bind_param('ss', $hashed_password, $cedula);

        if ($stmt->execute()) {
            echo "<script>alert('Contraseña actualizada correctamente.'); window.location.href = 'login.php';</script>";
        } else {
            error_log("Error al actualizar la contraseña para cedula $cedula");
            echo "<script>alert('Error al actualizar la contraseña.')</script>";
        }

        $stmt->close();
        return true;
    }
}

?>
