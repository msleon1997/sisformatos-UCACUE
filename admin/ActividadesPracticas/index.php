
<?php
require_once '../config.php';
require_once('../classes/InformeActividadesPracticas.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}



$user_id = $_settings->userdata('id');
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$meta = $result->fetch_assoc();
$base_url = "http://localhost:5170/api/InformeActividadesPracticas"; 
$infoactpract = new InformeActividadesPracticas($base_url);

// Obtener registros de la base de datos
$user_id = $_settings->userdata('id_practica');
$i = 1;

   
    $fecha = [];
// Verificar si se ha enviado el formulario de creación de planificación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = array_map('trim', $_POST['Fecha']);

    // Obtener datos del formulario
    $datos = array(
        $empresa = htmlspecialchars(trim($_POST["empresa_institucion"])),
        "direccion_empresa" => $_POST["direccion_empresa"] ?? '',
        "telefono_empresa" => $_POST["telefono_empresa"] ?? '',
        "email_empresa" => $_POST["email_empresa"] ?? '',
		"area_departamento_proyecto" => $_POST["area_departamento_proyecto"] ?? '',
		"asignatura_catedra" => $_POST["asignatura_catedra"] ?? '',
		"tutor_externo" => $_POST["tutor_externo"] ?? '',
		"cargo_tutor" => $_POST["cargo_tutor"] ?? '',
		"convenio" => $_POST["convenio"] ?? '',
		"fecha_firma_convenio" => $_POST["fecha_firma_convenio"] ?? '',
        "fecha_termino_convenio" => $_POST["fecha_termino_convenio"] ?? '',
        "estudiante" => implode(", ", $_POST['estudiante']),
        "cedula_estudiante" => implode(", ", $_POST['cedula_estudiante']) ?? '',
        "celular_estudiante" => implode(", ", $_POST['celular_estudiante']) ?? '',
        "email_estudiante" => implode(", ", $_POST['email_estudiante']) ?? '',
        "docente" => $_POST["docente"] ?? '',
        "cedula_docente" => $_POST["cedula_docente"] ?? '',
        "email_docente" => $_POST["email_docente"] ?? '',
        "fecha_inicio_practica" => $_POST["fecha_inicio_practica"] ?? '',
        "fecha_fin_practica" => $_POST["fecha_fin_practica"] ?? '',

        "actividad_cronograma" => isset($_POST["actividad_cronograma"]) ? implode("| ", $_POST["actividad_cronograma"]): '',
        "tarea_cronograma" => isset($_POST["tarea_cronograma"]) ? implode("| ", $_POST["tarea_cronograma"]): '',
        "primera_semana" => $_POST["primera_semana"] ?? '',
        "primera_semana_lunes" => isset($_POST["primera_semana_lunes"]) ? implode(", ", $_POST["primera_semana_lunes"]): '',
        "primera_semana_martes" => isset($_POST["primera_semana_martes"]) ? implode(", ", $_POST["primera_semana_martes"]): '',
        "primera_semana_miercoles" => isset($_POST["primera_semana_miercoles"]) ? implode(", ", $_POST["primera_semana_miercoles"]): '',
        "primera_semana_jueves" => isset($_POST["primera_semana_jueves"]) ? implode(", ", $_POST["primera_semana_jueves"]): '',
        "segunda_semana" => $_POST["segunda_semana"] ?? '',
        "segunda_semana_lunes" => isset($_POST["segunda_semana_lunes"]) ? implode(", ", $_POST["segunda_semana_lunes"]): '',
        "segunda_semana_martes" => isset($_POST["segunda_semana_martes"]) ? implode(", ", $_POST["segunda_semana_martes"]): '',
        "segunda_semana_miercoles" => isset($_POST["segunda_semana_miercoles"]) ? implode(", ", $_POST["segunda_semana_miercoles"]): '',
        "segunda_semana_jueves" => isset($_POST["segunda_semana_jueves"]) ? implode(", ", $_POST["segunda_semana_jueves"]): '',
        "tercera_semana" => $_POST["tercera_semana"] ?? '',
        "tercera_semana_lunes" => isset($_POST["tercera_semana_lunes"]) ? implode("|,", $_POST["tercera_semana_lunes"]): '',
        "tercera_semana_martes" => isset($_POST["tercera_semana_martes"]) ? implode(", ", $_POST["tercera_semana_martes"]): '',
        "tercera_semana_miercoles" => isset($_POST["tercera_semana_miercoles"]) ? implode(", ", $_POST["tercera_semana_miercoles"]): '',
        "tercera_semana_jueves" => isset($_POST["tercera_semana_jueves"]) ? implode(", ", $_POST["tercera_semana_jueves"]): '',
        "cuarta_semana" => $_POST["cuarta_semana"] ?? '',
        "cuarta_semana_lunes" => isset($_POST["cuarta_semana_lunes"]) ? implode(", ", $_POST["cuarta_semana_lunes"]): '',
        "cuarta_semana_martes" => isset($_POST["cuarta_semana_martes"]) ? implode(", ", $_POST["cuarta_semana_martes"]): '',
        "cuarta_semana_miercoles" => isset($_POST["cuarta_semana_miercoles"]) ? implode(", ", $_POST["cuarta_semana_miercoles"]): '',
        "cuarta_semana_jueves" => isset($_POST["cuarta_semana_jueves"]) ? implode(", ", $_POST["cuarta_semana_jueves"]): '',

        "proyecto_empresa" => $_POST["proyecto_empresa"] ?? '',
        "docente_tutor" => $_POST["docente_tutor"] ?? '',
        "tutor_externo_horas" => $_POST["tutor_externo_horas"] ?? '',
        "estudiante_horas" => $_POST["estudiante_horas"] ?? '',
        "fecha_horas" =>  implode(", ",$fecha),
        "hora_entrada" => implode(", ", $_POST["hora_entrada"]  ?? ''),
        "hora_salida" => implode(", ", $_POST["hora_salida"]  ?? ''),
        "actividades_realizadas" => implode(", ", $_POST["actividades_realizadas"]  ?? ''),
		"usuario_id" => $_POST["usuario_id"]
    );

   

   
}
?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/js/script.js" defer></script>
<div class="card card-outline card-primary rounded-0 shadow">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="card-header">
        <h3 class="card-title">PLANIFICACIÓN DE ACTIVIDADES DE LA PRÁCTICA PRE PROFESIONAL DE LOS ESTUDIANTES</h3>
        <br>
        <h5 class="card-title"> 1.	DATOS INFORMATIVOS DEL ORGANISMO, EMPRESA, INSTITUCIÓN DE CONTRAPARTE O PROYECTO</h5>
    </div>
   
    <div class="card-body">

        <?php if ($_settings->userdata('type') == 2): ?>

        <!-- Campo de búsqueda -->
        <div class="search-box mb-3">
            <label for="searchInput">BUSCAR REGISTRO</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por Nombre del estudiante">
        </div>
        <?php endif; ?>
</div>

            <div class="tabla-scrollable">
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="25%">
                        <col width="25%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th class="col-1">Empresa o Institución</th>

                           
                            <th class="col-5">Área/Departamento y/o Proyecto</th>
                            <th class="col-6">Asignaturas y/o Cátedra Integradora</th>
                            <th class="col-8">Tutor/a Externo</th>
                            <th class="col-9">Cargo</th>
            
                            <th class="col-15">Nombres del estudiante</th>
                            <th class="col-15">Nº de cédula</th>
                            
                            <th class="col-15">Nombres del docente </th>
                            
                            <th class="col-15">Fecha de inicio práctica</th>
                            <th class="col-15">Fecha de finalización de práctica</th>
                            <th class="col-15">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/InformeActividadesPracticas/detailsByUser"; 
                        $base_urlDoc = "http://localhost:5170/api/InformeActividadesPracticas"; 
                        $infoactpract = new InformeActividadesPracticas($base_url);
                        $infoactpractDoc = new InformeActividadesPracticas($base_urlDoc);
                        $user_type = $_settings->userdata('type');
                        // Obtener el ID del usuario actualmente logueado

                         $user_id = $_settings->userdata('id');
                         if ($user_type == 1) {
                            $qry = $infoactpract->obtenerInformeActividadesPracticasPorUser($user_id);
                        } else if ($user_type == 2) {
                            $qry = $infoactpractDoc->obtenerInformeActividadesPracticas();
                        }
                        
                        
                        
                         foreach ($qry as $row) {
                            ?>
                                <tr>
                                  <td class="text-center"><?php echo $i++; ?></td>
                                  <td class="">
                                        <p class=""><?php echo htmlspecialchars($row['empresa_institucion']) ?></p>
                                    </td>
                                    
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars( $row['area_departamento_proyecto'] )?></p>
                                    </td>
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['asignatura_catedra'] )?></p>
                                    </td>
                                  
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['tutor_externo']) ?></p>
                                    </td>
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['cargo_tutor'] )?></p>
                                    </td>
                    
                                    <td class="">
                                        <p class="">
                                            <?php 
                                            $nombres = explode(',', htmlspecialchars ($row['estudiante']));
                                            echo isset($nombres[0]) ? htmlspecialchars($nombres[0]) : 'N/A'; 
                                            ?>
                                        </p>
                                    </td>
                                    <td class="">
                                        <p class="">
                                            <?php 
                                            // Obtener la primera cédula
                                            $cedulas = explode(',', htmlspecialchars ($row['cedula_estudiante']));
                                            echo isset($cedulas[0]) ? htmlspecialchars($cedulas[0]) : 'N/A';
                                            ?>
                                        </p>
                                    </td>

                                  
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['docente'])?></p>
                                    </td>
                                 
                                 <td class="">
                                     <p class=""><?php echo htmlspecialchars ($row['fecha_inicio_practica'])?></p>
                                    </td>
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['fecha_fin_practica'])?></p>
                                    </td>

                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="./?page=ActividadesPracticas/view_informe_actividades_practicas&id=<?php echo $row['id_practica'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>                                            
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
