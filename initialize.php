<?php
// Datos de desarrollo
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Marlon',
    'lastname' => 'Leon',
    'username' => 'mslb',
    'password' => '4b67deeb9aba04a5b54632ad19934f26',
    'last_login' => null
);

// Definición de constantes  http://172.16.106.17/
if (!defined('base_url')) define('base_url', 'http://localhost/sistemadigitalizacion/');
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');
if (!defined('DEV_DATA')) define('DEV_DATA', $dev_data);

// Configuración de la base de datos   172.16.106.17
if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
if (!defined('DB_USERNAME')) define('DB_USERNAME', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
//if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
if (!defined('DB_NAME')) define('DB_NAME', 'sisformatosucacue');



    
   
    

// Función para conectar a la base de datos
function connectToDatabase() {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
