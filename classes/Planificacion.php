<?php
require_once '../config.php';

$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class Planificacion extends DBConnection
{

    
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
 
    // Método para obtener todas las planificaciones
    public function obtenerPlanificaciones()
    {
        $url = $this->base_url;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    // Método para obtener una planificación por su ID
    public function obtenerPlanificacionPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerPlanificacionPorUser($id)
{
    $url = $this->base_url . "/" . $id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
}

 // Método para obtener el ID de matriculación por user_id
    public function obtenerMatriculacionPorUser($user_id) {
        $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
        if ($user_id === false) {
            return null;
        }

    $query = "SELECT id FROM matriculacion WHERE users_id = ?";
    try {
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
   
    } catch (Exception $e) {
        error_log("Error al obtener la matriculación: " . $e->getMessage());
        return null;
    }    
   
    
}

 public function obtenerProyectos($users_id){
        $url = $this->base_url . "/proyectos/" . $users_id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
}

public function obtenerDocentes(){
        $url = $this->base_url . "/docentes/";
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
}
public function obtenerDocentesTutores(){
        $url = $this->base_url . "/docentesTutores/";
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
}

public function obtenerPlanificacionWithMatriculacion($users_id)
{
    $url = $this->base_url . "/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

public function crearPlanificacion($datos)
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
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Planificacion registrada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=planificacion';
                    }
                });
            </script>";

    } else {
        // Si hubo un error en el registro, mostrar una alerta
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al registrar la planificacion.',
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

public function actualizarPlanificacion($id, $datos)
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
                    text: 'Planificación actualizada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=planificacion';
                    }
                });
            </script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); // Obtener el último error ocurrido
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al actualizar la planificación. " . $error['message'] . "',
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
    public function eliminarPlanificacion($idPanicacion)
    {
        $url = $this->base_url . "/" . $idPanicacion;
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
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Planificación Eliminada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=planificacion';
                    }
                });
            </script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); // Obtener el último error ocurrido
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al eliminar la planificación " . $error['message'] . "',
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




    public function esLiderGrupo($user_id) {
        $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
        if ($user_id === false) {
            return null;
        }
          $query = "SELECT lider_group FROM users WHERE id = ?";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
         return $row && $row['lider_group'] == 1;
        
        } catch (Exception $e) {
            error_log("Error al preparar la consulta: " . $e->getMessage());
            return null;
        }

      
        
    }

    public function obtenerEstudiantes() {
        $query = "SELECT id, firstname, lastname FROM users WHERE lider_group = 0 AND type = 1"; // Solo los que no son líderes
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $estudiantes = [];
            while ($row = $result->fetch_assoc()) {
                $estudiantes[] = $row;
            }
            return $estudiantes;
        
        } catch (Exception $e) {
            error_log("Error al preparar la consulta: " . $e->getMessage());
            return [];
        }
        
    }
    

    
    
}

?>
