<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class CronoActi extends DBConnection{


    private $settings;
	
	public function __destruct(){
		parent::__destruct();
	}


    private $base_url;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
    }

     // Método para obtener todo el cronograma
     public function obtenerCronoActi()
     {
         $url = $this->base_url;
         $response = file_get_contents($url);
         return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
     }
    
     // Método para obtener un cronograma por su ID
    public function obtenerCronoActiPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerCronoActiPorUser($users_id)
    {
    $url = $this->base_url . "/" . $users_id;
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
    


    public function crearCronoActi($datos)
    {

        
        // Si la validación pasa, continuar con la creación de las actividades prácticas
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
            //echo "<script>alert('Cronograma de Actividades registrado satisfactoriamente.')</script>";
            echo "<script>
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Cronograma de Actividades registrado satisfactoriamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './?page=ActPract/CronoActPract';
                        }
                    });
                </script>";
    
        } else {
            // Si hubo un error en el registro, mostrar una alerta
            //echo "<script>alert('Error al registrar las actividades en el Cronograma.')</script>";
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar las actividades en el Cronograma.',
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
    


    public function actualizarCronoActi($id, $datos)
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
        //echo "<script>alert('Actividades del Cronograma actualizadas satisfactoriamente.')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Actividades del Cronograma actualizadas satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=ActPract/CronoActPract';
                    }
                });
            </script>";
       // echo "<script>window.location.href = './?page=ActPract/CronoActPract'</script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); // Obtener el último error ocurrido
        //echo "<script>alert('Error al actualizar las actividades del cronograma: " . $error['message'] . "')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar las actividades del cronograma: " . $error['message'] . "',
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

public function eliminarCronoActi($id)
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
        //echo "<script>alert('Cronograma de actividades Eliminado satisfactoriamente.')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Cronograma de actividades Eliminado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=ActPract/CronoActPract';
                    }
                });
            </script>";
        //echo "<script>window.location.href = './?page=ActPract/CronoActPract'</script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); // Obtener el último error ocurrido
        //echo "<script>alert('Error al eliminar el cronograma de actividades: " . $error['message'] . "')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar el cronograma de actividades: " . $error['message'] . "',
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