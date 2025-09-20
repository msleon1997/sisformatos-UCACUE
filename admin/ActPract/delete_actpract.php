<?php

require_once '../config.php';
require_once('../classes/ActPract.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


    // Obtener el id de la URL
    $id = $_GET['id'];


    // URL base de la API
    $base_url = "http://localhost:5170/api/ActividadesPracticas"; 
    // Crear una instancia del objeto Planificacion con la URL base
    $ActPract = new ActPract($base_url);

    // Obtener los detalles del registro de planificación por su id
    $row = $ActPract->eliminarActPract($id);

   
    exit();


?>