<?php
require_once '../config.php';
require_once('../classes/EvaluacionPract.php');


$Fecha_Inicio = '';
$Fecha_Supervicion ='';
$FechaRegistro = '';




 $user_id = $_settings->userdata('id');
 $i = 1;
 $id = $_GET['id'];

$base_url = "http://localhost:5170/api/EvaluacionPractica";
$evaluacionPractica = new EvaluacionPract($base_url);

$row = $evaluacionPractica->obtenerEvaluacionPracticaPorUser($id);
$student_id = $row['users_id'];
$obtenerPlanificacion = $evaluacionPractica->obtenerPlanificaciones($student_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $datos = array(
            "id" => $_POST["id"],
            "Empresa_institucion_proyecto" => $_POST["Empresa_institucion_proyecto"],
            "Tipo_Practica" => $_POST["Tipo_Practica"],
            "Representante_legal" => $_POST["Representante_legal"],
            "Tutor_Empresarial" => $_POST["Tutor_Empresarial"],
            "Area_Departamento" => $_POST["Area_Departamento"],
            "Docente" => $_POST["Docente"],
            "Estudiante" => $_POST["Estudiante"],
            "Fecha_Inicio" => $_POST["Fecha_Inicio"],
            "Hora_Asistencia" => $_POST["Hora_Asistencia"],
            "Fecha_Supervicion" => $_POST["Fecha_Supervicion"],
            "Hora_Supervision" => $_POST["Hora_Supervision"],

            "RCAPregunta1" => $_POST["RCAPregunta1"],
            "RCAPregunta2" => $_POST["RCAPregunta2"],
            "RCAPregunta3" => $_POST["RCAPregunta3"],
            "RCAPregunta4" => $_POST["RCAPregunta4"],
            "RCAPregunta5" => $_POST["RCAPregunta5"],
            "Subtotal1" => $_POST["Subtotal1"],
           
            "ACPregunta1" => $_POST["ACPregunta1"],
            "ACPregunta2" => $_POST["ACPregunta2"],
            "ACPregunta3" => $_POST["ACPregunta3"],
            "ACPregunta4" => $_POST["ACPregunta4"],
            "ACPregunta5" => $_POST["ACPregunta5"],
            "Subtotal2" => $_POST["Subtotal2"],

            "HDPregunta1" => $_POST["HDPregunta1"],
            "HDPregunta2" => $_POST["HDPregunta2"],
            "HDPregunta3" => $_POST["HDPregunta3"],
            "HDPregunta4" => $_POST["HDPregunta4"],
            "HDPregunta5" => $_POST["HDPregunta5"],
            "Subtotal3" => $_POST["Subtotal3"],

            "AAPregunta1" => $_POST["AAPregunta1"],
            "AAPregunta2" => $_POST["AAPregunta2"],
            "AAPregunta3" => $_POST["AAPregunta3"],
            "AAPregunta4" => $_POST["AAPregunta4"],
            "AAPregunta5" => $_POST["AAPregunta5"],
            "Subtotal4" => $_POST["Subtotal4"],
            "Total" => $_POST["Total"],
            "Observaciones" => $_POST["Observaciones"],
            "Rcomendaciones" => $_POST["Rcomendaciones"],
            "FechaRegistro" => $_POST["FechaRegistro"],
            "users_id" => $_POST["users_id"]
        );

        $respuesta = $evaluacionPractica->actualizarEvaluacionPractica($id, $datos);
        

    }


if (isset($row['fecha_Inicio'])) $Fecha_Inicio = explode('T', $row['fecha_Inicio'])[0];
if (isset($row['fecha_Supervicion'])) $Fecha_Supervicion = explode('T', $row['fecha_Supervicion'])[0];
if (isset($row['fechaRegistro'])) $FechaRegistro = explode('T', $row['fechaRegistro'])[0];


?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/EvaluacionPract/css/styles.css">
<script src="<?php echo base_url ?>admin/EvaluacionPract/js/script.js" defer></script>
<script>
    const planificacionPorArea = <?= json_encode($evaluacionPractica->obtenerPlanificaciones($student_id)) ?>;
</script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">SUPERVISIÓN Y EVALUACIÓN DE LA PRÁCTICA LABORAL Y/O DE SERVICIO COMUNITARIO</h3>
        <br>
        <h4 class="card-title">1.	DATOS DE LA ORGANIZACIÓN, EMPRESA O INSTITUCIÓN DE CONTRAPARTE Y/O PROYECTO</h4>
    </div>
        
    <div class="card-body">

            <div class="container-fluid">
            <form id="EvaluacionPract_frm" method="post" action="">
            <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Empresa_institucion_proyecto" class="control-label">Empresa/Institución de Contraparte y/o Proyecto:</label>
                                <input type="text" class="form-control form-control-sm rounded-0" name="Empresa_institucion_proyecto" id="Empresa_institucion_proyecto" value="<?php echo $obtenerPlanificacion['tP_Inst_Emp'] ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="Tipo_Practica" class="control-label">Tipo de Práctica:</label>
                                <select name="Tipo_Practica" id="Tipo_Practica" class="form-control form-control-sm rounded-0 select2" required onchange="actualizarCampos()">
                                        <option value="">Seleccione un área</option>
                                            <?php
                                                $areasUnicas = [];
                                                if (isset($obtenerPlanificacion['planificaciones']) && is_array($obtenerPlanificacion['planificaciones'])) {
                                                    foreach ($obtenerPlanificacion['planificaciones'] as $p) {
                                                        // Asegúrate que este campo exista en cada item:
                                                        if (!in_array($p['tP_Area'], $areasUnicas)) {
                                                            $areasUnicas[] = $p['tP_Area'];
                                                            $selected = (isset($row['tipo_Practica']) && $row['tipo_Practica'] === $p['tP_Area']) ? 'selected' : '';
                                                            echo "<option value=\"{$p['tP_Area']}\" $selected>{$p['tP_Area']}</option>";
                                                        }
                                                    }
                                                } else {
                                                    echo "<option value=\"\">No hay planificaciones registradas</option>";
                                                }
                                            ?>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="Representante_legal" class="control-label">Representante Legal y/o Director del Proyecto</label>
                                <input type="text"  name="Representante_legal" id="Representante_legal" value="<?php echo $row['representante_legal'] ?>" class="form-control form-control-sm rounded-0" ></input>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="Tutor_Empresarial" class="control-label">Tutor Empresarial (únicamente para práctica laboral):  </label>
                                <input type="text" name="Tutor_Empresarial" id="Tutor_Empresarial" value="<?php echo $obtenerPlanificacion['tP_Docente_tutor'] ?? '' ?>"  class="form-control form-control-sm rounded-0" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="Area_Departamento" class="control-label">Área/Departamento:  </label>
                                <input type="text" name="Area_Departamento" id="Area_Departamento"  value="<?php echo $row['area_Departamento'] ?>" autofocus class="form-control form-control-sm rounded-0">
                            </div>
                            
                        </div>
                </fieldset>
                <div class="card-header">
                    
                    <h4 class="card-title">2.	DATOS DEL DOCENTE-TUTOR Y DEL ESTUDIANTE</h4>
                </div>
                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="Docente" class="control-label">Docente-Tutor:</label>
                                <input type="text" name="Docente" id="Docente" value="<?php echo $obtenerPlanificacion['tP_Docente_tutor'] ?? '' ?>" class="form-control form-control-sm rounded-0" placeholder="Nombres del docente tutor" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="Estudiante" class="control-label">Estudiante:  </label>
                                <input type="text" name="Estudiante" id="Estudiante" value="<?php echo $row['estudiante'] ?>" autofocus  class="form-control form-control-sm rounded-0">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Fecha_Inicio" class="control-label">Fecha inicio de la práctica:  </label>
                                <input type="date" name="Fecha_Inicio" id="Fecha_Inicio" 
                                    value="<?php echo isset($obtenerPlanificacion['app_Fecha_ini']) ? date('Y-m-d', strtotime($obtenerPlanificacion['app_Fecha_ini'])) : ''; ?>" 
                                    class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Hora_Asistencia" class="control-label">Horario de asistencia:  </label>
                                <input type="text" name="Hora_Asistencia" id="Hora_Asistencia" value="<?php echo $row['hora_Asistencia'] ?>" autofocus value="No Aplica" class="form-control form-control-sm rounded-0">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Fecha_Supervicion" class="control-label">Fecha de supervisión:  </label>
                                <input type="date" name="Fecha_Supervicion" id="Fecha_Supervicion" value="<?php echo $Fecha_Supervicion ?>" autofocus  class="form-control form-control-sm rounded-0">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Hora_Supervision" class="control-label">Hora de supervisión:  </label>
                                <input type="time" name="Hora_Supervision" id="Hora_Supervision" value="<?php echo $row['hora_Supervision'] ?>" autofocus  class="form-control form-control-sm rounded-0">
                            </div>
                            
                        </div>

                </fieldset>
                <fieldset>
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center;" >
                    <tr>
                        <th colspan="5" style="text-align: left;">3. NOMENCLATURA EMPLEADA Y PARÁMETRO DE CALIFICACIÓN</th>
                    </tr>
                    <tr>
                        <td>Excelente <br> E = 5</td>
                        <td>Muy Bueno <br> MB = 4</td>
                        <td>Bueno <br> B = 3</td>
                        <td>Regular <br> R = 2</td>
                        <td>Malo <br> M = 1</td>
                    </tr>
                </table>
                </fieldset>
                <fieldset>
                    <div class="card-header">
                        <h4 class="card-title">4. INFORME TÉCNICO Y CALIFICACIÓN</h4>
                    </div>

                    <div class="row">
                    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                        <tr>
                            <th rowspan="2" style="width: 50%;">Responsabilidad y Cumplimiento de Actividades</th>
                            <th colspan="5">Parámetro de Calificación</th>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="width: 10%;">E = 5</td>
                            <td style="width: 10%;">MB = 4</td>
                            <td style="width: 10%;">B = 3</td>
                            <td style="width: 10%;">R = 2</td>
                            <td style="width: 10%;">M = 1</td>
                        </tr>
                        <tr>
                            <td>Asume con responsabilidad su práctica y acepta sugerencias</td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_5" value="5" <?php echo $row['rcaPregunta1'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_4" value="4" <?php echo $row['rcaPregunta1'] == 4  ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_3" value="3" <?php echo $row['rcaPregunta1'] == 3  ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_2" value="2" <?php echo $row['rcaPregunta1'] == 2  ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_1" value="1" <?php echo $row['rcaPregunta1'] == 1  ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>El cumplimiento del horario acordado en la planificación es</td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_5" value="5" <?php echo $row['rcaPregunta2'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_4" value="4" <?php echo $row['rcaPregunta2'] == 4 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_3" value="3" <?php echo $row['rcaPregunta2'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_2" value="2" <?php echo $row['rcaPregunta2'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_1" value="1" <?php echo $row['rcaPregunta2'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>Trata a las personas con igualdad y sin prejuicios o estereotipos</td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_5" value="5" <?php echo $row['rcaPregunta3'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_4" value="4" <?php echo $row['rcaPregunta3'] == 4 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_3" value="3" <?php echo $row['rcaPregunta3'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_2" value="2" <?php echo $row['rcaPregunta3'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_1" value="1" <?php echo $row['rcaPregunta3'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>Colabora en otras actividades programadas por la institución</td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_5" value="5" <?php echo $row['rcaPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_4" value="4" <?php echo $row['rcaPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_3" value="3" <?php echo $row['rcaPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_2" value="2" <?php echo $row['rcaPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_1" value="1" <?php echo $row['rcaPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>Sobre el uso de terminología, expresión oral y escrita es</td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_5" value="5" <?php echo $row['rcaPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_4" value="4" <?php echo $row['rcaPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_3" value="3" <?php echo $row['rcaPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_2" value="2" <?php echo $row['rcaPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_1" value="1" <?php echo $row['rcaPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td><strong for="Subtotal1">SUBTOTAL 1:</strong></td>
                            <td colspan="5">
                                <input type="text" name="Subtotal1" id="Subtotal1" value="<?= $row['subtotal1'] ?>" readonly>
                                <button type="button" onclick="calcularSubtotal1()" >Calcular Subtotal</button>
                            </td>
                        </tr>
                    </table>

                       
                    </div>
                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                            <tr>
                                <th rowspan="2" style="width: 50%;">Área Cognoscitiva</th>
                                <th colspan="5">Parámetro de Calificación</th>
                            </tr>
                            <tr style="text-align: center;">
                                <td style="width: 10%;">E = 5</td>
                                <td style="width: 10%;">MB = 4</td>
                                <td style="width: 10%;">B = 3</td>
                                <td style="width: 10%;">R = 2</td>
                                <td style="width: 10%;">M = 1</td>
                            </tr>
                            <tr>
                                <td>Capacidad para identificar y definir problemas</td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="5" <?php echo $row['acPregunta1'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="4" <?php echo $row['acPregunta1'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="3" <?php echo $row['acPregunta1'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="2" <?php echo $row['acPregunta1'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="1" <?php echo $row['acPregunta1'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Aplica sus cocimientos para resolver problemas con facilidad</td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="5" <?php echo $row['acPregunta2'] == 5 ? 'checked' : ''; ?> ></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="4" <?php echo $row['acPregunta2'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="3" <?php echo $row['acPregunta2'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="2" <?php echo $row['acPregunta2'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="1" <?php echo $row['acPregunta2'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Capacidad para seleccionar procedimientos válidos</td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="5" <?php echo $row['acPregunta3'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="4" <?php echo $row['acPregunta3'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="3" <?php echo $row['acPregunta3'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="2" <?php echo $row['acPregunta3'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="1" <?php echo $row['acPregunta3'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Capacidad para interpretar y procesar información</td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="5" <?php echo $row['acPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="4" <?php echo $row['acPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="3" <?php echo $row['acPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="2" <?php echo $row['acPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="1" <?php echo $row['acPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Los conocimientos en el área para el uso de métodos y técnicas es</td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="5" <?php echo $row['acPregunta5'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="4" <?php echo $row['acPregunta5'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="3" <?php echo $row['acPregunta5'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="2" <?php echo $row['acPregunta5'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="1" <?php echo $row['acPregunta5'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td><strong for="Subtotal2">SUBTOTAL 2:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal2" id="Subtotal2" value="<?= $row['subtotal2'] ?>" readonly>
                                <button type="button" onclick="calcularSubtotal2()">Calcular Subtotal</button>
                            </td>
                            </tr>
                        </table>
                    </div>

                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                            <tr>
                                <th rowspan="2" style="width: 50%;">Habilidades y Destrezas</th>
                                <th colspan="5">Parámetro de Calificación</th>
                            </tr>
                            <tr style="text-align: center;">
                                <td style="width: 10%;">E = 5</td>
                                <td style="width: 10%;">MB = 4</td>
                                <td style="width: 10%;">B = 3</td>
                                <td style="width: 10%;">R = 2</td>
                                <td style="width: 10%;">M = 1</td>
                            </tr>
                            <tr>
                                <td>Su capacidad de interrelación es</td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="5" <?php echo $row['hdPregunta1'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="4" <?php echo $row['hdPregunta1'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="3" <?php echo $row['hdPregunta1'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="2" <?php echo $row['hdPregunta1'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="1" <?php echo $row['hdPregunta1'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>La puntualidad en la presentación de trabajos es</td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="5" <?php echo $row['hdPregunta2'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="4" <?php echo $row['hdPregunta2'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="3" <?php echo $row['hdPregunta2'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="2" <?php echo $row['hdPregunta2'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="1" <?php echo $row['hdPregunta2'] == 1 ? 'checked' : ''; ?>></td>
                            </tr> 
                            <tr> 
                                <td>Su capacidad de trabajo en equipo es</td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="5" <?php echo $row['hdPregunta3'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="4" <?php echo $row['hdPregunta3'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="3" <?php echo $row['hdPregunta3'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="2" <?php echo $row['hdPregunta3'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="1" <?php echo $row['hdPregunta3'] == 1 ? 'checked' : ''; ?>></td>
                            </tr> 
                            <tr> 
                                <td>La ética en el desempeño de sus labores es</td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="5" <?php echo $row['hdPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="4" <?php echo $row['hdPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="3" <?php echo $row['hdPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="2" <?php echo $row['hdPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="1" <?php echo $row['hdPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                            </tr> 
                            <tr> 
                                <td>La responsabilidad y el cumplimiento de su trabajo es</td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="5" <?php echo $row['hdPregunta5'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="4" <?php echo $row['hdPregunta5'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="3" <?php echo $row['hdPregunta5'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="2" <?php echo $row['hdPregunta5'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="1" <?php echo $row['hdPregunta5'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td><strong for="Subtotal3">SUBTOTAL 3:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal3" id="Subtotal3"   value="<?= $row['subtotal3'] ?>" readonly>
                                <button type="button" onclick="calcularSubtotal3()">Calcular Subtotal</button>
                            </td>
                            </tr>
                        </table>
                    </div>

                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                            <tr>
                                <th rowspan="2" style="width: 50%;">Área Actitudinal</th>
                                <th colspan="5">Parámetro de Calificación</th>
                            </tr>
                            <tr style="text-align: center;">
                                <td style="width: 10%;">E = 5</td>
                                <td style="width: 10%;">MB = 4</td>
                                <td style="width: 10%;">B = 3</td>
                                <td style="width: 10%;">R = 2</td>
                                <td style="width: 10%;">M = 1</td>
                            </tr>

                            <tr>
                                <td>Posee destreza en el manejo de equipos</td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="5" <?php echo $row['aaPregunta1'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="4" <?php echo $row['aaPregunta1'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="3" <?php echo $row['aaPregunta1'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="2" <?php echo $row['aaPregunta1'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="1" <?php echo $row['aaPregunta1'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Precisión y cumplimiento en las labores designadas</td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="5" <?php echo $row['aaPregunta2'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="4" <?php echo $row['aaPregunta2'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="3" <?php echo $row['aaPregunta2'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="2" <?php echo $row['aaPregunta2'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="1" <?php echo $row['aaPregunta2'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Planifica y desarrolla las actividades en forma ordenada</td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="5" <?php echo $row['aaPregunta3'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="4" <?php echo $row['aaPregunta3'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="3" <?php echo $row['aaPregunta3'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="2" <?php echo $row['aaPregunta3'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="1" <?php echo $row['aaPregunta3'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Domina operaciones y procesos tecnológicos</td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="5" <?php echo $row['aaPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="4" <?php echo $row['aaPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="3" <?php echo $row['aaPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="2" <?php echo $row['aaPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="1" <?php echo $row['aaPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Es original y creativo en el desarrollo del trabajo</td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="5" <?php echo $row['aaPregunta5'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="4" <?php echo $row['aaPregunta5'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="3" <?php echo $row['aaPregunta5'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="2" <?php echo $row['aaPregunta5'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="1" <?php echo $row['aaPregunta5'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td><strong for="Subtotal4">SUBTOTAL 4:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal4" id="Subtotal4"  value="<?= $row['subtotal4'] ?>" readonly>
                                <button type="button" onclick="calcularSubtotal4()">Calcular Subtotal</button>
                            </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                           
                            

                            <tr>
                                <td><strong for="Subtotal1">TOTAL (Sobre 100 puntos):</strong></td>
                                <td colspan="5"><input type="text" name="Total" id="Total" value="<?= $row['total'] ?>" readonly>
                                <button type="button" onclick="calcularTotal()" >Calcular Total</button>
                            </td>
                              
                            </tr>
                            
                        </table>
                       
                    </div>
                </fieldset>

              
                <br>
            <fieldset>
                    <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Observaciones" class="control-label">5.	OBSERVACIONES DEL DOCENTE-TUTOR(A):  </label>
                                <textarea rows="4" name="Observaciones" id="Observaciones"  class="form-control form-control-sm rounded-0" ><?php echo $row['observaciones'] ?></textarea>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="Rcomendaciones" class="control-label">6. RECOMENDACIONES DEL DOCENTE-TUTOR(A):  </label>
                                <textarea rows="4" name="Rcomendaciones" id="Rcomendaciones" class="form-control form-control-sm rounded-0" ><?php echo $row['rcomendaciones'] ?></textarea>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="FechaRegistro" class="control-label">Fecha de Término del Convenio:</label>
                                <input type="date" name="FechaRegistro" id="FechaRegistro" value="<?php echo $FechaRegistro ?>"  class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>
                        <input type="hidden" name="users_id" value="<?= $row['users_id'] ?>">


            </fieldset>
            <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Evaluación Practica</button>
                            <a href="./?page=EvaluacionPract" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
            </form>
            </div>
        </div>
</div>


