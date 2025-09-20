<?php
require_once '../config.php';
require_once('../classes/Planificacion.php');

$base_url = "http://localhost:5170/api/Planificacion";
$planificacion = new Planificacion($base_url);


$user_id = isset($_GET['id']) ? $_GET['id'] : $_settings->userdata('id');


$obtenerProyectos = $planificacion->obtenerProyectos($user_id);
$nombreProyectoPractPro = '';

foreach ($obtenerProyectos as $proyecto) {
    if ($proyecto['area'] === 'Practicas Pre-Profesionales') {
        $nombreProyectoPractPro = $proyecto['nombre_proyecto_pract_pro'];
        break;
    }
}


$stmt = $conn->prepare("SELECT DISTINCT area FROM area_docente WHERE users_id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$practicas = [];
while ($row = $result->fetch_assoc()) {
    $practicas[] = $row['area'];
}
$stmt->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estudiantes_seleccionados = isset($_POST["TP_Nomina_est_asig"]) && is_array($_POST["TP_Nomina_est_asig"]) ? implode(', ', $_POST["TP_Nomina_est_asig"]) : '';

    $datos = array(
        "TP_Carrera" => $_POST["TP_Carrera"] ?? '',
        "TP_Area" => $_POST["TP_Area"] ?? '',
        "TP_Docente" => $_POST["TP_Docente"] ?? '',
        "TP_Ciclo" => $_POST["TP_Ciclo"] ?? '',
        "TP_Categra_Int" => $_POST["TP_Categra_Int"] ?? '',
        "TP_Proyecto_Integrador" => $_POST["TP_Proyecto_Integrador"] ?? '',
        "TP_Proyecto_Serv_Com" => $_POST["TP_Proyecto_Serv_Com"] ?? '',
        "TP_Horas_Pract" => $_POST["TP_Horas_Pract"] ?? '',
        "TP_Num_Est_Pract" => $_POST["TP_Num_Est_Pract"] ?? '',
        "TP_Act_Realizar" => $_POST["TP_Act_Realizar"] ?? '',
        "EstudianteLider" => $_POST["EstudianteLider"] ?? '',
        "TP_Nomina_est_asig" => $estudiantes_seleccionados,
        "TP_Docente_tutor" => $_POST["TP_Docente_tutor"] ?? '',
        "TP_Inst_Emp" => $_POST["TP_Inst_Emp"] ?? '',
        "TP_Propuesta" => $_POST["TP_Propuesta"] ?? '',
        "users_id" => $_POST["users_id"] ?? ''
    );

    $respuesta = $planificacion->crearPlanificacion($datos);
    // var_dump($datos);
}


$es_lider = $planificacion->esLiderGrupo($user_id);

?>


<link rel="stylesheet" href="<?php echo base_url ?>admin/planificacion/css/styles.css">
<script src="<?php echo base_url ?>admin/planificacion/js/script.js" defer></script>
<script>
    const proyectosPorArea = <?= json_encode($planificacion->obtenerProyectos($user_id)) ?>;
</script>


<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">Unidad Académica de: Informática, Ciencias de la Computación e Innovación Tecnológica
        </h3>
        <br>
        <h4 class="card-title"> Período Lectivo: Marzo 2024 - Agosto 2024</h4>
    </div>
    <hr class="custom-divider">
    <br>
    <div class="card-body">
            <div class="container-fluid">
                <?php if ($_settings->userdata('type') == 1): // Usuario tipo 1 (Estudiante) ?>

                    <form id="planificacion_frm" method="post" action="">
                        <fieldset class="border-bottom">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="TP_Ciclo" class="control-label">Ciclo:</label>
                                    <input type="text" name="TP_Ciclo" id="TP_Ciclo"
                                        class="form-control form-control-sm rounded-0"
                                        value="<?php echo $estudiante['ciclo'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="TP_Carrera" class="control-label">Carrera: </label>
                                    <input type="text" name="TP_Carrera" id="TP_Carrera"
                                        value="<?php echo $estudiante['carrera'] ?? '' ?>"
                                        class="form-control form-control-sm rounded-0" readonly autofocus>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="TP_Categra_Int" class="control-label">Categra Integradora:</label>
                                    <input type="text" name="TP_Categra_Int" id="TP_Categra_Int" value="N/A"
                                        class="form-control form-control-sm rounded-0" readonly>
                                </div>
                                 <div class="form-group col-md-4">
                                    <label for="TP_Area" class="control-label">Area:</label>
                                    <select name="TP_Area" id="TP_Area" class="form-control form-control-sm rounded-0 select2" required onchange="actualizarCampos()">
                                        <option value="">Seleccione un área</option>
                                            <?php
                                                $proyectos = $planificacion->obtenerProyectos($user_id);
                                                $areasUnicas = [];
                                                foreach ($proyectos as $p) {
                                                    if (!in_array($p['area'], $areasUnicas)) {
                                                        $areasUnicas[] = $p['area'];
                                                        $selected = (isset($row['area']) && $row['area'] === $p['area']) ? 'selected' : '';
                                                        echo "<option value=\"{$p['area']}\" $selected>{$p['area']}</option>";
                                                    }
                                                }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="proyecto_input_group">
                                    <label for="TP_Proyecto_Integrador" class="control-label">Proyecto Integrador:</label>
                                    <input type="text" name="TP_Proyecto_Integrador" id="TP_Proyecto_Serv_Com_text"
                                    class="form-control form-control-sm rounded-0"
                                    value="<?= htmlspecialchars($nombreProyectoPractPro ?? '') ?>"
                                    placeholder="Escriba el nombre del proyecto laboral" />
                                </div>
                               
                                <div class="form-group col-md-4" id="proyecto_select_group">
                                    <label for="TP_Proyecto_Serv_Com" class="control-label">Nombre del Proyecto:</label>
                                    <select name="TP_Proyecto_Serv_Com" id="TP_Proyecto_Serv_Com" class="form-control form-control-sm rounded-0 select2">
                                        <option value="">Seleccione un proyecto</option>
                                        <?php
                                        $proyectos = $planificacion->obtenerProyectos($user_id);
                                        $proyectosUnicos = [];
                                        $valorPorDefecto = '';
                                        foreach ($proyectos as $p) {
                                            if (!in_array($p['nombre_proyecto'], $proyectosUnicos)) {
                                                $proyectosUnicos[] = $p['nombre_proyecto'];
                                                $selected = (isset($row['nombre_proyecto']) && $row['nombre_proyecto'] == $p['nombre_proyecto']) ? 'selected' : '';
                                                echo "<option value=\"{$p['nombre_proyecto']}\" $selected>{$p['nombre_proyecto']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                               
                                <div class="form-group col-md-4">
                                    <label for="TP_Docente" class="control-label"> Docente responsable de prácticas:</label>
                                    <select name="TP_Docente" id="TP_Docente"
                                        class="form-control form-control-sm rounded-0 select2" required>
                                         <option value="">Seleccione un docente</option>
                                            <?php
                                                $docentes = $planificacion->obtenerDocentes();
                                                $docentesUnicos = [];
                                                foreach ($docentes as $d) {
                                                    $nombreCompleto = $d['firstname'] . ' ' . $d['lastname'];

                                                    if (!in_array($nombreCompleto, $docentesUnicos)) {
                                                        $docentesUnicos[] = $nombreCompleto;
                                                        $selected = (isset($row['firstname']) && ($row['firstname'] . ' ' . $row['lastname']) === $nombreCompleto) ? 'selected' : '';
                                                        echo "<option value=\"{$nombreCompleto}\" $selected>{$nombreCompleto}</option>";
                                                    }
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>

                            <hr class="custom-divider">
                            <br>

                            <div class="row">

                                <div class="form-group col-md-4" id="TP_Horas_Pract_select_div">
                                    <label for="TP_Horas_Pract" class="control-label">Número de horas de práctica:</label>
                                    <select name="TP_Horas_Pract" id="TP_Horas_Pract"
                                        class="form-control form-control-sm rounded-0 select2" required>
                                        <option value="120">120</option>
                                        <option value="240">240</option>
                                    </select>
                                </div>

                                <?php if ($es_lider || $_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
                                    <div class="form-group col-md-8">
                                        <label for="TP_Num_Est_Pract" class="control-label">Número de estudiantes que deben
                                            hacer prácticas(*Llenar este campo en caso que sea estudiante lider):</label>
                                        <input type="number" name="TP_Num_Est_Pract" id="TP_Num_Est_Pract"
                                            class="form-control form-control-sm rounded-0" value="1">
                                    </div>
                                <?php else: ?>
                                    <div class="form-group col-md-8">
                                        <label for="TP_Num_Est_Pract" class="control-label">Número de estudiantes que deben
                                            hacer prácticas(*Llenar este campo en caso que sea estudiante lider):</label>
                                        <input type="number" name="TP_Num_Est_Pract" id="TP_Num_Est_Pract"
                                            class="form-control form-control-sm rounded-0" disabled>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group col-md-12">
                                    <label for="TP_Act_Realizar" class="control-label">Actividades a realizar:</label>
                                    <textarea rows="3" name="TP_Act_Realizar" id="TP_Act_Realizar"
                                        class="form-control form-control-sm rounded-0" required>Diseñar, planificar y ejecutar las actividades de enseñanza-aprendizaje, mediante los cursos de capacitación dirigido a docentes y estudiantes de las instituciones educativas participantes en el proyecto
                                    </textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="TP_Propuesta" class="control-label">Propuesta en la que va a
                                        participar(Puede cambiar la propuesta si es necesario)</label>
                                    <textarea rows="3" name="TP_Propuesta" id="TP_Propuesta"
                                        class="form-control form-control-sm rounded-0"
                                        required><?php echo $estudiante['propuesta'] ?? '' ?></textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="EstudianteLider" class="control-label">Estudiante nombres completos:</label>
                                    <input type="text" name="EstudianteLider" id="EstudianteLider"
                                        value="<?php echo ucwords($_settings->userdata('firstname')) . " " . ($_settings->userdata('lastname')) ?>"
                                        class="form-control form-control-sm rounded-0" required readonly>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="TP_Docente_tutor" class="control-label">
                                        Docente Tutor asignado por grupo de estudiantes:
                                    </label>
                                    
                                    <select name="TP_Docente_tutor" id="TP_Docente_tutor"
                                        class="form-control form-control-sm rounded-0 select2" required>
                                        <option value="">Seleccione un docente</option>
                                        <?php
                                            $docentesTutores = $planificacion->obtenerDocentesTutores();
                                            $docentesTutoresUnicos = [];
                                            foreach ($docentesTutores as $d) {
                                                $nombreCompleto = $d['firstname'] . ' ' . $d['lastname'];
                                                if (!in_array($nombreCompleto, $docentesTutoresUnicos)) {
                                                    $docentesTutoresUnicos[] = $nombreCompleto;
                                                    echo "<option value=\"{$nombreCompleto}\">{$nombreCompleto}</option>";
                                                }
                                            }
                                        ?>
                                        <option value="otro">Otro (escriba nombre)</option>
                                    </select>

                                    <div class="form-group mt-2" id="otro_docente_input_group" style="display: none;">
                                        <label for="otro_docente_input">Ingrese el nombre del docente tutor:</label>
                                        <input type="text" class="form-control" id="otro_docente_input" placeholder="Nombre completo">
                                    </div>
                                </div>




                                <?php if ($es_lider && $_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
                                    <div class="form-group col-md-12">
                                        <label for="TP_Nomina_est_asig" class="control-label">Nómina de estudiantes
                                            asignados:</label>
                                        <select name="TP_Nomina_est_asig[]" id="TP_Nomina_est_asig"
                                            class="form-control form-control-sm rounded-0 select2" multiple>
                                            <?php
                                            $estudiantes = $planificacion->obtenerEstudiantes();
                                            foreach ($estudiantes as $estudiante) {
                                                $fullname = ucwords($estudiante['firstname'] . " " . $estudiante['lastname']);
                                                echo "<option value='" . $fullname . "'>" . $fullname . "</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-12">
                                    <label for="TP_Inst_Emp" class="control-label">Institución y/o Empresa:</label>
                                    <input type="text" id="TP_Inst_Emp" name="TP_Inst_Emp" class="form-control form-control-sm rounded-0" value="<?php echo $estudiante['nombre_institucion'] ?? '' ?>" placeholder="Nombre de la institución" required>
                                </div>




                            </div>
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id') ?>">
                        </fieldset>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Planificación</button>
                            <a href="./?page=planificacion" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
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

            </div>
    </div>

<div class="card-body">
    <div class="container-fluid">  
    <div class="tabla-scrollable">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="bg-gradient-dark text-light">
                    <th>#</th>
                    <th class="col-1">Carrera</th>
                    <th class="col-3">Estudiante</th>
                    <th class="col-2">Area</th>
                    <th class="col-2">Ciclo</th>
                    <th class="col-6">Proyecto Integrador</th>
                    <th class="col-12">Docente Tutor</th>
                    <th class="col-2">Instituciones o Empresas</th>
                    <th class="col-15">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $user_type = $_settings->userdata('type');
                $base_url = "http://localhost:5170/api/Planificacion/detailsByUser";
                $base_urlDoc = "http://localhost:5170/api/Planificacion";
                $planificacion = new Planificacion($base_url);
                $planificacionD = new Planificacion($base_urlDoc);


                if ($user_type == 1) {
                    $qry = $planificacion->obtenerPlanificacionPorUser($user_id);
                } else if ($user_type == 2) {
                    $qry = $planificacionD->obtenerPlanificaciones();

                }




                foreach ($qry as $row) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td class="">
                            <p class=""><?php echo $row['tP_Carrera'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['estudianteLider'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['tP_Area'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['tP_Ciclo'] ?></p>
                        </td>
                        <td class="">
                            <p class="">
                                <?php 
                                    echo !empty($row['tP_Proyecto_Integrador']) 
                                        ? $row['tP_Proyecto_Integrador'] 
                                        : $row['tP_Proyecto_Serv_Com'];
                                ?>
                            </p>
                        </td>


                        <td class="">
                            <p class=""><?php echo $row['tP_Docente_tutor'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['tP_Inst_Emp'] ?></p>
                        </td>

                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                data-toggle="dropdown">
                                Acción
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item view_data"
                                    href="./?page=planificacion/view_planificacion&id=<?php echo $row['id'] ?>"><span
                                        class="fa fa-eye text-dark"></span> Ver</a>
                                <?php if ($_settings->userdata('type') == 1): ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item edit_data"
                                        href="./?page=planificacion/manage_planificacion&id=<?php echo $row['id'] ?>"><span
                                            class="fa fa-edit text-primary"></span> Editar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data"
                                        href="./?page=planificacion/delete_planificacion&id=<?php echo $row['id'] ?>"><span
                                            class="fa fa-trash text-danger"></span> Eliminar</a>
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

<script>
    $(document).ready(function () {
        $('#TP_Nomina_est_asig').select2({
            placeholder: "Buscar estudiantes...",
            allowClear: true
        });


        // Validación para el número máximo de estudiantes seleccionados
        $('#TP_Nomina_est_asig').on('change', function () {
            var maxEstudiantes = parseInt($('#TP_Num_Est_Pract').val());
            var estudiantesSeleccionados = $(this).val().length;

            if (estudiantesSeleccionados > maxEstudiantes) {
                alert("No puedes seleccionar más de " + maxEstudiantes + " estudiantes.");

                var seleccionValida = $(this).val().slice(0, maxEstudiantes);
                $('#TP_Nomina_est_asig').val(seleccionValida).trigger('change');
            }
        });
    });


document.getElementById('practicaSelect').addEventListener('change', filtrarTabla);

function filtrarTabla() {
    var practicaSeleccionada = document.getElementById('practicaSelect').value.toLowerCase().trim();
    var rows = document.querySelectorAll('table tbody tr');

    rows.forEach(function (row) {
        var nombrePractica = row.querySelector('td:nth-child(4) p').innerText.toLowerCase().trim();

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