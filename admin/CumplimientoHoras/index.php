<?php
require_once '../config.php';
require_once('../classes/CumplimientoHoras.php');


$base_url = "http://localhost:5170/api/CumplimientoHoras"; 
$cumplimientoHoras = new CumplimientoHoras($base_url);



$user_id = $_settings->userdata('id');
    $i = 1;
$obtenerPlanificacion = $cumplimientoHoras->obtenerPlanificaciones($user_id);
$estudiante = $obtenerPlanificacion;
$primerEstudiante = $estudiante[0] ?? null;



$stmt = $conn->prepare("SELECT DISTINCT area FROM area_docente WHERE users_id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$practicas = [];
while ($row = $result->fetch_assoc()) {
    $practicas[] = $row['area'];
}
$stmt->close();


 $fecha = [];

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = array_map('trim', $_POST['Fecha']);

    $datos = array(
        "Tipo_area" => $_POST["Tipo_area"] ?? '',
        "Empresa_institucion_proyecto" => $_POST["Empresa_institucion_proyecto"] ?? '',
        "Docente_tutor" => $_POST["Docente_tutor"] ?? '',
        "Tutor_Externo" => $_POST["Tutor_Externo"] ?? '',
        "Estudiante" => $_POST["Estudiante"] ?? '',
        "Fecha" => implode(", ", $fecha), 
        "Hora_Entrada" => implode(", ", $_POST["Hora_Entrada"] ?? ''),
        "Hora_Salida" => implode(", ", $_POST["Hora_Salida"]  ?? ''),
        "Actividades_Realizadas" => implode(", ", $_POST["Actividades_Realizadas"] ?? ''),
        "users_id" => $_POST["users_id"]
    );

    $respuesta = $cumplimientoHoras->crearCumplimeintoHoras($datos);

    //var_dump($datos);
}

?>



<link rel="stylesheet" href="<?php echo base_url ?>admin/CumplimientoHoras/css/styles.css">
<script src="<?php echo base_url ?>admin/CumplimientoHoras/js/script.js" defer></script>
<script>
    const planificacionPorArea = <?= json_encode($cumplimientoHoras->obtenerPlanificaciones($user_id)) ?>;
</script>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">REGISTRO DE HORAS DE PRÁCTICA PRE PROFESIONAL Y/O DE SERVICIO COMUNITARIO</h3>
    </div>
    <div class="card-body">

        <div class="container-fluid">
        <?php if ($_settings->userdata('type') == 1): // Usuario tipo 1 (Estudiante) ?>
            <form id="cumplimiento-horas-frm" method="post" action="">
                <div class="row">
                    <div class="form-group col-md-4">
                                    <label for="Tipo_area" class="control-label">Area:</label>
                                    <select name="Tipo_area" id="Tipo_area" class="form-control form-control-sm rounded-0 select2" required onchange="actualizarCampos()">
                                        <option value="">Seleccione un área</option>
                                            <?php
                                                $areasUnicas = [];
                                                foreach ($obtenerPlanificacion as $p) {
                                                    if (!in_array($p['tP_Area'], $areasUnicas)) {
                                                        $areasUnicas[] = $p['tP_Area'];
                                                        $selected = (isset($row['tP_Area']) && $row['tP_Area'] === $p['tP_Area']) ? 'selected' : '';
                                                        echo "<option value=\"{$p['tP_Area']}\" $selected>{$p['tP_Area']}</option>";
                                                    }
                                                }
                                            ?>
                                    </select>
                                </div>
                    <div class="form-group col-md-4">
                        <label for="Empresa_institucion_proyecto" class="control-label">Empresa/Institución de Contraparte y/o Proyecto:</label>
                        <input type="text" name="Empresa_institucion_proyecto" id="Empresa_institucion_proyecto" value="<?php echo $obtenerPlanificacion['tP_Inst_Emp'] ?? '' ?>"  class="form-control form-control-sm rounded-0" placeholder="Nombre de la empresa, institucio o proyecto" required>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="Tutor_Externo" class="control-label">Tutor Externo:</label>
                        <input type="text" name="Tutor_Externo" id="Tutor_Externo" value="<?php echo $obtenerPlanificacion['tP_Docente_tutor'] ?? '' ?>" class="form-control form-control-sm rounded-0" placeholder="Nombres y apellidos completos">
                    </div>
                </div>
                <div class="row">
                    
                    <div class="form-group col-md-4" id="grupoDocenteTutor">
                        <label for="Docente_tutor" class="control-label">Docente-Tutor:</label>
                        <input type="text" name="Docente_tutor" id="Docente_tutor" value="<?php echo $obtenerPlanificacion['tP_Docente_tutor'] ?? '' ?>" class="form-control form-control-sm rounded-0" placeholder="Nombres del docente tutor" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Estudiante" class="control-label">Estudiante:</label>
                        <input type="text" name="Estudiante" id="Estudiante" class="form-control form-control-sm rounded-0" placeholder="Nombres y apellidos completos del estudiante" value="<?php echo $primerEstudiante['estudianteLider'] ?? ''; ?>" readonly required>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered" id="activity-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                                <th>Actividades realizadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="date" name="Fecha[]" class="form-control form-control-sm rounded-0" required></td>
                                <td><input type="time" name="Hora_Entrada[]" class="form-control form-control-sm rounded-0" required></td>
                                <td><input type="time" name="Hora_Salida[]" class="form-control form-control-sm rounded-0" required></td>
                                <td><input type="text" name="Actividades_Realizadas[]" class="form-control form-control-sm rounded-0" required></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                 </div>
                <div class="text-right">
                    <button type="button" class="btn btn-success btn-sm" id="add-row-btn">Agregar Registro</button>
                    <button type="button" class="btn btn-danger btn-sm" id="remove-row-btn">Eliminar Registro</button>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Actividades</button>
                    <a href="./?page=CumplimientoHoras" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                </div>
            </form>
            <?php endif; ?>
                <div>
                    <?php if ($_settings->userdata('type') == 2): ?>
                    <div class="card-header">
                        <label>Buscar por estudiante</label>
                            <!-- Campo de búsqueda -->
                            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por estudiante, docente o tipo de proyecto, etc.">
                    </div>
                     <!-- filtrar por tipo de practica -->
                    <div class="card-header">
                        <label for="practicaSelect">Filtrar por tipo de práctica:</label>
                        <select id="practicaSelect" class="form-control">
                            <option value="">Todas las prácticas</option>
                            <?php foreach ($practicas as $practica): ?>
                                <option value="<?php echo $practica; ?>"><?php echo $practica; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
<div class="card-body">
    <div class="container-fluid">
    <div class="tabla-scrollable">
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="15%">
                        <col width="20%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th class="">Tipo de Práctica</th>
                            <th class="">Empresa/Institución y/o Proyecto</th>
                            <th class="">Estudiante</th>
                            <th class="">Tutor</th>
                            <th class="col-6">Fecha</th>
                            <th class="col-7">Hora Entrada	</th>
                            <th class="col-8">Hora Salida	</th>
                            <th class="col-9">Actividades realizadas 	</th>
                            <th class="col-10">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/CumplimientoHoras/detailsByUser"; 
                        $base_urlDoc = "http://localhost:5170/api/CumplimientoHoras"; 
                        $cumplimientoHoras = new CumplimientoHoras($base_url);
                        $cumplimientoHorasDoc = new CumplimientoHoras($base_urlDoc);
                        $user_type = $_settings->userdata('type');
                        // Obtener el ID del usuario actualmente logueado

                        $user_id = $_settings->userdata('id');
                       
                        if ($user_type == 1) {
                            $qry = $cumplimientoHoras->obtenerCumplimientoHorasPorUser($user_id);

                            
                        } else if ($user_type == 2) {

                            $qry = $cumplimientoHorasDoc->obtenerCumplimientoHoras();

                        }

                        foreach ($qry as $row) {
                            // Convertir la fecha al formato dd-mm-yy
                            $fechaFormateada = date("d-m-y", strtotime($row['fecha']));
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td class="">
                                    <p class=""><?php echo $row['tipo_area'] ?></p>
                                </td>
                                <td class="">
                                    <p class=""><?php echo $row['empresa_institucion_proyecto'] ?></p>
                                </td>
                                <td class="">
                                    <p class=""><?php echo $row['estudiante'] ?></p>
                                </td>
                                <td class="">
                                    <p class="">
                                        <?php echo ($row['tipo_area'] == 'Practicas Pre-Profesionales') ? $row['tutor_Externo'] : $row['docente_tutor']; ?>
                                    </p>
                                </td>
                                <td class="">
                                    <p class="">
                                            <?php 
                                            $fechas = explode(',', $row['fecha']);
                                            echo isset($fechas[0]) ? htmlspecialchars($fechas[0]): 'N/A'; 
                                            ?>
                                        </ul>
                                    </p>
                                </td>

                                <td class="">
                                    <p class="">
                                            <?php 
                                            $horaEntradas = explode(',', $row['hora_Entrada']);
                                            echo isset($horaEntradas[0]) ? htmlspecialchars($horaEntradas[0]): 'N/A'; 
                                            ?>
                                        </ul>
                                    </p>
                                </td>

                                <td class="">
                                    <p class="">
                                            <?php 
                                            $horaSalidas = explode(',', $row['hora_Salida']);
                                            echo isset($horaSalidas[0]) ? htmlspecialchars($horaSalidas[0]): 'N/A'; 
                                            ?>
                                        </ul>
                                    </p>
                                </td>
                               
                                <td class="">
                                    <p class="">
                                            <?php 
                                            $actividades = explode(',', $row['actividades_Realizadas']);
                                            echo isset($actividades[0]) ? htmlspecialchars($actividades[0]): 'N/A'; 
                                            ?>
                                        </ul>
                                    </p>
                                </td>
                                
                                
                                
                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Acción
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="./?page=CumplimientoHoras/view_cumplimiento_horas&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                        <?php if ($_settings->userdata('type') == 1) : ?>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item edit_data" href="./?page=CumplimientoHoras/manage_cumplimiento_horas&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_data" href="./?page=CumplimientoHoras/delete_cumplimiento_horas&id=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
        </div>
	    </div>
    </div>
</div>
<script>
    document.getElementById('practicaSelect').addEventListener('change', filtrarTabla);

    function filtrarTabla() {
        var practicaSeleccionada = document.getElementById('practicaSelect').value.toLowerCase().trim();
        var rows = document.querySelectorAll('table tbody tr');

        rows.forEach(function (row) {
            var nombrePractica = row.querySelector('td:nth-child(2) p').innerText.toLowerCase().trim();

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