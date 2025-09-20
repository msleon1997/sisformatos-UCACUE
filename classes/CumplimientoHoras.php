<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class CumplimientoHoras extends DBConnection{


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
     public function obtenerCumplimientoHoras()
     {
         $url = $this->base_url;
         $response = file_get_contents($url);
         return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
     }
    
     // Método para obtener una planificación por su ID
    public function obtenerCumplimientoHorasPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerCumplimientoHorasPorUser($users_id)
    {
    $url = $this->base_url . "/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
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
    
    public function crearCumplimeintoHoras($datos)
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
           // echo "<script>alert('Registro de Horas Practicas registradas satisfactoriamente.')</script>";
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro de Horas Practicas registradas satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=CumplimientoHoras';
                    }
                });
            </script>";
    
        } else {
            // Si hubo un error en el registro, mostrar una alerta
           // echo "<script>alert('Error al registrar el cumplimiento de horas practicas.')</script>";
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar el cumplimiento de horas practicas.',
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




    public function actualizarCumplimientoHoras($id, $datos)
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
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro de Horas Practicas actualizado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=CumplimientoHoras';
                    }
                });
            </script>";
       // echo "<script>window.location.href = './?page=CumplimientoHoras'</script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); 
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar el cumplimiento de horas practicas.',
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
 public function eliminarCumplimientoHoras($id)
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
     //echo "<script>alert('Registro de Horas Practicas Eliminada satisfactoriamente.')</script>";
     echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro de Horas Practicas Eliminada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=CumplimientoHoras';
                    }
                });
            </script>";
    // echo "<script>window.location.href = './?page=CumplimientoHoras'</script>";
 } else {
     // Si hubo un error en la solicitud, mostrar una alerta
     $error = error_get_last(); // Obtener el último error ocurrido
     //echo "<script>alert('Error al eliminar el cumplimiento de horas practicas: " . $error['message'] . "')</script>";
     echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar el cumplimiento de horas practicas.',
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


   public function obtenerEstudiantes() {
        $query = "SELECT id, firstname, lastname FROM users WHERE type = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $estudiantes = [];
        while ($row = $result->fetch_assoc()) {
            $estudiantes[] = $row;
        }
        return $estudiantes;
    }


}

?>
