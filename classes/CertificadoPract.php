<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class CertificadoPract extends DBConnection{
    
private $settings;
	
	public function __destruct(){
		parent::__destruct();
	}


    private $base_url;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
    }

     public function obtenerCertificadoPract()
     {
         $url = $this->base_url;
         $response = file_get_contents($url);
         return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
     }
    
    public function obtenerCertificadoPractPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerCertificadoPractPorUser($users_id)
    {
    $url = $this->base_url . "/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

public function obtenerMatriculacionActividades($users_id)
{
    $url = $this->base_url . "/matriculacion-actividades/" . $users_id;
    $response = file_get_contents($url);

    if ($response === false) {
        return null; 
    }

    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
}


    public function crearCertificadoPract($datos)
    {
        $url = $this->base_url;
        $opciones = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => json_encode($datos)
            )
        );
        $context  = stream_context_create($opciones);
        $response = file_get_contents($url, false, $context);
    
        if ($response) {
           
           echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Certificado de practicas registrado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=CertificadoPract';
                    }
                });
            </script>";
            
    
        } else {
            
            echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al registrar el Certificado de practicas.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
        } 
    
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }
    


public function actualizarCertificadoPract($id, $datos)
{
    $url = $this->base_url . "/" .$id;
    $opciones = array(
        'http' => array(
            'method'  => 'PUT',
            'header'  => 'Content-type: application/json',
            'content' => json_encode($datos)
        )
    );
    $context  = stream_context_create($opciones);
    $response = file_get_contents($url, false, $context);

    if ($response !== false) {
        
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Certificado de practicas actualizado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=CertificadoPract';
                    }
                });
            </script>";
    } else {
        $error = error_get_last(); 
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar el Certificado de practicas: " . $error['message'] . "',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        return null;
    }

    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
}




    public function eliminarCertificadoPract($id)
    {
        $url = $this->base_url . "/" . $id;
        $opciones = array(
            'http' => array(
                'method'  => 'DELETE',
                'header'  => 'Content-type: application/json'
            )
        );
        $context  = stream_context_create($opciones);
        $response = file_get_contents($url, false, $context);
     

    if ($response !== false) {
        
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Certificado de practicas Eliminado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=CertificadoPract';
                    }
                });
            </script>";
    } else {
        $error = error_get_last(); 
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar el Certificado de practicas: " . $error['message'] . "',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        return null;
    }

    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }
}



?>