<?php

require_once '../config.php';
require_once('../classes/CertificadoPract.php');



    // Obtener el id de la URL
    $id = $_GET['id'];


    $base_url = "http://localhost:5170/api/CertificadoPracticas"; 
    $CertificadoPract = new CertificadoPract($base_url);

    $row = $CertificadoPract->eliminarCertificadoPract($id);

   
    exit();


?>