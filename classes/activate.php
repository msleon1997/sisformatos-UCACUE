<?php
require_once '../config.php';

class ActivateAccount extends DBConnection {
    public function activate($token) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE activation_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            $stmt = $this->conn->prepare("UPDATE users SET status = '1', activation_token = NULL WHERE id = ?");
            $stmt->bind_param("i", $user['id']);
            $stmt->execute();

            echo "<script>alert('Cuenta activada correctamente.'); window.location.href = 'http://172.16.106.17/admin/login.php';</script>";
        } else {
            echo "<script>alert('Token de activación no válido.'); window.location.href = 'http://172.16.106.17/admin/register.php';</script>";
        }
    }
}

if (isset($_GET['token'])) {
    $activation = new ActivateAccount();
    $activation->activate($_GET['token']);
}
?>
