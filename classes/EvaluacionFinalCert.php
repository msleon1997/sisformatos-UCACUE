<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class EvaluacionFinalCert extends DBConnection{


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
     public function obtenerEvaluacionFinalCert()
     {
         $url = $this->base_url;
         $response = file_get_contents($url);
         return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
     }
    
     // Método para obtener una planificación por su ID
    public function obtenerEvaluacionFinalCertPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerEvaluacionFinalCertPorUser($users_id)
    {
    $url = $this->base_url . "/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

     public function obtenerActividadesPorUser($users_id)
    {
    $url = $this->base_url . "/actividadesByUser/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }


    
    public function crearEvaluacionFinalCert($datos)
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
            //echo "<script>alert('Evaluacion Final registrada satisfactoriamente.')</script>";
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Evaluacion Final registrada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=EvaluacionFinalCertificado';
                    }
                });
            </script>";
    
        } else {
           // echo "<script>alert('Error al registrar la evaluacion final.')</script>";
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar la evaluación final.',
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




    public function actualizarEvaluacionFinalCert($id, $datos)
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
        //echo "<script>alert('Registro Evaluacion Final actualizada satisfactoriamente.')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro Evaluacion Final actualizada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=EvaluacionFinalCertificado';
                    }
                });
            </script>";
        //echo "<script>window.location.href = './?page=EvaluacionFinalCertificado'</script>";
    } else {
        $error = error_get_last(); 
        //echo "<script>alert('Error al actualizar la evaluacion practica: " . $error['message'] . "')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar la evaluación final: " . $error['message'] . "',
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
 public function eliminarEvaluacionFinalCert($id)
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
     //echo "<script>alert('Registro de Evaluacion Final Eliminada satisfactoriamente.')</script>";
     echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro de Evaluacion Final Eliminada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=EvaluacionFinalCertificado';
                    }
                });
            </script>";
     //echo "<script>window.location.href = './?page=EvaluacionFinalCertificado'</script>";
 } else {
     // Si hubo un error en la solicitud, mostrar una alerta
     $error = error_get_last(); 
     //echo "<script>alert('Error al eliminar el registro de la evaluacion final: " . $error['message'] . "')</script>";
     echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar el registro de la evaluacion final: " . $error['message'] . "',
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