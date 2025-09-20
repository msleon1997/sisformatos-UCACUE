<?php
if (!defined('DB_SERVER')) {
    require_once("../initialize.php");
}

class DBConnection {
    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;    // private $password = "Sistem.Digiucacue.2024";
    private $database = DB_NAME;
    public $conn;

    public function __construct() {
        if (!isset($this->conn)) {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                die('No se pudo conectar con la base de datos: ' . $this->conn->connect_error);
            }
        }
    }

    public function __destruct() {
        if (isset($this->conn)) {
            $this->conn->close();
        }
    }
}
?>
