<?php

require_once '../config.php';
require_once('../classes/OficioCarrera.php');

$odc_fecha = '';

$id = $_GET['id'];
$base_url = "http://localhost:5170/api/oficioDireccionCarrera";
$oficioCarrera = new OficioCarrera($base_url);

$user_id = $_settings->userdata('id');
$row = $oficioCarrera->obtenerOficioCarreraPorUser($id);
$student_id = $row['users_id'];
$matricula = $oficioCarrera->obtenerMatriculaPorUser($student_id);

$estudiante = [];

if (!empty($matricula) && is_array($matricula)) {
    $primerRegistro = $matricula[0];
    $estudiante['fullname'] = trim($primerRegistro['firstname_est'] . ' ' . $primerRegistro['lastname_est']);
    $estudiante['cedula_est'] = $primerRegistro['cedula_est'];
    $estudiante['carrera'] = $primerRegistro['carrera'];
    $estudiante['ciclo'] = $primerRegistro['ciclo'];
}

// procesar el POST igual que antes...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = array(
        "id" => $_POST["id"],
        "odc_fecha" => $_POST["odc_fecha"],
        "odc_numero" => $_POST["odc_numero"],
        "odc_repre_legal" => $_POST["odc_repre_legal"],
        "odc_nom_est" => $_POST["odc_nom_est"],
        "odc_cedula_est" => $_POST["odc_cedula_est"],
        "odc_ciclo_est" => $_POST["odc_ciclo_est"],
        "odc_carrera_est" => $_POST["odc_carrera_est"],
        "odc_unidad_acade" => $_POST["odc_unidad_acade"],
        "odc_area" => $_POST["odc_area"],
        "odc_tipo_pract" => $_POST["odc_tipo_pract"],
        "odc_num_horas" => $_POST["odc_num_horas"],
        "odc_director_carrera" => $_POST["odc_director_carrera"],
        "odc_nombre_per_aut" => $_POST["odc_nombre_per_aut"],
        "odc_per_aut_cargo" => $_POST["odc_per_aut_cargo"],
        "odc_autorizacion" => $_POST["odc_autorizacion"],
        "odc_nombre_tutor" => $_POST["odc_nombre_tutor"],
        "users_id" => $_POST["users_id"]
    );

    $respuesta = $oficioCarrera->actualizarOficioCarrera($id, $datos);
}

if (isset($row['odc_fecha'])) {
    $odc_fecha = explode('T', $row['odc_fecha'])[0];
}

?>
   
   <link rel="stylesheet" href="<?php echo base_url ?>admin/oficio/css/styles.css">
   <script src="<?php echo base_url ?>admin/oficio/js/script.js" defer></script>
   <script>
    const registros = <?php echo json_encode($matricula); ?>;
   </script>
   <div class="card card-outline card-primary">
	<div class="card-header">
        <h3 class="card-title">OFICIO DIRECCIÓN DE CARRERA</h3>
        <br>
    </div>

	<div class="card-body">
		<div class="container-fluid" id="outprint">
			<div id="msg"></div>
			<form id="oficio-frm" method="post" action="">
            <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
                <fieldset class="border-bottom">
                    
						<div class="row">
							<div class="form-group col-md-2">
								<label for="odc_fecha" class="control-label">Cuenca : </label>
								<input type="date" name="odc_fecha"  autofocus  class="form-control form-control-sm rounded-0" value="<?php echo $odc_fecha ?>">
							</div>
							<div class="form-group col-md-5">
								<label for="odc_numero" class="control-label">Oficio de Secretaria de la Unidad Académica Número: </label>
								<input type="text" name="odc_numero"  autofocus  class="form-control form-control-sm rounded-0" value="<?php echo $row['odc_numero'] ?>">
							</div>
						</div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="odc_repre_legal" class="control-label">CARGO DEL REPRESENTANTE LEGAL:</label>
								<h6>Su despacho.-</h6>
                                <input type="text" name="odc_repre_legal"   class="form-control form-control-sm rounded-0" placeholder="Nombres y apellidos completos" value="<?php echo $row['odc_repre_legal'] ?>">
                            </div>

                            <div class="form-group">
                            <p class="form-group col-md-12">Con un atento saludo me dirijo a usted para solicitarle de la manera más comedida autorice a 
                            <input type="text" name="odc_nom_est" id="odc_nom_est" autofocus class="col-md-7" placeholder="NOMBRES Y APELLIDOS COMPLETOS DEL ESTUDIANTE" value="<?php echo $estudiante['fullname'] ?? '' ?>" readonly required>, con documento de identidad Nº 
                            <input type="text" name="odc_cedula_est" id="odc_cedula_est" autofocus class="" placeholder="Ingrese su cédula" value="<?php echo $estudiante['cedula_est'] ?? '' ?>" readonly required>, estudiante del 
							<input type="text" name="odc_ciclo_est" id="odc_ciclo_est" class="" placeholder="Ingrese el ciclo" value="<?= $row['odc_ciclo_est'] ?? '' ?>" required> ciclo, de la carrera de 
							<input type="text" name="odc_carrera_est" id="odc_carrera_est" class="" placeholder="Ingrese la carrera" value="<?= $row['odc_carrera_est'] ?? '' ?>" required>
							, de la Unidad Académica de <input type="text" name="odc_unidad_acade" id="odc_unidad_acade" autofocus class="" placeholder="Unidad Académica" value="<?= $row['odc_unidad_acade'] ?? '' ?>" readonly required> de la Universidad Católica de Cuenca, para que realice Nº 
									<select name="odc_num_horas" id="odc_num_horas" class="" required>
										<option value="120" <?= (isset($row['odc_num_horas']) && $row['odc_num_horas'] == '120') ? 'selected' : '' ?>>120</option>
										<option value="240" <?= (isset($row['odc_num_horas']) && $row['odc_num_horas'] == '240') ? 'selected' : '' ?>>240</option>
									</select>

                            horas correspondientes a las 
							<select name="odc_tipo_pract" id="odc_tipo_pract" class="" required onchange="cambiarDatosPractica()">
								<option value="">Seleccione tipo de práctica</option>
								<option value="Practicas Internas" <?= (isset($row['odc_tipo_pract']) && $row['odc_tipo_pract'] == 'Practicas Internas') ? 'selected' : '' ?>>PRÁCTICAS INTERNAS</option>
								<option value="Practicas Pre-Profesionales" <?= (isset($row['odc_tipo_pract']) && $row['odc_tipo_pract'] == 'Practicas Pre-Profesionales') ? 'selected' : '' ?>>PRÁCTICAS PRE-PROFESIONALES</option>
								<option value="Practicas Vinculacion con la sociedad" <?= (isset($row['odc_tipo_pract']) && $row['odc_tipo_pract'] == 'Practicas Vinculacion con la sociedad') ? 'selected' : '' ?>>PRÁCTICAS VINCULACIÓN CON LA SOCIEDAD</option>
							</select>
  
							<input type="text" name="odc_area" id="odc_area" class="col-md-3" value="<?= $row['odc_area'] ?? '' ?>" required> de su dependencia;
                            Siendo este requisito indispensable para cumplir con el Plan de Estudios de la Carrera. Pido de favor consignar su aceptación en el casillero del 
                            cuadro que se indica a continuación con firma y sello de la institución, e indicar el nombre del 
                            profesional que asignarán como tutor para el seguimiento de la práctica pre profesional por parte de 
                            su institución.</p>

                            <br><br><br>
                            <p class="form-group col-md-12">Con sentimientos de consideración y estima, suscribo.</p>
                            
                        </div>
							
                            
                        </div>

                        <hr class="custom-divider">
                        <br>
						<div class="row">
							<div class="form-group col-md-4">
								<h5>Atentamente, <br> DIOS, PATRIA, CULTURA Y DESARROLLO</h5>
								<br>
                        	</div>
							
							<div class="form-group col-md-4">
								<label for="odc_director_carrera" class="control-label">DIRECTOR DE CARRERA:</label>
								<input type="text" name="odc_director_carrera" id="odc_director_carrera" value="<?php echo $row['odc_director_carrera'] ?>" class="form-control form-control-sm rounded-0" placeholder="Nombres y apellidos completos"readonly required>
								
							</div>
							<div class="form-group col-md-4">
							<label for="odc_unidad_acade" class="control-label">UNIDAD ACADÉMICA DE:</label>
								<input type="text" name="odc_unidad_acade" id="odc_unidad_acade" value="<?php echo $row['odc_unidad_acade'] ?>" class="form-control form-control-sm rounded-0" placeholder="Ingrese la unidad academica" readonly required>
							</div>
						</div>
						<br>
						

                       
                            

                        

                        <div class="row">
						<table>
							<tr>
								<th colspan="2">NOMBRE Y CARGO DE LA PERSONA QUE AUTORIZA</th>
								<th>AUTORIZACIÓN</th>
								<!-- <th>FIRMA Y SELLO DE LA INSTITUCIÓN</th> -->
							</tr>
							<tr>
								<td colspan="2"></td>
								<td>
									<div class="form-group col-md-4">
										<select name="odc_autorizacion" id="odc_autorizacion" class="form-control form-control-sm rounded-0 select2">
											<option value="Si" <?php if ($row['odc_autorizacion'] == 'Si') echo 'selected'; ?>>Si</option>
											<option value="No" <?php if ($row['odc_autorizacion'] == 'No') echo 'selected'; ?>>No</option>
										</select>
									</div>
								</td>

								
							</tr>
							<tr>
								<td><label for="odc_nombre_per_aut" class="control-label">Nombre:</label></td>
								<td><input type="text" name="odc_nombre_per_aut" class="form-control form-control-sm rounded-0" value="<?php echo $row['odc_nombre_per_aut'] ?>"></td></td>
								<td colspan="2" rowspan="2">f. </td>
							</tr>
							<tr>
								<td><label for="odc_per_aut_cargo" class="control-label">Cargo:</label></td>
								<td><input type="text" name="odc_per_aut_cargo" class="form-control form-control-sm rounded-0" value="<?php echo $row['odc_per_aut_cargo'] ?>"></td>
							</tr>
							<tr>
								<td colspan="4"><label for="odc_nombre_tutor" class="control-label">Nombre del tutor que asigna la institución: </label>
								<input type="text" name="odc_nombre_tutor"  class="form-control form-control-sm rounded-0" value="<?php echo $row['odc_nombre_tutor'] ?>">
							</tr>
						</table>
						<input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                           
                        </div>
                        
                        
                        </fieldset>
						<br><br>
						<div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Oficio</button>
                            <a href="./?page=oficio" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
        
                    
                </form>
		</div>
	</div>
   </div>

