<?php
require_once '../config.php';
$csrf_token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
class Register extends DBConnection {
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
        
        $query = "SELECT * FROM users WHERE cedula = ?";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $cedula);
            $stmt->execute();
            $result = $stmt->get_result();

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


    // Método para obtener todos los usuarios
    public function obtenerUsuarios()
    {
        $url = $this->base_url;
        $response = file_get_contents($url);
        return $responseData = json_decode($response, true);
        if (!is_array($responseData)) {
            $responseData = [];
        }
    }

        // Método para obtener un usuario por su ID
        public function obtenerUsuarioPorId($id)
        {
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

    // Validar correo institucional
    public function validarCorreoEstudiantil($correo)
    {
        return filter_var($correo, FILTER_VALIDATE_EMAIL) &&
            str_ends_with(strtolower($correo), '@est.ucacue.edu.ec');
    }

 
    
    
        public function crearUsuario($datos){
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
        
            if (!$this->validarCorreoEstudiantil($datos['email'])) {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'El correo debe ser institucional (@est.ucacue.edu.ec).',
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
                        text: 'Usuario registrado satisfactoriamente.',
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
                        text: 'Error al registrar el usuario.',
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



        public function actualizarUsuario($id, $datos){

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
                            text: 'Usuario actualizado satisfactoriamente.',
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
                    text: 'Error al actualizar el usuario. " . $error['message'] . "',
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
    public function eliminarUsuario($idUsuario)
    {
        $url = $this->base_url . "/" . $idUsuario;
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
                    text: 'Usuario Eliminado satisfactoriamente.',
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
            text: 'Error al eliminar el usuario " . $error['message'] . "',
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
