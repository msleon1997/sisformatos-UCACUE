<?php
    require_once '../config.php';
    require_once('../classes/OficioCarrera.php');

    $user = $conn->query("SELECT * FROM users where id ='" . $_settings->userdata('id') . "'");
    foreach ($user->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }

    $base_url = "http://localhost:5170/api/oficioDireccionCarrera"; 
    $oficioCarrera = new OficioCarrera($base_url);

    // Obtener registros de la base de datos
    $user_id = $_settings->userdata('id');
    $i = 1;

   $matricula = $oficioCarrera->obtenerMatriculaPorUser($user_id);
   $estudiante = [];  
   
    $stmt = $conn->prepare("SELECT DISTINCT area FROM area_docente WHERE users_id = ?");

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $practicas = [];
    while ($row = $result->fetch_assoc()) {
        $practicas[] = $row['area'];
    }
    $stmt->close();


if (!empty($matricula) && is_array($matricula)) {
    $primerRegistro = $matricula[0];

    $estudiante['fullname'] = trim($primerRegistro['firstname_est'] . ' ' . $primerRegistro['lastname_est']);
    $estudiante['cedula_est'] = $primerRegistro['cedula_est'];
    $estudiante['carrera'] = $primerRegistro['carrera'];
    $estudiante['ciclo'] = $primerRegistro['ciclo'];
}

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $datos = array(
            "odc_fecha" => $_POST["odc_fecha"] ?? '',
            "odc_numero" => $_POST["odc_numero"] ?? '',
            "odc_repre_legal" => $_POST["odc_repre_legal"] ?? '',
            "odc_nom_est" => $_POST["odc_nom_est"] ?? '',
            "odc_cedula_est" => $_POST["odc_cedula_est"] ?? '',
            "odc_ciclo_est" => $_POST["odc_ciclo_est"] ?? '',
            "odc_carrera_est" => $_POST["odc_carrera_est"] ?? '',
            "odc_unidad_acade" => $_POST["odc_unidad_acade"] ?? '',
            "odc_area" => $_POST["odc_area"] ?? '',
            "odc_tipo_pract" => $_POST["odc_tipo_pract"] ?? '',
            "odc_num_horas" => $_POST["odc_num_horas"] ?? '',
            "odc_director_carrera" => $_POST["odc_director_carrera"] ?? '',
            "odc_nombre_per_aut" => $_POST["odc_nombre_per_aut"] ?? '',
            "odc_per_aut_cargo" => $_POST["odc_per_aut_cargo"] ?? '',
            "odc_autorizacion" => $_POST["odc_autorizacion"] ?? '',
            "odc_nombre_tutor" => $_POST["odc_nombre_tutor"] ?? '',
            "users_id" => $_POST["users_id"]
        );

        $respuesta = $oficioCarrera->crearOficioCarrera($datos);
        //var_dump($datos);
    }
    
?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/oficio/css/styles.css">
<script src="<?php echo base_url ?>admin/oficio/js/script.js" defer></script>
<script>
    const registros = <?php echo json_encode($matricula); ?>;
</script>
<script src="js/matricula-handler.js"></script>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">OFICIO DIRECCIÓN DE CARRERA</h3>
        <br>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <?php if ($_settings->userdata('type') == 1): // Usuario tipo 1 (Estudiante) ?>
            <form id="oficio-frm" method="post" action="">
                <fieldset class="border-bottom">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="odc_fecha" class="control-label">Cuenca : </label>
                            <input type="date" name="odc_fecha" id="odc_fecha" autofocus class="form-control form-control-sm rounded-0" required>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="odc_numero" class="control-label">Oficio de Secretaria de la Unidad Académica Número: </label>
                            <input type="text" name="odc_numero" id="odc_numero" value="Oficio Nro.21  UAICCIT-SOF-2025-19-OF" class="form-control form-control-sm rounded-0" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="odc_repre_legal" class="control-label">CARGO DEL REPRESENTANTE LEGAL:</label>
                            <h6>Su despacho.-</h6>
                            <input type="text" name="odc_repre_legal" id="odc_repre_legal" class="form-control form-control-sm rounded-0" placeholder="Nombres y apellidos completos del representante de la empresa" required>
                        </div>

                        <div class="form-group">
                            <p class="form-group col-md-12">Con un atento saludo me dirijo a usted para solicitarle de la manera más comedida autorice a 
                            <input type="text" name="odc_nom_est" id="odc_nom_est" autofocus class="col-md-7" placeholder="NOMBRES Y APELLIDOS COMPLETOS DEL ESTUDIANTE" value="<?php echo $estudiante['fullname'] ?? '' ?>" readonly required>, con documento de identidad Nº 
                            <input type="text" name="odc_cedula_est" id="odc_cedula_est" autofocus class="" placeholder="Ingrese su cédula" value="<?php echo $estudiante['cedula_est'] ?? '' ?>" readonly required>, estudiante del 
							<input type="text" name="odc_ciclo_est" id="odc_ciclo_est" autofocus class="" placeholder="Ingrese el ciclo"  value="<?php echo $estudiante['ciclo'] ?? '' ?>" required> ciclo, de la carrera de <input type="text" name="odc_carrera_est" id="odc_carrera_est" autofocus class="" placeholder="Ingrese la carrera" value="<?php echo $estudiante['carrera'] ?? '' ?>" required>
							, de la Unidad Académica de <input type="text" name="odc_unidad_acade" id="odc_unidad_acade" autofocus class="" placeholder="Unidad Académica" value="<?php echo $estudiante['carrera'] ?? '' ?>" readonly required> de la Universidad Católica de Cuenca, para que realice Nº 
                                    <select name="odc_num_horas" id="odc_num_horas"
                                        class="" required>
                                        <option value="120">120</option>
                                        <option value="240">240</option>
                                    </select>
                            horas correspondientes a las <select name="odc_tipo_pract" id="odc_tipo_pract" class="" required onchange="cambiarDatosPractica()">
                                <option value="">Seleccione tipo de práctica</option>
                                <option value="Practicas Internas">PRÁCTICAS INTERNAS</option>
                                <option value="Practicas Pre-Profesionales">PRÁCTICAS PRE-PROFESIONALES</option>
                                <option value="Practicas Vinculacion con la sociedad">PRÁCTICAS VINCULACIÓN CON LA SOCIEDAD</option>
                            </select> 
                            en el área  
                            <input type="text" name="odc_area" id="odc_area" class="col-md-3" placeholder="Ingrese el area que esta trabajando" value="<?= $row['odc_area'] ?? '' ?>" required> de su dependencia;
                            Siendo este requisito indispensable para cumplir con el Plan de Estudios de la Carrera. Pido de favor consignar su aceptación en el casillero del 
                            cuadro que se indica a continuación con firma y sello de la institución, e indicar el nombre del 
                            profesional que asignarán como tutor para el seguimiento de las prácticas por parte de 
                            su institución.</p>

                            <br><br><br>
                            <p class="form-group col-md-12">Con sentimientos de consideración y estima, suscribo.</p>
                            
                        </div>
                        
                    </div>
                        <hr class="custom-divider">
                        <br>
						<div class="row">
							<div class="form-group col-md-12" style="text-align: center;">
								<h6>Atentamente,</h6>
                                    <br> 
                                    <h5>DIOS, PATRIA, CULTURA Y DESARROLLO</h5>
								<br>
                        	</div>
							<br><br><br>
							<div class="form-group col-md-12" style="text-align: center;">
								<label for="odc_director_carrera" class="control-label">DIRECTOR DE CARRERA:</label>
								<input style="text-align: center;" type="text" name="odc_director_carrera" id="odc_director_carrera" value="Ing. Jaime Rodrigo Segarra Escandón, (PHD)" class="form-control form-control-sm rounded-0" placeholder="Nombres y apellidos completos"readonly required>
								<p>DIRECTOR DE CARRERA</p>
							<label for="odc_unidad_acade" class="control-label">UNIDAD ACADÉMICA DE:</label>
								<input style="text-align: center;" type="text" name="odc_unidad_acade" id="odc_unidad_acade" value="SOFTWARE" class="form-control form-control-sm rounded-0" placeholder="Ingrese la unidad academica" readonly required>
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
								<td><div class="form-group col-md-4">
										<label for="odc_autorizacion" class="control-label"></label>
										<select name="odc_autorizacion" id="odc_autorizacion" class="form-control form-control-sm rounded-0 select2" required>
											<option value="Si">Si</option>
											<option value="No">No</option>
										</select>
								    </div>
								</td>
								
							</tr>
							<tr>
								<td><label for="odc_nombre_per_aut" class="control-label">Nombre:</label></td>
								<td><input type="text" name="odc_nombre_per_aut" id="odc_nombre_per_aut" class="form-control form-control-sm rounded-0" required></td></td>
								<td colspan="2" rowspan="2">f. </td>
							</tr>
							<tr>
								<td><label for="odc_per_aut_cargo" class="control-label">Cargo:</label></td>
								<td><input type="text" name="odc_per_aut_cargo" id="odc_per_aut_cargo" class="form-control form-control-sm rounded-0" required></td>
							</tr>
							<tr>
								<td colspan="4"><label for="odc_nombre_tutor" class="control-label">Nombre del tutor que asigna la institución: </label>
								<input type="text" name="odc_nombre_tutor" id="odc_nombre_tutor" class="form-control form-control-sm rounded-0" required>
							</tr>
						</table>
						<input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                           
                        </div>
                        </fieldset>

                    <div class="card-footer text-right">
                        <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Oficio</button>
                        <a href="./?page=oficio" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                    </div>
                    
                </form>
				<?php endif; ?>
				<?php if ($_settings->userdata('type') == 2): ?>

				<!-- Campo de búsqueda -->
				<div class="search-box mb-3">
					<label for="searchInput">BUSCAR REGISTRO</label>
					<input type="text" id="searchInput" class="form-control" placeholder="Buscar por cédula, nombre del estudiante, carrera, etc...">
				</div>
				<?php endif; ?>
                <!-- filtrar por tipo de practica -->
                <div class="search-box mb-3">
                    <label for="practicaSelect">Filtrar por tipo de práctica:</label>
                    <select id="practicaSelect" class="form-control">
                        <option value="">Todas las prácticas</option>
                        <?php foreach ($practicas as $practica): ?>
                            <option value="<?php echo $practica; ?>"><?php echo $practica; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

		</div>
	</div>


	<div class="tabla-scrollable">
                <table class="table table-bordered table-hover table-striped">
                    
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th class="col-2">Nombres del estudiante</th>
                            <th class="col-2">Cédula</th>
                            <th class="col-2">Ciclo</th>
                            <th class="col-2">Carrera</th>
                            <th class="col-2">Unidad Académica</th>
                            <th class="col-2"># de Horas de Práctica Laborales</th>
                            <th class="col-5">Tipo de Práctica</th>
                            <th class="col-2">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/OficioDireccionCarrera/detailsByUser";
						$base_urlDoc = "http://localhost:5170/api/OficioDireccionCarrera";
						$user_type = $_settings->userdata('type');
                        $oficioCarrera = new OficioCarrera($base_url);
						$oficioCarreraDoc = new OficioCarrera($base_urlDoc);

						// Obtener el ID del usuario actualmente logueado
						$user_id = $_settings->userdata('id');
						if ($user_type == 1) {
							 // Consultar los registros de la tabla planificacion que corresponden al usuario actual
							 $qry = $oficioCarrera->obtenerOficioCarreraPorUser($user_id);

					   } else if ($user_type == 2) {
							 // Consultar los registros de la tabla planificacion que corresponden al usuario actual
							$qry = $oficioCarreraDoc->obtenerOficioCarrera();

					   }


                        
                         foreach ($qry as $row) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class="">
                                        <p class=""><?php echo $row['odc_nom_est'] ?></p>
                                    </td>
                                    <td class="">
                                        <p class=""><?php echo $row['odc_cedula_est'] ?></p>
                                    </td>
                                    <td class="">
                                        <p class=""><?php echo $row['odc_ciclo_est'] ?></p>
                                    </td>
                                    <td class="">
                                        <p class=""><?php echo $row['odc_carrera_est'] ?></p>
                                    </td>
                                    <td class="">
                                        <p class=""><?php echo $row['odc_unidad_acade'] ?></p>
                                    </td>
                                    <td class="">
                                        <p class=""><?php echo $row['odc_num_horas'] ?> Horas</p>
                                    </td>
                                    <td class="">
                                        <p class=""><?php echo $row['odc_tipo_pract'] ?></p>
                                    </td>
        
                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="./?page=oficio/view_oficio&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                            <?php if ($_settings->userdata('type') == 1) : ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item edit_data" href="./?page=oficio/manage_oficio&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_data" href="./?page=oficio/delete_oficio&id=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                    
                    </tbody>
                </table>
            </div>

	</div>

    <script>
     document.getElementById('practicaSelect').addEventListener('change', filtrarTabla);

    function filtrarTabla() {
        var practicaSeleccionada = document.getElementById('practicaSelect').value.toLowerCase().trim();
        var rows = document.querySelectorAll('table tbody tr');

        rows.forEach(function (row) {
            var nombrePractica = row.querySelector('td:nth-child(8) p').innerText.toLowerCase().trim();

            if (practicaSeleccionada === '') {
                row.style.display = '';
            } else if (nombrePractica === practicaSeleccionada) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

     //busqueda avanzada
    document.getElementById('searchInput').addEventListener('keyup', function () {
        var searchTerm = this.value.toLowerCase();
        var rows = document.querySelectorAll('.table tbody tr');

        rows.forEach(function (row) {
            var rowText = row.textContent.toLowerCase();
            if (rowText.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>