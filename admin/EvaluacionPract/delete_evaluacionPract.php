<?php

require_once '../config.php';
require_once('../classes/EvaluacionPract.php');



    // Obtener el id de la URL
    $id = $_GET['id'];


    // URL base de la API
    $base_url = "http://localhost:5170/api/EvaluacionPractica"; 
    // Crear una instancia del objeto Planificacion con la URL base
    $evaPract = new EvaluacionPract($base_url);

    // Obtener los detalles del registro de planificación por su id
    $row = $evaPract->eliminarEvaluacionPractica($id);

   
    exit();


?>