<?php

require_once '../config.php';
require_once('../classes/EvaluacionFinalCert.php');



    // Obtener el id de la URL
    $id = $_GET['id'];


    // URL base de la API
    $base_url = "http://localhost:5170/api/EvaluacionFinalCertificado"; 
    // Crear una instancia del objeto Planificacion con la URL base
    $evaFinal = new EvaluacionFinalCert($base_url);

    // Obtener los detalles del registro de planificación por su id
    $row = $evaFinal->eliminarEvaluacionFinalCert($id);

   
    exit();


?>