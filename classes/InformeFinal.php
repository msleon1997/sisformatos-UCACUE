<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class InformeFinal extends DBConnection{


    private $settings;
	
	public function __destruct(){
		parent::__destruct();
	}


    private $base_url;

    public function __construct($base_url)
    {
        parent::__construct(); 
        $this->base_url = $base_url;
    }
    

     public function obtenerInformeFinal()
     {
         $url = $this->base_url;
         $response = file_get_contents($url);
         return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
     }
    
    public function obtenerInformeFinalPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerInformeFinalPorUser($users_id)
    {
    $url = $this->base_url . "/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerPlanificacionPorUser($user_id) {
         $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
    if ($user_id === false) {
        return null;
    }
      
        $query = "SELECT id FROM planificacion WHERE users_id = ?";
        try {
            $stmt = $this->conn->prepare($query); 
            $stmt->bind_param("i", $user_id); 
            $stmt->execute();
            $result = $stmt->get_result(); 
            return $result->fetch_assoc(); 
        } catch (Exception $e) {
            error_log("Error obtenerPlanificacionPorUser: " . $e->getMessage());
            return null;
        }
        
    }


    public function obtenerPlanificaciones($users_id){
            $url = $this->base_url . "/planificacionByUser/" . $users_id;;
            $response = file_get_contents($url);
            return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerPlanificacionPorUsuarioLogueado($user_id) {
    $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
    if ($user_id === false) {
        return null;
    }

    $query = "SELECT * FROM planificacion WHERE users_id = ?";
    try {
        $stmt = $this->conn->prepare($query); 
        $stmt->bind_param("i", $user_id); 
        $stmt->execute();
        $result = $stmt->get_result(); 
        return $result->fetch_assoc(); 
    } catch (Exception $e) {
        error_log("Error obtenerPlanificacionPorUsuarioLogueado: " . $e->getMessage());
        return null;
    }
}

    
    
    
    
    
    public function crearInformeFinal($datos)
    {
        $url = $this->base_url;
        $opciones = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => "Content-type: application/json",
                'content' => json_encode($datos),
                'ignore_errors' => true 
            )
        );
    
        $context  = stream_context_create($opciones);
        $response = file_get_contents($url, false, $context);
    
        if ($response === FALSE) {
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Error en la conexión con la API.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=Informe_final';
                    }
                });
            </script>";
            return null;
        }
    
        $responseDecoded = json_decode($response, true);
    
        if (isset($http_response_header)) {
            $httpStatusLine = $http_response_header[0];
            if (strpos($httpStatusLine, "200") === false && strpos($httpStatusLine, "201") === false) {
                echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error en la API: " . $httpStatusLine . "',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    </script>";
                return null;
            }
        }
    
        if (isset($responseDecoded['error'])) {
            echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error de la API: " . $responseDecoded['error'] . "',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Informe registrado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=Informe_final';
                    }
                });
            </script>";
        }
    
        return $responseDecoded;
    }
    




    public function actualizarInformeFinal($id, $datos)
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
                    text: 'Registro Informe Final actualizado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=Informe_final';
                    }
                });
            </script>";
    } else {
        $error = error_get_last();
        echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al actualizar el informe: " . $error['message'] . "',
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


 public function eliminarInformeFinal($id)
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
                text: 'Registro del Informe Eliminada satisfactoriamente.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './?page=Informe_final';
                }
            });
        </script>";
 } else {
     $error = error_get_last();
     echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al eliminar el registro del informe: " . $error['message'] . "',
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
