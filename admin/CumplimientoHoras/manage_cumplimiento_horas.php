<?php
require_once '../config.php';
require_once('../classes/CumplimientoHoras.php');



$id = $_GET['id'];

$base_url = "http://localhost:5170/api/CumplimientoHoras";
$cumplimientoHoras = new CumplimientoHoras($base_url);
$user_id = $_settings->userdata('id');
$row = $cumplimientoHoras->obtenerCumplimientoHorasPorUser($id);
$student_id = $row['users_id'];
$obtenerPlanificacion = $cumplimientoHoras->obtenerPlanificaciones($student_id);



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $datos = array(
        "id" => $_POST["id"],
        "Tipo_area" => $_POST["Tipo_area"] ?? '',
        "Empresa_institucion_proyecto" => $_POST["Empresa_institucion_proyecto"],
        "Docente_tutor" => $_POST["Docente_tutor"],
        "Tutor_Externo" => $_POST["Tutor_Externo"],
        "Estudiante" => $_POST["Estudiante"],
        "Fecha" => implode(", ", $_POST["Fecha"]), 
        "Hora_Entrada" => implode(", ", $_POST["Hora_Entrada"]),
        "Hora_Salida" => implode(", ", $_POST["Hora_Salida"]),
        "Actividades_Realizadas" => implode(", ", $_POST["Actividades_Realizadas"]),
        "users_id" => $_POST["users_id"]
    );

    $respuesta = $cumplimientoHoras->actualizarCumplimientoHoras($id, $datos);

   
}


?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/CumplimientoHoras/css/styles.css">
<script src="<?php echo base_url ?>admin/CumplimientoHoras/js/script.js" defer></script>
<script>
    const planificacionPorArea = <?= json_encode($cumplimientoHoras->obtenerPlanificaciones($student_id)) ?>;
</script>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">REGISTRO DE HORAS DE PRÁCTICA PRE PROFESIONAL Y/O DE SERVICIO COMUNITARIO</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form id="cumplimiento-horas-frm" method="post" action="">
                <input type="hidden" name="id" value="<?php echo $row['id'] ? $id : '' ?>">
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
                                                        $selected = (isset($row['tipo_area']) && $row['tipo_area'] === $p['tP_Area']) ? 'selected' : '';
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
                        <input type="text" name="Estudiante" id="Estudiante" value="<?php echo $row['estudiante'] ?>" class="form-control form-control-sm rounded-0" placeholder="Nombres y apellidos completos del estudiante" required>
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
                                
                                    <?php
                                    $fechas = isset($row['fecha']) ? explode(", ", $row['fecha']) : [];
                                    $horaEntradas = isset($row['hora_Entrada']) ? explode(", ", $row['hora_Entrada']) : [];
                                    $horaSalidas = isset($row['hora_Salida']) ? explode(", ", $row['hora_Salida']) : [];
                                    $actividadesRealizadas = isset($row['actividades_Realizadas']) ? explode(", ", $row['actividades_Realizadas']) : [];

                                    for ($i = 0; $i < count($fechas); $i++) {
                                        echo '<tr>';
                                        echo '<td><input type="date" name="Fecha[]" value="' . $fechas[$i] . '" class="form-control form-control-sm rounded-0" required></td>';
                                        echo '<td><input type="text" name="Hora_Entrada[]" value="' . $horaEntradas[$i] . '" class="form-control form-control-sm rounded-0" required></td>';
                                        echo '<td><input type="text" name="Hora_Salida[]" value="' . $horaSalidas[$i] . '" class="form-control form-control-sm rounded-0" required></td>';
                                        echo '<td><input type="text" name="Actividades_Realizadas[]" value="' . $actividadesRealizadas[$i] . '" class="form-control form-control-sm rounded-0" required></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                        </tbody>
                        
                    </table>
                    <input type="hidden" name="users_id" value="<?= $row['users_id'] ?>">

                    <div class="text-right">
                        <button type="button" class="btn btn-success btn-sm" id="add-row-btn">Agregar Registro</button>
                        <button type="button" class="btn btn-danger btn-sm" id="remove-row-btn">Eliminar Registro</button>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Actividades</button>
                    <a href="./?page=CumplimientoHoras" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                </div>
            </form>
            <br><br>
        </div>
    </div>
</div>



