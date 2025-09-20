<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class RegistrarDocente extends DBConnection
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
    

    public function checkUserExists($cedula)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE cedula = ?");
            $stmt->bind_param('s', $cedula);
            $stmt->execute();
            $result = $stmt->get_result();

        // Si el usuario ya existe, retornar verdadero, de lo contrario, retornar falso
        return $result->num_rows > 0;

        } catch (Exception $e) {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al preparar la consulta: " . $e->getMessage() . "',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
            return null;
        }
        
    }


    public function obtenerDocentes()
    {
        $url = $this->base_url;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
                if (!is_array($responseData)) {
                    $responseData = [];
                }
    }

        // Método para obtener un usuario por su ID
    public function obtenerDocentePorId($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new InvalidArgumentException("ID inválido");
        }

        $url = $this->base_url . "/" . $id;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
                if (!is_array($responseData)) {
                    $responseData = [];
                }
    }
    

    public function validarCedulaEcuatoriana($cedula){
        if (!preg_match('/^\d{10}$/', $cedula)) return false;

        $digitos = str_split($cedula);
        $suma = 0;

        for ($i = 0; $i < 9; $i++) {
            $val = intval($digitos[$i]);
            if ($i % 2 == 0) {
                $val *= 2;
                if ($val > 9) $val -= 9;
            }
            $suma += $val;
        }

        $verificador = (10 - ($suma % 10)) % 10;
        return $verificador == intval($digitos[9]);
    }


    public function validarCorreoDocente($correo)
    {
        return filter_var($correo, FILTER_VALIDATE_EMAIL) &&
            str_ends_with(strtolower($correo), '@ucacue.edu.ec');
    }

 
    public function crearDocente($datos){
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
         if (!$this->validarCedulaEcuatoriana($datos['cedula'])) {
             echo "<script>
                 Swal.fire({
                     title: 'Error',
                     text: 'Cédula ecuatoriana no válida.',
                     icon: 'error',
                     confirmButtonText: 'OK'
                 });
             </script>";
             return null;
         }
     
         if (!$this->validarCorreoDocente($datos['email'])) {
             echo "<script>
                 Swal.fire({
                     title: 'Error',
                     text: 'El correo debe ser institucional (@ucacue.edu.ec).',
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
                     text: 'Docente registrado satisfactoriamente.',
                     icon: 'success',
                     confirmButtonText: 'OK'
                 }).then((result) => {
                     if (result.isConfirmed) {
                         window.location.href = './login.php';
                     }
                 });
             </script>";
         } else {
             echo "<script>
                 Swal.fire({
                     title: 'Error',
                     text: 'Error al registrar el docente.',
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

     public function actualizarDocente($id, $datos){

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
                        text: 'Docente actualizado satisfactoriamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './?page=user';
                        }
                    });
                </script>";
        } else {
            // Si hubo un error en la solicitud, mostrar una alerta
            $error = error_get_last(); // Obtener el último error ocurrido
            echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Error al actualizar el docente. " . $error['message'] . "',
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
    


    public function eliminarDocente($idDocente)
    {
        $url = $this->base_url . "/" . $idDocente;
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
        // Si la actualización fue exitosa
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Docente Eliminado satisfactoriamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './login.php';
                    }
                });
            </script>";
    } else {
        // Si hubo un error
        $error = error_get_last(); 
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Error al eliminar el docente " . $error['message'] . "',
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