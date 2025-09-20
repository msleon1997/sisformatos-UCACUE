<?php
require_once('../config.php');
Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	

	public function save_users(){
		if (!isset($_POST['status']) && $this->settings->userdata('login_type') == 1) {
			$_POST['status'] = 1;
		}
		extract($_POST);
		$oid = $id;
		$data = '';
	
		// Verificar si se ingresó una nueva contraseña
		if (!empty($password)) {
			// Hashear la nueva contraseña
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		}
	
		// Verificar si el nombre de usuario ya existe, excepto para el usuario actual
		$chk = $this->conn->query("SELECT * FROM `users` where username ='{$username}' ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if ($chk > 0) {
			return 3;
			exit;
		}
	
		// Construir la consulta para actualizar los datos del usuario
		foreach ($_POST as $k => $v) {
			if (in_array($k, array('cedula', 'firstname', 'middlename', 'lastname', 'username', 'type'))) {
				if (!empty($data)) $data .= " , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
	
		// Solo actualizar la contraseña si se ingresó una nueva
		if (!empty($password)) {
			if (!empty($data)) $data .= " , ";
			$data .= " `password` = '{$hashed_password}' ";
		}
	
		if (empty($id)) {
			// Insertar un nuevo usuario
			$qry = $this->conn->query("INSERT INTO users set {$data}");
			if ($qry) {
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success', 'User Details successfully saved.');
				$resp['status'] = 1;
			} else {
				$resp['status'] = 2;
			}
	
		} else {
			// Actualizar un usuario existente
			$qry = $this->conn->query("UPDATE users set $data where id = {$id}");
			if ($qry) {
				$this->settings->set_flashdata('success', 'User Details successfully updated.');
				if ($id == $this->settings->userdata('id')) {
					foreach ($_POST as $k => $v) {
						if ($k != 'id') {
							$this->settings->set_userdata($k, $v);
						}
					}
				}
				$resp['status'] = 1;
			} else {
				$resp['status'] = 2;
			}
		}
	
		// Manejo del avatar
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/avatar-' . $id . '.png';
			$dir_path = base_app . $fname;
			$upload = $_FILES['img']['tmp_name'];
			$type = mime_content_type($upload);
			$allowed = array('image/png', 'image/jpeg');
			if (!in_array($type, $allowed)) {
				$resp['msg'] .= " But Image failed to upload due to invalid file type.";
			} else {
				// Procesar imagen y cambiar tamaño
				$new_height = 200;
				$new_width = 200;
	
				list($width, $height) = getimagesize($upload);
				$t_image = imagecreatetruecolor($new_width, $new_height);
				imagealphablending($t_image, false);
				imagesavealpha($t_image, true);
				$gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
				imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				if ($gdImg) {
					if (is_file($dir_path)) unlink($dir_path);
					$uploaded_img = imagepng($t_image, $dir_path);
					imagedestroy($gdImg);
					imagedestroy($t_image);
				} else {
					$resp['msg'] .= " But Image failed to upload due to unknown reason.";
				}
			}
			if (isset($uploaded_img)) {
				$this->conn->query("UPDATE users set `avatar` = CONCAT('{$fname}', '?v=', unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}' ");
				if ($id == $this->settings->userdata('id')) {
					$this->settings->set_userdata('avatar', $fname);
				}
			}
		}
	
		if (isset($resp['msg']))
			$this->settings->set_flashdata('success', $resp['msg']);
		return $resp['status'];
	}
	



	
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	case 'delete':
	//	echo $users->delete_users();
	break;
	case 'save_employee':
	//	echo $users->save_employee();
	break;
	case 'delete_employee':
	//	echo $users->delete_employee();
	break;
	default:
		// echo $sysset->index();
		break;
}