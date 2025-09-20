<?php

require_once '../config.php';
require_once('../classes/CronoActi.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


$id = $_GET['id'];

// URL base de la API
$base_url = "http://localhost:5170/api/CronoActividades"; 
$cronoAct = new CronoActi($base_url);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = array(
        "id" => $_POST["id"],
        "CA_Estudiante" => $_POST["CA_Estudiante"],
        "CA_Cedula" => $_POST["CA_Cedula"],
        "CA_Actividad" => isset($_POST["CA_Actividad"]) ? implode("| ", $_POST["CA_Actividad"]) : '',
        "CA_Tarea" => isset($_POST["CA_Tarea"]) ? implode("| ", $_POST["CA_Tarea"]) : '',


        "CA_1raSemana" => $_POST["CA_1raSemana"],
        "CA1raSem_Lunes" => isset($_POST["CA1raSem_Lunes"]) ? implode(", ", $_POST["CA1raSem_Lunes"]) : '',
        "CA1raSem_Martes" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA1raSem_Martes"]) : '',
        "CA1raSem_Miercoles" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA1raSem_Miercoles"]) : '',
        "CA1raSem_Jueves" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA1raSem_Jueves"]) : '',

        "CA_2raSemana" => $_POST["CA_2raSemana"] ,
        "CA2raSem_Lunes" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA2raSem_Lunes"]) : '',
        "CA2raSem_Martes" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA2raSem_Martes"]) : '',
        "CA2raSem_Miercoles" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA2raSem_Miercoles"]) : '' ,
        "CA2raSem_Jueves" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA2raSem_Jueves"]) : '',

        "CA_3raSemana" => $_POST["CA_3raSemana"] ,
        "CA3raSem_Lunes" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA3raSem_Lunes"]) : '',
        "CA3raSem_Martes" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA3raSem_Martes"]) : '',
        "CA3raSem_Miercoles" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA3raSem_Miercoles"]) : '',
        "CA3raSem_Jueves" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA3raSem_Jueves"]) : '',

        "CA_4raSemana" => $_POST["CA_4raSemana"] ,
        "CA4taSem_Lunes" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA4taSem_Lunes"]) : '',
        "CA4taSem_Martes" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA4taSem_Martes"]) : '',
        "CA4taSem_Miercoles" => isset($_POST["CA1raSem_Martes"]) ?  implode(", ", $_POST["CA4taSem_Miercoles"]) : '',
        "CA4taSem_Jueves" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA4taSem_Jueves"]) : '',

        "users_id" => $_POST["users_id"] ?? ''
    );

     $respuesta = $cronoAct->actualizarCronoActi($id, $datos);
     //var_dump($respuesta);


}

// Obtener los detalles del registro del cronograma por su id
$row = $cronoAct->obtenerCronoActiPorUser($id);


?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/CronoActPract/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/CronoActPract/js/script.js" defer></script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">CRONOGRAMA DE ACTIVIDADES DE LA PRÁCTICA PRE PROFESIONAL DE LOS ESTUDIANTES</h3>
        <br>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form id="Crono_acti_frm" method="post" action="">
            <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
            <input type="hidden" name="firstname" id="firstname" value="<?php echo $_settings->userdata('firstname'); ?>">
            <input type="hidden" name="lastname" id="lastname" value="<?php echo $_settings->userdata('lastname'); ?>">
            <input type="hidden" name="CA_1raSemana" id="CA_1raSemana" value="1ra Semana" class="dias-adaptable">&nbsp;
            <input type="hidden" name="CA_2raSemana" id="CA_2raSemana" value="2da Semana" class="dias-adaptable">&nbsp;
            <input type="hidden" name="CA_3raSemana" id="CA_3raSemana" value="3ra Semana" class="dias-adaptable">&nbsp;
            <input type="hidden" name="CA_4raSemana" id="CA_4raSemana" value="4ta Semana" class="dias-adaptable">&nbsp;

                <fieldset class="border-bottom">
                    <h5 class="card-title">9. PLANIFICACIÓN Y CRONOGRAMA DE ACTIVIDADES</h5>
                    <br><br>
                    <label for="CA_Estudiante">Nombres del Estudiante</label>
                    <input type="text" name="CA_Estudiante" class="form-control"  value="<?php echo $row['cA_Estudiante']; ?>" readonly>
                    <label for="CA_Cedula">Cédula del Estudiante</label>
                    <input type="text" name="CA_Cedula" class="form-control"  value="<?php echo $row['cA_Cedula']; ?>" readonly>
                    <div class="row">
                        <table class="table" id="cronogramaTable">
                            <thead>
                                <tr>
                                   
                                    <th>ACTIVIDAD</th>
                                    <th>TAREAS</th>
                                    <th>1ra Semana</th>
                                    <th>2da Semana</th>
                                    <th>3era Semana</th>
                                    <th>4ta Semana</th>
                                </tr>
                                <tr>
                                    <th><p for="CA_Actividad" class="notificacion">(de acuerdo a lo establecido <br>en la planificación de prácticas<br> de la carrera)</p></th>
                                    <th><p for="CA_Tarea" class="notificacion">(detalle de las <br>actividades a realizar)</p></th>
                                    <th class="dias-semanas"><p>Semanas</p>1 &nbsp; 2 &nbsp; 3 &nbsp; 4 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>5 &nbsp; 6 &nbsp; 7 &nbsp; 8 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>9 &nbsp; 10 &nbsp; 11 &nbsp; 12 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>13 &nbsp; 14 &nbsp; 15 &nbsp; 16 &nbsp; </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                $actividades = isset($row['cA_Actividad']) ? explode("| ", $row['cA_Actividad']) : [];
                                $tareas = isset($row['cA_Tarea']) ? explode("| ", $row['cA_Tarea']) : [];

                                $primera_sem_lun = isset($row['cA1raSem_Lunes']) ? explode(", ", $row['cA1raSem_Lunes']) : [];
                                $primera_sem_mar = isset($row['cA1raSem_Martes']) ? explode(", ", $row['cA1raSem_Martes']) : [];
                                $primera_sem_mier = isset($row['cA1raSem_Miercoles']) ? explode(", ", $row['cA1raSem_Miercoles']) : [];
                                $primera_sem_jue = isset($row['cA1raSem_Jueves']) ? explode(", ", $row['cA1raSem_Jueves']) : [];

                                $segunda_sem_lun = isset($row['cA2raSem_Lunes']) ? explode(", ", $row['cA2raSem_Lunes']) : [];
                                $segunda_sem_mar = isset($row['cA2raSem_Martes']) ? explode(", ", $row['cA2raSem_Martes']) : [];
                                $segunda_sem_mier = isset($row['cA2raSem_Miercoles']) ? explode(", ", $row['cA2raSem_Miercoles']) : [];
                                $segunda_sem_jue = isset($row['cA2raSem_Jueves']) ? explode(", ", $row['cA2raSem_Jueves']) : [];

                                $tercera_sem_lun = isset($row['cA3raSem_Lunes']) ? explode(", ", $row['cA3raSem_Lunes']) : [];
                                $tercera_sem_mar = isset($row['cA3raSem_Martes']) ? explode(", ", $row['cA3raSem_Martes']) : [];
                                $tercera_sem_mier = isset($row['cA3raSem_Miercoles']) ? explode(", ", $row['cA3raSem_Miercoles']) : [];
                                $tercera_sem_jue = isset($row['cA3raSem_Jueves']) ? explode(", ", $row['cA3raSem_Jueves']) : [];

                                $cuarta_sem_lun = isset($row['cA4taSem_Lunes']) ? explode(", ", $row['cA4taSem_Lunes']) : [];
                                $cuarta_sem_mar = isset($row['cA4taSem_Martes']) ? explode(", ", $row['cA4taSem_Martes']) : [];
                                $cuarta_sem_mier = isset($row['cA4taSem_Miercoles']) ? explode(", ", $row['cA4taSem_Miercoles']) : [];
                                $cuarta_sem_jue = isset($row['cA4taSem_Jueves']) ? explode(", ", $row['cA4taSem_Jueves']) : [];


                                for ($i = 0; $i < count($actividades); $i++) {
                                    echo '<tr>';
                                    echo '<td><input type="text" name="cA_Actividad[]" value="'. $actividades[$i] . '" class="form-control form-control-sm rounded-0"></td>';
                                    echo '<td><input type="text" name="cA_Tarea[]" value="' . $tareas[$i] . '" class="form-control form-control-sm rounded-0"></td>';

                                    echo '<td>';
                                    echo '<input type="text" name="cA1raSem_Lunes[]" value="' . $primera_sem_lun[$i] . '" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;';
                                    echo '<input type="text" name="cA1raSem_Martes[]" value="' . $primera_sem_mar[$i] . '" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;';
                                    echo '<input type="text" name="cA1raSem_Miercoles[]" value=" ' . $primera_sem_mier[$i] . '" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;';
                                    echo '<input type="text" name="cA1raSem_Jueves[]" value=" ' . $primera_sem_jue[$i] . '" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;';
                                    echo '</td>';

                                    echo '<td>';
                                    echo '<input type="text" name="cA2raSem_Lunes[]" value="' . $segunda_sem_lun[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;';
                                    echo '<input type="text" name="cA2raSem_Martes[]" value="' . $segunda_sem_mar[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;';
                                    echo '<input type="text" name="cA2raSem_Miercoles[]" value="' . $segunda_sem_mier[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;';
                                    echo '<input type="text" name="cA2raSem_Jueves[]" value="' . $segunda_sem_jue[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;';
                                    echo '</td>';

                                    echo '<td>';
                                    echo '<input type="text" name="cA3raSem_Lunes[]" value="' . $tercera_sem_lun[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;&nbsp;&nbsp;';
                                    echo '<input type="text" name="cA3raSem_Martes[]" value="' . $tercera_sem_mar[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;&nbsp;&nbsp;';
                                    echo '<input type="text" name="cA3raSem_Miercoles[]" value="' . $tercera_sem_mier[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;&nbsp;&nbsp;';
                                    echo '<input type="text" name="cA3raSem_Jueves[]" value="' . $tercera_sem_jue[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;&nbsp;&nbsp;';
                                    echo '</td>';

                                    echo '<td>';
                                    echo '<input type="text" name="cA4taSem_Lunes[]" value="' . $cuarta_sem_lun[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo '<input type="text" name="cA4taSem_Martes[]" value="' . $cuarta_sem_mar[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo '<input type="text" name="cA4taSem_Miercoles[]" value="' . $cuarta_sem_mier[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo '<input type="text" name="cA4taSem_Jueves[]" value="' . $cuarta_sem_jue[$i] .'" class="dias-adaptable" onclick="this.value=\'\'; this.value=\'X\';">&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo '</td>';

                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                        
                        <button type="button" class="btn btn-success" id="add-row-btn">Agregar Fila</button>
                        <button type="button" class="btn btn-danger" id="removeRowBtn">Quitar Fila</button>
                        
                    </div>
                </fieldset>
                <br><br>
                <div class="card-footer text-right">
                    <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Cronograma</button>
                    <a href="./?page=ActPract/CronoActPract" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

