<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class InformeTutorias extends DBConnection{


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
    

     // Método para obtener todos los informes
     public function obtenerInformeTutorias()
     {
         $url = $this->base_url;
         $response = file_get_contents($url);
         return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
     }
    
     // Método para obtener un registro por su ID
    public function obtenerInformeTutoriasPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerInformeTutoriasPorUser($users_id)
    {
    $url = $this->base_url . "/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

     public function obtenerPlanificacionesActividadesInformes($users_id){
            $url = $this->base_url . "/planificacion-actividades-informe/" . $users_id;;
            $response = file_get_contents($url);
            return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

// Método para obtener el ID de planificacion por user_id
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
            error_log("Error al preparar la consulta: " . $e->getMessage());
            return null;
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
            error_log("Error al preparar la consulta: " . $e->getMessage());
            return null;
        }
        
    }
    
    
    
    
    
    public function crearInformeTutorias($datos)
    {

        // Si la validación pasa, continuar con la creación del informe final
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
            //echo "<script>alert('Informe registrado satisfactoriamente.')</script>";
            echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Informe registrado satisfactoriamente',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=InformeTutorias';
                    }
                });
            </script>";
    
        } else {
            // Si hubo un error en el registro, mostrar una alerta
            //echo "<script>alert('Error al registrar el informe.')</script>";
            echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al registrar el informe.',
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




    public function actualizarInformeTutorias($id, $datos)
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
        //echo "<script>alert('Registro Informe actualizado satisfactoriamente.')</script>";
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro Informe actualizado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=InformeTutorias';
                    }
                });
            </script>";
       // echo "<script>window.location.href = './?page=InformeTutorias'</script>"; 
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); // Obtener el último error ocurrido
        //echo "<script>alert('Error al actualizar el informe: " . $error['message'] . "')</script>";
        echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al actualizar el informe.',
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
 public function eliminarInformeTutorias($id)
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
     //echo "<script>alert('Registro del Informe Eliminada satisfactoriamente.')</script>";
     echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro del Informe Eliminada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=InformeTutorias';
                    }
                });
            </script>";
    // echo "<script>window.location.href = './?page=InformeTutorias'</script>";
 } else {
     // Si hubo un error en la solicitud, mostrar una alerta
     $error = error_get_last(); // Obtener el último error ocurrido
     //echo "<script>alert('Error al eliminar el registro del informe: " . $error['message'] . "')</script>";
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
