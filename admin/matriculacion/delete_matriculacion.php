<?php

require_once '../config.php';
require_once('../classes/Matriculacion.php');



    // Obtener el id de la URL
    $id = $_GET['id'];


    // URL base de la API
    $base_url = "http://localhost:5170/api/Matriculacion"; 
    // Crear una instancia del objeto Planificacion con la URL base
    $matriculacion = new Matriculacion($base_url);

    // Obtener los detalles del registro de planificación por su id
    $row = $matriculacion->eliminarMatriculacion($id);

   
    exit();


?>s