<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

class OficioCarrera extends DBConnection {

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
    public function obtenerOficioCarrera()
    {
        $url = $this->base_url;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    // Método para obtener una planificación por su ID
    public function obtenerOficioCarreraPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerOficioCarreraPorUser($users_id)
{
    $url = $this->base_url . "/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
}

    public function obtenerMatriculaPorUser($users_id)
{
    $url = $this->base_url . "/matriculaByUser/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
}

public function crearOficioCarrera($datos)
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
            text: 'Oficio registrado satisfactoriamente.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './?page=oficio';
            }
        });
    </script>";

    } else {
        // Si hubo un error en el registro, mostrar una alerta
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al registrar el Oficio de direccion de carrera.',
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

public function actualizarOficioCarrera($id, $datos)
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
            text: 'Oficio actualizado satisfactoriamente.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './?page=oficio';
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
    public function eliminarOficioCarrera($id)
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
        echo "<script>
        Swal.fire({
            title: 'Éxito',
            text: 'Oficio Eliminad satisfactoriamente.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './?page=oficio';
            }
        });
    </script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); // Obtener el último error ocurrido
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al eliminar el Oficio de direccion de carrera. " . $error['message'] . "',
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

