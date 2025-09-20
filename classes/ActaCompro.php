<?php


require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

class ActaCompro extends DBConnection{

    private $settings;
	
	public function __destruct(){
		parent::__destruct();
	}


    private $base_url;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
    }

     // Método para obtener todas las planificaciones
     public function obtenerActaCompro()
     {
         $url = $this->base_url;
         $response = file_get_contents($url);
         return $responseData = json_decode($response, true);
         if (!is_array($responseData)) {
                $responseData = [];
        }

     }

    public function obtenerMatriculaciones($users_id){
            $url = $this->base_url . "/obtenerMatriculacionByUser/" . $users_id;;
            $response = file_get_contents($url);
            return $responseData = json_decode($response, true);
            if (!is_array($responseData)) {
                $responseData = [];
            }

    }
    
     // Método para obtener una planificación por su ID
    public function obtenerActaComproPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }

    }

    public function obtenerActaComproPorUser($users_id)
    {
        $url = $this->base_url . "/" . $users_id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }

    }



    public function crearActaCompro($datos)
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
    
        // Verificar si la inserción fue exitosa
        if ($response) {
            // Si el registro fue exitoso, mostrar una alerta
            //echo "<script>alert('Acta de Compromiso registrada satisfactoriamente.')</script>";
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Acta de Compromiso registrada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=ActPract/ActaCompro';
                    }
                });
            </script>";
    
        } else {
            // Si hubo un error en el registro, mostrar una alerta
            //echo "<script>alert('Error al registrar el Acta de Compromiso.')</script>";
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar el Acta de Compromiso.',
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
    


public function actualizarActaCompro($id, $datos)
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

    // Verificar si la actualización fue exitosa
    if ($response !== false) {
        // Si la actualización fue exitosa, mostrar una alerta
       // echo "<script>alert(' Acta de Compromiso actualizada satisfactoriamente.')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Acta de Compromiso actualizada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=ActPract/ActaCompro';
                    }
                });
            </script>";
        //echo "<script>window.location.href = './?page=ActPract/ActaCompro'</script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last();
        error_log("Error al actualizar acta: " . $error['message']);
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al actualizar el acta de compromiso.',
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




    // Método para eliminar una planificación
    public function eliminarActaCompro($id)
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
     

        // Verificar si la actualización fue exitosa
    if ($response !== false) {
        // Si la actualización fue exitosa, mostrar una alerta
        //echo "<script>alert(' Acta de Compromiso Eliminada satisfactoriamente.')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Acta de Compromiso Eliminada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=ActPract/ActaCompro';
                    }
                });
            </script>";
       // echo "<script>window.location.href = './?page=ActPract/ActaCompro'</script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last();
        error_log("Error al actualizar acta: " . $error['message']);
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al actualizar el acta de compromiso.',
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