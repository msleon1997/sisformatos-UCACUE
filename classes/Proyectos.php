<?php
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class Proyectos extends DBConnection{


   
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
 
    // Método para obtener todas las Proyectos
    public function obtenerProyectos()
    {
        $url = $this->base_url;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }
    
      public function obtenerDocentesResponsables()
    {
        $url = $this->base_url . "/obtenerDocentesResponsables";
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

       public function obtenerDocentesTutores()
    {
        $url = $this->base_url . "/obtenerDocentesTutores";
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }
    // Método para obtener una planificación por su ID
    public function obtenerProyectoPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerProyectoPorDocente($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }




public function crearProyecto($datos)
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
                    text: 'Proyecto registrado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=Proyectos';
                    }
                });
            </script>";

    } else {
        // Si hubo un error en el registro, mostrar una alerta
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al registrar la Proyecto.',
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

public function actualizarProyecto($id, $datos)
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
                    text: 'Proyecto actualizado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=Proyectos';
                    }
                });
            </script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); // Obtener el último error ocurrido
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al actualizar el proyecto. " . $error['message'] . "',
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



    // Método para eliminar un proyecto
    public function eliminarProyecto($idProyecto)
    {
        $url = $this->base_url . "/" . $idProyecto;
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
                    text: 'Proyecto Eliminado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=Proyectos';
                    }
                });
            </script>";
    } else {
        // Si hubo un error en la solicitud, mostrar una alerta
        $error = error_get_last(); // Obtener el último error ocurrido
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al eliminar el proyecto " . $error['message'] . "',
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