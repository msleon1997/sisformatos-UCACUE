<?php


require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Acceso Denegado</h1> <a href='".base_url."'>Volver Atrás.</a>";
	}

	public function login(){
		$cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($cedula) || empty($password)) {
        return json_encode(['status'=>'error','msg'=>'Campos requeridos']);
    }

    try {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE cedula = ?");
        $stmt->bind_param('s', $cedula);
        $stmt->execute();
        $qry = $stmt->get_result();

        if($qry->num_rows > 0){
            $res = $qry->fetch_assoc();
            if($res['status'] == 0){
                return json_encode(['status'=>'inactive','msg'=>'Usuario no activo']);
            }

            if(password_verify($password, $res['password'])){
                session_regenerate_id(true);
                foreach($res as $k => $v){
                    if(!is_numeric($k) && $k != 'password'){
                        $this->settings->set_userdata($k, $v);
                    }
                }
                $this->settings->set_userdata('login_type',1);
                return json_encode(['status'=>'success']);
            } else {
                return json_encode(['status'=>'incorrect']);
            }
        } else {
            return json_encode(['status'=>'incorrect']);
        }
    } catch(Exception $e){
        error_log("Login error: ".$e->getMessage());
        return json_encode(['status'=>'error','msg'=>'Error de sistema']);
    }
}

	
	


	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}



}



$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	default:
		echo $auth->index();
		break;
}



?>