<?php
require_once('../config.php');
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $docente_id = $_POST['docente_id'];
    $area = $_POST['area'];  
    $nombre_proyecto = $_POST['nombre_proyecto'];

    if (empty($docente_id) || empty($area) || empty($nombre_proyecto)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit();
    }

    // Consulta SQL para insertar en la tabla 'area_docente' con el nuevo campo
    $query = "INSERT INTO area_docente (area, id_docente, nombre_proyecto) VALUES (?, ?, ?)";
    try {
        $stmt = $conn->prepare($query);

    } catch (Exception $e) {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al preparar la consulta: " . $e->getMessage() . "',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
            return null;
        }
        
    

    if ($stmt === false) {
        echo "<script>alert('Error al preparar la consulta.'); window.history.back();</script>";
        exit();
    }

    $stmt->bind_param('sis', $area, $docente_id, $nombre_proyecto); 

    if ($stmt->execute()) {
        echo "<script>alert('Área registrada con éxito.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar el área.'); window.history.back();</script>";
    }

    $stmt->close();
}
?>
