

<?php
require_once '../config.php';
require_once('../classes/Planificacion.php');

$base_url = "http://localhost:5170/api/Planificacion"; 
$planificacion = new Planificacion($base_url);
      

    
        $id = $_GET['id'];
        $user_id = $_settings->userdata('id');
        $i = 1;

$docentes = $planificacion->obtenerDocentes();

$nombreProyectoPractPro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

     $estudiantes_seleccionados = isset($_POST["TP_Nomina_est_asig"]) && is_array($_POST["TP_Nomina_est_asig"])
     ? implode(', ', $_POST["TP_Nomina_est_asig"])
     : ''; 
    $datos = array(
        
        "id" => $_POST["id"],
        "TP_Carrera" => $_POST["TP_Carrera"],
        "TP_Area" => $_POST["TP_Area"],
        "TP_Docente" => $_POST["TP_Docente"],
        "TP_Ciclo" => $_POST["TP_Ciclo"],
		"TP_Categra_Int" => $_POST["TP_Categra_Int"],
		"TP_Proyecto_Integrador" => $_POST["TP_Proyecto_Integrador"],
		"TP_Proyecto_Serv_Com" => $_POST["TP_Proyecto_Serv_Com"],
		"TP_Horas_Pract" => $_POST["TP_Horas_Pract"],
		"TP_Num_Est_Pract" => $_POST["TP_Num_Est_Pract"],
		"TP_Act_Realizar" => $_POST["TP_Act_Realizar"],
        "EstudianteLider" => $_POST["EstudianteLider"],
        "TP_Nomina_est_asig" => $estudiantes_seleccionados,
        "TP_Docente_tutor" => $_POST["TP_Docente_tutor"],
		"TP_Inst_Emp" => $_POST["TP_Inst_Emp"],
		"TP_Propuesta" => $_POST["TP_Propuesta"],
		"users_id" => $_POST["users_id"]
        
    );

  
    $respuesta = $planificacion->actualizarPlanificacion($id, $datos);
    //var_dump($datos);
}

    $row = $planificacion->obtenerPlanificacionPorUser($id);
    $es_lider = $planificacion->esLiderGrupo($user_id);
    $estudiantes = $planificacion->obtenerEstudiantes();
    $student_id = $row['users_id'];

    $obtenerProyectos = $planificacion->obtenerProyectos($student_id);



    ?>


<link rel="stylesheet" href="<?php echo base_url ?>admin/planificacion/css/styles.css">
<script src="<?php echo base_url ?>admin/planificacion/js/script.js" defer></script>
<script>
    const proyectosPorArea = <?= json_encode($planificacion->obtenerProyectos($student_id)) ?>;
</script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">Unidad Académica de: Informática, Ciencias de la Computación e Innovación Tecnológica</h3>
        <br>
        <h4 class="card-title"> Período Lectivo: Marzo 2024 - Agosto 2024</h4>
        
    </div>
    <hr class="custom-divider">
                        <br>  
    <div class="card-body">

        <div class="container-fluid">
            <div class="container-fluid">

            <form id="planificacion_frm" method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id'] ? $id : '' ?>">

                <fieldset class="border-bottom">
                    
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="TP_Ciclo" class="control-label">Ciclo:</label>
                                <input type="text" name="TP_Ciclo" id="TP_Ciclo" value="<?php echo $row['tP_Ciclo'] ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="TP_Carrera" class="control-label">Carrera: </label>
                                <input type="text" name="TP_Carrera" id="TP_Carrera" value="<?php echo $row['tP_Carrera'] ?>" autofocus  class="form-control form-control-sm rounded-0"  required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="TP_Categra_Int" class="control-label">Categra Integradora:</label>
                                <input type="text" name="TP_Categra_Int" id="TP_Categra_Int" value="<?php echo $row['tP_Categra_Int'] ?>" class="form-control form-control-sm rounded-0">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="TP_Area" class="control-label">Área:</label>
                                <select name="TP_Area" id="TP_Area" class="form-control form-control-sm rounded-0 select2" required onchange="actualizarCampos(this.value)" >
                                    <?php
                                        $areasUnicas = [];
                                        foreach ($obtenerProyectos as $p) {
                                            if (!in_array($p['area'], $areasUnicas)) {
                                                $areasUnicas[] = $p['area'];
                                                $selected = (isset($row['tP_Area']) && $row['tP_Area'] === $p['area']) ? 'selected' : '';
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
                                        $proyectosUnicos = [];
                                        $valorPorDefecto = '';
                                        foreach ($obtenerProyectos as $p) {
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
                                            
                                            <?php
                                                $docentesUnicos = [];
                                                foreach ($docentes as $d) {
                                                    $nombreCompleto = $d['firstname'] . ' ' . $d['lastname'];

                                                    if (!in_array($nombreCompleto, $docentesUnicos)) {
                                                        $docentesUnicos[] = $nombreCompleto;
                                                        $selected = (isset($row['tP_Docente']) && $row['tP_Docente'] === $nombreCompleto) ? 'selected' : '';
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
                            <div class="form-group col-md-6" id="TP_Horas_Pract_select_div">
                                <label for="TP_Horas_Pract" class="control-label">Número de horas de práctica:</label>
                                <select name="TP_Horas_Pract" id="TP_Horas_Pract" class="form-control form-control-sm rounded-0 select2" required>
                                    <option value="120"<?php echo $row['tP_Horas_Pract'] == '120' ? ' selected' : '' ?>>120</option>
                                    <option value="240"<?php echo $row['tP_Horas_Pract'] == '240' ? ' selected' : '' ?>>240</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="TP_Num_Est_Pract" class="control-label">Número de estudiantes que deben hacer prácticas:</label>
                                <input type="text" name="TP_Num_Est_Pract" id="TP_Num_Est_Pract" value="<?php echo $row['tP_Num_Est_Pract'] ?>" autofocus class="form-control form-control-sm rounded-0" required>
                            </div>
                            <?php if ($es_lider || $_settings->userdata('type') == 2): ?>
                                <div class="form-group col-md-4">
                                    <label for="TP_Nomina_est_asig" class="control-label">Nómina de estudiantes asignados:</label>
                                    <select name="TP_Nomina_est_asig[]" id="TP_Nomina_est_asig" class="form-control form-control-sm rounded-0 select2" multiple>
                                        <?php
                                        // Obtener los estudiantes disponibles para seleccionar
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
                                <label for="EstudianteLider" class="control-label">Estudiante nombres completos:</label>
                                <input type="text" name="EstudianteLider" id="EstudianteLider" value="<?php echo $row['estudianteLider']?>" class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="TP_Act_Realizar" class="control-label">Actividades a realizar:</label>
                                <textarea rows="3" name="TP_Act_Realizar" id="TP_Act_Realizar"  class="form-control form-control-sm rounded-0" required><?php echo $row['tP_Act_Realizar'] ?></textarea>
                            </div>
                            
                        </div>
                            

                        

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="TP_Docente_tutor" class="control-label">Docente Tutor:</label>
                                    <select name="TP_Docente_tutor" id="TP_Docente_tutor"
                                        class="form-control form-control-sm rounded-0 select2" required>
                                            
                                            <?php
                                                $docentes = $planificacion->obtenerDocentesTutores();
                                                $docentesUnicosTutores = [];
                                                $valorGuardado = isset($row['tP_Docente_tutor']) ? trim($row['tP_Docente_tutor']) : '';
                                                $encontrado = false;
                                                foreach ($docentes as $d) {
                                                    $nombreCompleto = $d['firstname'] . ' ' . $d['lastname'];

                                                    if (!in_array($nombreCompleto, $docentesUnicosTutores)) {
                                                        $docentesUnicosTutores[] = $nombreCompleto;

                                                        $selected = (strcasecmp($valorGuardado, $nombreCompleto) == 0) ? 'selected' : '';
                                                        if ($selected) $encontrado = true;

                                                        echo "<option value=\"$nombreCompleto\" $selected>$nombreCompleto</option>";
                                                    }
                                                }

                                                // Si no se encontró en el listado, lo agregamos como opción
                                                if (!$encontrado && !empty($valorGuardado)) {
                                                    echo "<option value=\"$valorGuardado\" selected>$valorGuardado</option>";
}
                                            ?>
                                            <option value="otro">Otro (escriba nombre)</option>
                                    </select>
                                    <div class="form-group mt-12" id="otro_docente_input_group" style="display: none;">
                                        <label for="otro_docente_input">Ingrese el nombre del docente tutor:</label>
                                        <input type="text" class="form-control" id="otro_docente_input" placeholder="Nombre completo">
                                    </div>
                                </div>
                            <div class="form-group col-md-12">
                                <label for="TP_Inst_Emp" class="control-label">Institución y/o Empresa:</label>
                                <input type="text" name="TP_Inst_Emp" id="TP_Inst_Emp" value="<?php echo $row['tP_Inst_Emp'] ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="TP_Propuesta" class="control-label">Propuesta en la que va a participar</label>
                                <textarea rows="3" name="TP_Propuesta" id="TP_Propuesta" class="form-control form-control-sm rounded-0" required><?php echo $row['tP_Propuesta'] ?></textarea>
                            </div>
                            <input type="hidden" name="users_id" value="<?php echo $row['users_id'] ?>">
                            <input type="hidden" name="matriculacion_id" value="<?php echo $matriculacion_id ?>">

                        </div>

                    
                    <div class="card-footer text-right">
                        <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Planificación</button>
                        <a href="./?page=planificacion" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                    </div>
                    </fieldset>
                </form>
                </div>
                </div>
                </div>
    </div>
</div>


<script>
     $(document).ready(function() {
         $('#TP_Nomina_est_asig').select2({
            placeholder: "Buscar estudiantes...",
            allowClear: true
        }); 


    // Validación para el número máximo de estudiantes seleccionados
    $('#TP_Nomina_est_asig').on('change', function() {
        var maxEstudiantes = parseInt($('#TP_Num_Est_Pract').val());
        
        // Contamos cuántos estudiantes están seleccionados
        var estudiantesSeleccionados = $(this).val().length;

        // Si el número de seleccionados excede el máximo, mostramos un mensaje de error
        if (estudiantesSeleccionados > maxEstudiantes) {
            alert("No puedes seleccionar más de " + maxEstudiantes + " estudiantes.");
            
            // Eliminar la selección extra
            var seleccionValida = $(this).val().slice(0, maxEstudiantes);
            $('#TP_Nomina_est_asig').val(seleccionValida).trigger('change'); 
        }
    });
}); 
</script>