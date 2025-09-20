<?php

require_once '../config.php';
require_once('../classes/Planificacion.php');



    // Obtener el id de la URL
    $id = $_GET['id'];


    // URL base de la API
    $base_url = "http://localhost:5170/api/Planificacion"; 
    // Crear una instancia del objeto Planificacion con la URL base
    $planificacion = new Planificacion($base_url);

    // Obtener los detalles del registro de planificación por su id
    $row = $planificacion->eliminarPlanificacion($id);

   
    exit();


?>