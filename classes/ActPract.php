<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;


class ActPract extends DBConnection{

    private $settings;
	
	public function __destruct(){
		parent::__destruct();
	}


    private $base_url;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
    }

     public function obtenerActPrat()
     {
         $url = $this->base_url;
         $response = file_get_contents($url);
         return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
     }
    
    public function obtenerActPractPorId($id)
    {
        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerActPractPorUser($users_id)
    {
    $url = $this->base_url . "/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

    public function obtenerMatriculacionPorUser($users_id)
    {
    $url = $this->base_url . "/matrculasByUser/" . $users_id;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

     public function obtenerDocenteTutor()
    {
    $url = $this->base_url . "/DocenteTutor" ;
    $response = file_get_contents($url);
    return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }


    public function crearActPract($datos)
    {
        
        
        $cedula_doc = $datos["App_Cedula_doc"];

        if (isset($datos["App_Cedula_est"])) {
            $cedulas_est = $datos["App_Cedula_est"];
        
            function validarFormatoCedula($cedula) {
                return preg_match("/^[0-9]{10}$/", $cedula);
            }
        
            $cedulas = array_map('trim', explode(',', $cedulas_est));
        
            foreach ($cedulas as $cedula) {
                if (!validarFormatoCedula($cedula)) {
                    echo "<script>
                            Swal.fire({
                                title: 'Error',
                                text: 'El formato de la cédula \"$cedula\" es inválido. Cada cédula debe contener exactamente 10 dígitos numéricos.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        </script>";
                    return null;
                }
            }
        
            echo "<script>
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Todas las cédulas son válidas.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>";
        }
        
        


    
            if (!preg_match("/^[0-9]{10}$/", $cedula_doc)) {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'El formato de la cédula del docente es inválido. Debe contener exactamente 10 dígitos numéricos.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
                return null; 
            
        }

     

    
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
                    text: 'Actividades Practicas registradas satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=ActPract';
                    }
                });
            </script>";
            
    
        } else {
           
            echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al registrar las actividades practicas.',
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
    


public function actualizarActPract($id, $datos)
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
                    text: 'Actividades practicas actualizadas satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=ActPract';
                    }
                });
            </script>";
    } else {
        $error = error_get_last(); 
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar las actividades practicas: " . $error['message'] . "',
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




    public function eliminarActPract($id)
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
                    text: 'Actividad Practica Eliminada satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=ActPract';
                    }
                });
            </script>";
    } else {
        $error = error_get_last(); 
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar el registro de actividades practicas: " . $error['message'] . "',
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