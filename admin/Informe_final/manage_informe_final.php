<?php
require_once '../config.php';
require_once('../classes/InformeFinal.php');


// Obtener el id de la URL
$user_id = $_settings->userdata('id');
$id = $_GET['id'];

$base_url = "http://localhost:5170/api/InformeFinal"; 
$informeFinal = new InformeFinal($base_url);
$row = $informeFinal->obtenerInformeFinalPorUser($id);
$student_id = $row['users_id'];
$planificacion = $informeFinal->obtenerPlanificacionPorUser($student_id);
$planificacion_id = isset($planificacion['id']) ? $planificacion['id'] : null;

$obtenerPlanificacion = $informeFinal->obtenerPlanificaciones($student_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
    $Aprobaciones = isset($_POST['AprobacionesActuales']) ? json_decode($_POST['AprobacionesActuales'], true) : [];
    $Anexos = isset($_POST['AnexosActuales']) ? json_decode($_POST['AnexosActuales'], true) : [];

    // Procesar Aprobaciones (solo un archivo)
    if (isset($_FILES['Aprobaciones']) && count($_FILES['Aprobaciones']['name']) > 0) {
        $uploadDir = '../uploads/';
        foreach ($_FILES['Aprobaciones']['name'] as $key => $fileName) {
            $fileError = $_FILES['Aprobaciones']['error'][$key];

            if ($fileError == UPLOAD_ERR_OK) {
                $targetFilePath = $uploadDir . basename($fileName);
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
                
                if (in_array(strtolower($fileType), $allowedTypes)) {
                    if (move_uploaded_file($_FILES['Aprobaciones']['tmp_name'][$key], $targetFilePath)) {
                        $Aprobaciones[] = $targetFilePath;
                    }else {
                    echo "<script>
                            Swal.fire({
                                title: 'Error',
                                text: 'Error al mover el archivo.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = './?page=Informe_final';
                            }
                        });
                        </script>
                    ";
                        }
                    } else {
                        echo "<script>
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Tipo de archivo no permitido.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = './?page=Informe_final';
                                    }
                                });
                                </script>
                                ";
                    }
                }
        }
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Deseas continuar con las mismas imagenes cargadas.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=Informe_final';
                    }
                });
            </script>
            ";
    }


    // Procesar Anexos (múltiples archivos)
    if (isset($_FILES['Anexos']) && count($_FILES['Anexos']['name']) > 0) {
        $uploadDir = '../uploads/';
        foreach ($_FILES['Anexos']['name'] as $key => $fileName) {
            $fileError = $_FILES['Anexos']['error'][$key];

            if ($fileError == UPLOAD_ERR_OK) {
                $targetFilePath = $uploadDir . basename($fileName);
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
                
                if (in_array(strtolower($fileType), $allowedTypes)) {
                    if (move_uploaded_file($_FILES['Anexos']['tmp_name'][$key], $targetFilePath)) {
                        $Anexos[] = $targetFilePath;
                    }else {
                    echo "<script>
                            Swal.fire({
                                title: 'Error',
                                text: 'Error al mover el archivo.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = './?page=Informe_final';
                            }
                        });
                        </script>
                    ";
                        }
                    } else {
                        echo "<script>
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Tipo de archivo no permitido.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = './?page=Informe_final';
                                    }
                                });
                                </script>
                                ";
                    }
            }
        }
    }else {
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Deseas continuar con las mismas imagenes cargadas.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=Informe_final';
                    }
                });
            </script>
            ";
    }


    $rutasImagenes = isset($_POST['rutasImagenes']) ? json_decode($_POST['rutasImagenes'], true) : [];

    if (!is_array($rutasImagenes)) {
        $rutasImagenes = [];
    }

    /* $Anexos = array_merge($Anexos, $rutasImagenes);
    $Aprobaciones = array_merge($Aprobaciones, $rutasImagenes);
 */

        $datos = array(
            "id" => $_POST["id"],
            "Tipo_pract" => $_POST["Tipo_pract"] ?? '',
            "Empresa_Institucion_Proyecto" => $_POST["Empresa_Institucion_Proyecto"],
            "Tutor_externo" => $_POST["Tutor_externo"],
            "Estudiante_grupo" => $_POST["Estudiante_grupo"],
            "Docente_tutor" => $_POST["Docente_tutor"],
            "Periodo_practicas" => $_POST["Periodo_practicas"],
            "Introduccion" => $_POST["Introduccion"],
            "Obj_general" => $_POST["Obj_general"],
            "Obj_especifico" => $_POST["Obj_especifico"],
            "Justificacion" => $_POST["Justificacion"],
            "Antecedentes" => $_POST["Antecedentes"],
            "Mision_inst" => $_POST["Mision_inst"],
            "Vision_inst" => $_POST["Vision_inst"],
            "Obj_inst" => $_POST["Obj_inst"],
            "Valores_inst" => $_POST["Valores_inst"],
            "Bene_directos" => $_POST["Bene_directos"],
            "Bene_indirectos" => $_POST["Bene_indirectos"],

            'RA_asignatura' => implode(", ", $_POST['RA_asignatura']),
            'RA_resultado_aprendizaje' => implode("|", $_POST['RA_resultado_aprendizaje']),
            'RA_perfil_egreso' => implode(";", $_POST['RA_perfil_egreso']),

            "Evaluacion_impacto" => $_POST["Evaluacion_impacto"],
            "Detalle_actividades" => $_POST["Detalle_actividades"],
            "AUTOEVL_estudiante" => $_POST["AUTOEVL_estudiante"],


            "AUTOEVL_pregunta1" => $_POST["AUTOEVL_pregunta1"],
            "AUTOEVL_pregunta2" => $_POST["AUTOEVL_pregunta2"],
            "AUTOEVL_pregunta3" => $_POST["AUTOEVL_pregunta3"],
            "AUTOEVL_pregunta4" => $_POST["AUTOEVL_pregunta4"],
            "AUTOEVL_pregunta5" => $_POST["AUTOEVL_pregunta5"],
            "AUTOEVL_pregunta6" => $_POST["AUTOEVL_pregunta6"],
           
            "AUTOEVL_pregunta7" => $_POST["AUTOEVL_pregunta7"],
            "AUTOEVL_pregunta8" => $_POST["AUTOEVL_pregunta8"],
            "AUTOEVL_pregunta9" => $_POST["AUTOEVL_pregunta9"],
            "AUTOEVL_pregunta10" => $_POST["AUTOEVL_pregunta10"],
            "AUTOEVL_pregunta11" => $_POST["AUTOEVL_pregunta11"],
            "AUTOEVL_pregunta12" => $_POST["AUTOEVL_pregunta12"],

            "AUTOEVL_pregunta13" => $_POST["AUTOEVL_pregunta13"],
            "AUTOEVL_pregunta14" => $_POST["AUTOEVL_pregunta14"],
            "AUTOEVL_pregunta15" => $_POST["AUTOEVL_pregunta15"],
            "AUTOEVL_pregunta16" => $_POST["AUTOEVL_pregunta16"],
            "AUTOEVL_pregunta17" => $_POST["AUTOEVL_pregunta17"],
            "AUTOEVL_pregunta18" => $_POST["AUTOEVL_pregunta18"],

            "Conclusiones" => $_POST["Conclusiones"],
            "Recomendaciones" => $_POST["Recomendaciones"],
            "Biografia" => $_POST["Biografia"],
            "Anexos" => implode(", ", $Anexos), 
            "Aprobaciones" => implode(", ", $Aprobaciones),
            "users_id" => $_POST["users_id"],
            "planificacion_id" => $_POST["planificacion_id"]
        );

        $respuesta = $informeFinal->actualizarInformeFinal($id, $datos);
        //var_dump($datos);
  
       
    }





?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<link rel="stylesheet" href="<?php echo base_url ?>admin/Informe_final/css/styles.css">
<script src="<?php echo base_url ?>admin/Informe_final/js/view.js" defer></script>
<script src="<?php echo base_url ?>admin/Informe_final/js/script.js" defer></script>
<script>
    const planificacionPorArea = <?= json_encode($informeFinal->obtenerPlanificaciones($student_id)) ?>;
</script>

<div class="card card-outline card-primary rounded-0 shadow">

    <div class="card-body">
        <div class="container-fluid" id="outprint">
            <h5 class="card-title"> INFORME FINAL DE ACTIVIDADES PRÁCTICA LABORAL Y/O DESERVICIO COMUNITARIO </h3>
            <br>
            <h4 class="card-title"> 1. DATOS INFORMATIVOS </h4>
            <br><br>
            <div class="container-fluid">
            <form id="InformeFinal_frm" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id'] ? $id : '' ?>">

            <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                <tr>
                    <th style="border: 1px solid black;">Tipo de practica:</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">
                        <select name="Tipo_pract" id="Tipo_pract"  class="form-control form-control-sm rounded-0" required>
                            <option value="">Seleccione un área</option>
                                <?php
                                    $areasUnicas = [];
                                        foreach ($obtenerPlanificacion as $m) {
                                            if (!in_array($m['tP_Area'], $areasUnicas)) {
                                                $areasUnicas[] = $m['tP_Area'];
                                                $selected = (isset($row['tipo_pract']) && $row['tipo_pract'] === $m['tP_Area']) ? 'selected' : '';
                                                echo "<option value=\"{$m['tP_Area']}\" $selected>{$m['tP_Area']}</option>";
                                                }
                                            }
                                ?>
                        </select> 
                    </td>
                </tr>
                
                <tr>
                    <th style="border: 1px solid black;">Empresa/Institución de Contraparte y/o Proyecto:</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">
                    <input type="text" name="Empresa_Institucion_Proyecto" id="Empresa_Institucion_Proyecto" value="<?php echo $obtenerPlanificacion['tP_Inst_Emp'] ?? '' ?>" class="form-control form-control-sm rounded-0" required>
                    </td>
                </tr>

                <tr>
                    <th style="border: 1px solid black;">Tutor Externo:</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">
                    <input type="text" name="Tutor_externo" id="Tutor_externo" class="form-control form-control-sm rounded-0" value="<?php echo $obtenerPlanificacion['tP_Docente'] ?? '' ?>" placeholder="N/A">
                    </td>
                </tr>

                <tr>
                    <th style="border: 1px solid black;">Estudiante o (grupo de estudiantes):</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">
                    <input type="text" name="Estudiante_grupo" id="Estudiante_grupo"  value="<?php 
                                    echo nl2br(htmlspecialchars(str_replace(',', "\n", $row['autoevL_estudiante'])));
                                ?>" class="form-control form-control-sm rounded-0">
                    </td>
                </tr>

                <tr>
                    <th style="border: 1px solid black;">Docente-Tutor:</th>
                </tr>
                <tr>
                    <td>
                    <input type="text" name="Docente_tutor" id="Docente_tutor" class="form-control form-control-sm rounded-0" value="<?php echo $obtenerPlanificacion['tP_Docente_tutor'] ?? '' ?>">
                    </td>
                </tr>

                <tr>
                    <th style="border: 1px solid black;">Período de prácticas:</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">
                        <div class="d-flex gap-2">
                            <input type="month" id="fecha_inicio" class="form-control form-control-sm rounded-0">
                            <input type="month" id="fecha_fin" class="form-control form-control-sm rounded-0">
                        </div>
                        <input type="text" name="Periodo_practicas" id="Periodo_practicas" value="<?php echo $row['periodo_practicas']; ?>" class="form-control form-control-sm rounded-0 mt-2" readonly autofocus>
                    </td>
                </tr>
            </table>



            <br><br>
            <fieldset class="border-bottom">
                <div class="row">
                <div class="form-group col-md-12">
                    <label for="Introduccion" class="control-label">2. INTRODUCCIÓN:</label>
                    <textarea rows="20" name="Introduccion" id="Introduccion" class="form-control form-control-sm rounded-0" required>
                    <?php echo $row['introduccion']; ?>
                    </textarea>
                </div>
                </div>
            </fieldset>

                <div class="card-header">
                    
                    <h4 class="card-title">3. OBJETIVOS</h4>
                </div>
                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Obj_general" class="control-label">3.1. OBJETIVO GENERAL:  </label>
                                <textarea rows="4" name="Obj_general" id="Obj_general" value="<?php echo $row['periodo_practicas']; ?>" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['obj_general']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Obj_especifico" class="control-label">3.2. OBJETIVOS ESPECÍFICOS:  </label>
                                <textarea rows="8" name="Obj_especifico" id="Obj_especifico"  class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['obj_especifico']; ?>
                                </textarea>
                            </div>
                        </div>

                </fieldset>

                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Justificacion" class="control-label">4. JUSTIFICACIÓN:  </label>
                                <textarea rows="20" name="Justificacion" id="Justificacion" class="form-control form-control-sm rounded-0"  required>
                                     <?php echo $row['justificacion']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Antecedentes" class="control-label">5. ANTECEDENTES DE LA INSTITUCIÓN:  </label>
                                <textarea rows="20" name="Antecedentes" id="Antecedentes" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['antecedentes']; ?>
                                </textarea>
                            </div>
                        </div>
                </fieldset>

                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Mision_inst" class="control-label">5.1. Misión:  </label>
                                <textarea rows="6" name="Mision_inst" id="Mision_inst" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['mision_inst']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Vision_inst" class="control-label">5.2. Visión:  </label>
                                <textarea rows="6" name="Vision_inst" id="Vision_inst" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['vision_inst']; ?>
                                </textarea>
                            </div>
                        </div>
                        <!-- <br><br><br><br><br><br><br><br> -->
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Obj_inst" class="control-label">5.3. Objetivos de la Institución:  </label>
                                <textarea rows="10" name="Obj_inst" id="Obj_inst" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['obj_inst']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Valores_inst" class="control-label">5.4. Valores de la Institución:  </label>
                                <textarea rows="10" name="Valores_inst" id="Valores_inst" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['valores_inst']; ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="card-header">
                    
                            <h4 class="card-title">5.5. Beneficiarios de la UDIPSAI:
                            </h4>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Bene_directos" class="control-label">5.5.1. Directos:  </label>
                                <textarea rows="10" name="Bene_directos" id="Bene_directos" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['bene_directos']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Bene_indirectos" class="control-label">5.5.2. Indirectos:  </label>
                                <textarea rows="10" name="Bene_indirectos" id="Bene_indirectos" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['bene_indirectos']; ?>
                                </textarea>
                            </div>
                        </div>
                </fieldset>

                <fieldset>
                    <div class="card-header">
                        <h4 class="card-title">6. RESULTADOS DE APRENDIZAJE  A  LOS  QUE  CONTRIBUYE   LA   EJECUCIÓN   DE   LA   PRÁCTICA   LABORAL   O   SERVICIO  COMUNITARIO:</h4>
                    </div>
                    
                    <div id="fieldsets-container">
                        <div class="fieldset-container">
                        <button class="add-btn" type="button" onclick="addFieldset()">Agregar Más</button>
                            <?php
                        $asignaturas = explode(", ", $row['rA_asignatura']);  
                        $resultados = explode("|", $row['rA_resultado_aprendizaje']);
                        $perfiles = explode(";", $row['rA_perfil_egreso']);

                        $count = max(count($asignaturas), count($resultados), count($perfiles));

                        // Generar las tablas dinámicamente
                        for ($i = 0; $i < $count; $i++) {
                            echo "<table class='table-block' style='margin-bottom: 20px;'>";
                            echo "<tr><td><b>Asignatura:</b></td></tr>";
                            echo "<tr><td><input type='text' name='RA_asignatura[]' value='" . htmlspecialchars($asignaturas[$i] ?? '') . "' class='form-control form-control-sm rounded-0' required></td></tr>";

                            echo "<tr><td><b>Resultado de aprendizaje:</b></td></tr>";
                            echo "<tr><td><input type='text' name='RA_resultado_aprendizaje[]' value='" . htmlspecialchars($resultados[$i] ?? '') . "' class='form-control form-control-sm rounded-0' required></td></tr>";

                            echo "<tr><td><b>Perfil de egreso:</b></td></tr>";
                            echo "<tr><td><input type='text' name='RA_perfil_egreso[]' value='" . htmlspecialchars($perfiles[$i] ?? '') . "' class='form-control form-control-sm rounded-0' required></td></tr>";
                            echo "</table>"; 
                            
                        }
                        ?>                    
                    <button class="remove-btn"  type="button" onclick="removeFieldset(this)">Quitar</button>
                        </div>
                    </div>
                    
                   


                </fieldset>
                
                <fieldset class="border-bottom">
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Evaluacion_impacto" class="control-label">7. EVALUACIÓN DE IMPACTO EN LOS RESULTADOS DE APRENDIZAJE:  </label>
                                <textarea rows="8" name="Evaluacion_impacto" id="Evaluacion_impacto"  class="form-control form-control-sm rounded-0"  required>
                                     <?php echo $row['evaluacion_impacto']; ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Detalle_actividades" class="control-label"> 8. DETALLE DE LAS ACTIVIDADES REALIZADAS:  </label>
                                
                                <textarea rows="20" name="Detalle_actividades" id="Detalle_actividades"  class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['detalle_actividades']; ?>
                                </textarea>
                            </div>
                        </div>
                        
                </fieldset>


                <fieldset>
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center;" >
                    <tr>
                        <th colspan="5" style="text-align: left;"> 9. AUTOEVALUACIÓN DEL ESTUDIANTE</th>
                    </tr>
                    <tr>
                        <th rowspan="2" style="width: 50%; text-align: left;"> 
                                <div class="form-group col-md-12">
                                    <label for="AUTOEVL_estudiante" class="control-label">Estudiante:  </label>
                                    <input type="text" name="AUTOEVL_estudiante" id="AUTOEVL_estudiante" autofocus value="<?php echo $row['autoevL_estudiante']; ?>"
                                     class="form-control form-control-sm rounded-0" readonly required>
                                </div>
                        </th>
                        <th colspan="5" style="text-align: left;"> Instrucciones: Estimado Estudiante, evalúe sincera y honestamente los indicadores 
                            de desempeño sobre su participación en las prácticas laborales y/o de servicio comunitario, marcando con una X en 
                            el casillero respectivo, que a continuación se detallan:</th>
                    </tr>
                    
                </table>
                </fieldset>
                <fieldset>
                
                    <div class="row">
                    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                        <tr>
                            
                            <th rowspan="2" style="width: 50%;"> INDICADORES DE DESEMPEÑO </th>
                            <th colspan="5">  Nomenclatura empleada  </th>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="width: 10%;">ALTO = 3</td>
                            <td style="width: 10%;">MEDIO = 2</td>
                            <td style="width: 10%;">BAJO = 1</td>
                        </tr>
                        <tr>
                            <td>1. Las prácticas laborales y/o de servicio comunitario aportaron en la
                            consolidación de los conocimientos para la vida profesional</td>
                            <td><input type="radio" name="AUTOEVL_pregunta1" id="AUTOEVL_pregunta1_3" value="3"<?php echo $row['autoevL_pregunta1'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta1" id="AUTOEVL_pregunta1_2" value="2"<?php echo $row['autoevL_pregunta1'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta1" id="AUTOEVL_pregunta1_1" value="1"<?php echo $row['autoevL_pregunta1'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>2. Acepté el horario establecido por la institución receptora</td>
                            <td><input type="radio" name="AUTOEVL_pregunta2" id="AUTOEVL_pregunta2_3" value="3"<?php echo $row['autoevL_pregunta2'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta2" id="AUTOEVL_pregunta2_2" value="2"<?php echo $row['autoevL_pregunta2'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta2" id="AUTOEVL_pregunta2_1" value="1"<?php echo $row['autoevL_pregunta2'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>3. Recibí y puse en práctica la orientación enseñanza aprendizaje por
                            parte del docente tutor.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta3" id="AUTOEVL_pregunta3_3" value="3"<?php echo $row['autoevL_pregunta3'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta3" id="AUTOEVL_pregunta3_2" value="2"<?php echo $row['autoevL_pregunta3'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta3" id="AUTOEVL_pregunta3_1" value="1"<?php echo $row['autoevL_pregunta3'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>4. Participé activa y efectivamente en las actividades grupales e
                            individuales</td>
                            <td><input type="radio" name="AUTOEVL_pregunta4" id="AUTOEVL_pregunta4_3" value="3"<?php echo $row['autoevL_pregunta4'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta4" id="AUTOEVL_pregunta4_2" value="2"<?php echo $row['autoevL_pregunta4'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta4" id="AUTOEVL_pregunta4_1" value="1"<?php echo $row['autoevL_pregunta4'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>5. Fui responsable con las obligaciones y actividades asignadas dentro
                            de mi campo</td>
                            <td><input type="radio" name="AUTOEVL_pregunta5" id="AUTOEVL_pregunta5_3" value="3"<?php echo $row['autoevL_pregunta5'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta5" id="AUTOEVL_pregunta5_2" value="2"<?php echo $row['autoevL_pregunta5'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta5" id="AUTOEVL_pregunta5_1" value="1"<?php echo $row['autoevL_pregunta5'] == 1? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>6. Respeté a las compañeras y compañeros que participaron en las
                            prácticas.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta6" id="AUTOEVL_pregunta6_3" value="3"<?php echo $row['autoevL_pregunta6'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta6" id="AUTOEVL_pregunta6_2" value="2"<?php echo $row['autoevL_pregunta6'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta6" id="AUTOEVL_pregunta6_1" value="1"<?php echo $row['autoevL_pregunta6'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>7. Demostré interés y motivación por intercambiar conocimientos
                            académicos</td>
                            <td><input type="radio" name="AUTOEVL_pregunta7" id="AUTOEVL_pregunta7_3" value="3"<?php echo $row['autoevL_pregunta7'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta7" id="AUTOEVL_pregunta7_2" value="2"<?php echo $row['autoevL_pregunta7'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta7" id="AUTOEVL_pregunta7_1" value="1"<?php echo $row['autoevL_pregunta7'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>8. Acepté las sugerencias del docente tutor: responsabilidad, actitud,
                            interés, etc.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta8" id="AUTOEVL_pregunta8_3" value="3"<?php echo $row['autoevL_pregunta8'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta8" id="AUTOEVL_pregunta8_2" value="2"<?php echo $row['autoevL_pregunta8'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta8" id="AUTOEVL_pregunta8_1" value="1"<?php echo $row['autoevL_pregunta8'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>9. Expuse con argumentos las ideas y conocimientos adquiridos en la
                            Universidad.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta9" id="AUTOEVL_pregunta9_3" value="3"<?php echo $row['autoevL_pregunta9'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta9" id="AUTOEVL_pregunta9_2" value="2"<?php echo $row['autoevL_pregunta9'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta9" id="AUTOEVL_pregunta9_1" value="1"<?php echo $row['autoevL_pregunta9'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>10. Aporté con conocimientos en la solución de casos presentados.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta10" id="AUTOEVL_pregunta10_3" value="3"<?php echo $row['autoevL_pregunta10'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta10" id="AUTOEVL_pregunta10_2" value="2"<?php echo $row['autoevL_pregunta10'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta10" id="AUTOEVL_pregunta10_1" value="1"<?php echo $row['autoevL_pregunta10'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>11. Di solución adecuada a problemas relacionados con las actividades
                            de prácticas.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta11" id="AUTOEVL_pregunta11_3" value="3"<?php echo $row['autoevL_pregunta11'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta11" id="AUTOEVL_pregunta11_2" value="2"<?php echo $row['autoevL_pregunta11'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta11" id="AUTOEVL_pregunta11_1" value="1"<?php echo $row['autoevL_pregunta11'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>12. Comprendí los contenidos y procedimientos presentados.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta12" id="AUTOEVL_pregunta12_3" value="3"<?php echo $row['autoevL_pregunta12'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta12" id="AUTOEVL_pregunta12_2" value="2"<?php echo $row['autoevL_pregunta12'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta12" id="AUTOEVL_pregunta12_1" value="1"<?php echo $row['autoevL_pregunta12'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>13. Desarrollé actividades de trabajo autónomo, cooperativo, entre otros.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta13" id="AUTOEVL_pregunta13_3" value="3"<?php echo $row['autoevL_pregunta13'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta13" id="AUTOEVL_pregunta13_2" value="2"<?php echo $row['autoevL_pregunta13'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta13" id="AUTOEVL_pregunta13_1" value="1"<?php echo $row['autoevL_pregunta13'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>14. Procuré la calidad en los documentos evidenciables.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta14" id="AUTOEVL_pregunta14_3" value="3"<?php echo $row['autoevL_pregunta14'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta14" id="AUTOEVL_pregunta14_2" value="2"<?php echo $row['autoevL_pregunta14'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta14" id="AUTOEVL_pregunta14_1" value="1"<?php echo $row['autoevL_pregunta14'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>15. Ejecuté las actividades de acuerdo con lo planificado.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta15" id="AUTOEVL_pregunta15_3" value="3"<?php echo $row['autoevL_pregunta15'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta15" id="AUTOEVL_pregunta15_2" value="2"<?php echo $row['autoevL_pregunta15'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta15" id="AUTOEVL_pregunta15_1" value="1"<?php echo $row['autoevL_pregunta15'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>16. Entregué a tiempo los informes para su validación.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta16" id="AUTOEVL_pregunta16_3" value="3"<?php echo $row['autoevL_pregunta16'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta16" id="AUTOEVL_pregunta16_2" value="2"<?php echo $row['autoevL_pregunta16'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta16" id="AUTOEVL_pregunta16_1" value="1"<?php echo $row['autoevL_pregunta16'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>17. Cumplí con las horas asignadas de prácticas laborales y/o de servicio comunitario.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta17" id="AUTOEVL_pregunta17_3" value="3"<?php echo $row['autoevL_pregunta17'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta17" id="AUTOEVL_pregunta17_2" value="2"<?php echo $row['autoevL_pregunta17'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta17" id="AUTOEVL_pregunta17_1" value="1"<?php echo $row['autoevL_pregunta17'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        <tr>
                            <td>18. Considero que la formación académica que recibí en la Universidad mesirvió para 
                                realizar las prácticas laborales y/o de servicio comunitario.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta18" id="AUTOEVL_pregunta18_3" value="3"<?php echo $row['autoevL_pregunta18'] == 3 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta18" id="AUTOEVL_pregunta18_2" value="2"<?php echo $row['autoevL_pregunta18'] == 2 ? 'checked' : ''; ?> required></td>
                            <td><input type="radio" name="AUTOEVL_pregunta18" id="AUTOEVL_pregunta18_1" value="1"<?php echo $row['autoevL_pregunta18'] == 1 ? 'checked' : ''; ?> required></td>
                        </tr>
                        
                    </table>
                    </div>
                </fieldset>

              
                <br>
            <fieldset>
                    <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Conclusiones" class="control-label">10. CONCLUSIONES:  </label>
                                <textarea rows="10" name="Conclusiones" id="Conclusiones" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['conclusiones']; ?>
                                </textarea>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="Recomendaciones" class="control-label">11. RECOMENDACIONES:  </label>
                                <textarea rows="10" name="Recomendaciones" id="Recomendaciones" class="form-control form-control-sm rounded-0" required>
                                    <?php echo $row['recomendaciones']; ?>
                                </textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="Biografia" class="control-label">12. BIBLIOGRAFÍA: </label>
                                <textarea rows="10" name="Biografia" id="Biografia" class="form-control form-control-sm rounded-0" required>
                                    <?php echo $row['biografia']; ?>
                                </textarea>
                            </div>
                        </div>


            </fieldset>

            <fieldset>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="Anexos" class="control-label">13. ANEXOS (múltiples archivos):</label>
                        <h6>Carga todas las imágenes de las actividades que servirán como anexos</h6>
                        
                        <input type="file" name="Anexos[]" id="Anexos" class="form-control form-control-sm rounded-0" multiple onchange="previsualizarAnexosImagenes()">
                        
                        <br>
                        
                        <h6>Imágenes cargadas anteriormente:</h6>
                        <div id="imagenesGuardadas">
                            <?php
                            $imagenesAnexos = explode(',', $row['anexos']);
                            
                            foreach ($imagenesAnexos as $imagen) {
                                echo "<img class='img-logo-empresa' src='" . $imagen . "' alt='Anexo imagen' style='max-width: 700px; max-height: 700px; margin: auto;'>";
                            }
                            ?>
                        </div>
                        
                        <div id="previsualizacion"></div>
                        <input type="hidden" name="AnexosActuales" value='<?= json_encode($imagenesAnexos) ?>'>

                    </div>



                        
                        <div class="form-group col-md-12">
                            <label for="Aprobaciones" class="control-label">14. APROBACIONES: </label>
                            <input type="file" name="Aprobaciones[]" id="Aprobaciones" class="form-control form-control-sm rounded-0" multiple onchange="previsualizarAprobacionesImagenes()">
                            <br>
                        
                            <h6>Imágenes cargadas anteriormente:</h6>
                            <div id="imagenesAprobacionesGuardadas">
                                <?php
                                $imagenesAprobaciones = explode(',', $row['aprobaciones']);
                                
                                foreach ($imagenesAprobaciones as $imagen) {
                                    echo "<img class='img-logo-empresa' src='" . $imagen . "' alt='Aprobacion imagen' style='max-width: 700px; max-height: 700px; margin: auto;'>";
                                }
                                ?>
                            </div>
                            
                            <div id="previsualizacionAprobaciones"></div>
                            <input type="hidden" name="AprobacionesActuales" value='<?= json_encode($imagenesAprobaciones) ?>'>
                        </div>
                        

                </div>
                        <input type="hidden" name="users_id" value="<?= $row['users_id'] ?>">
                        <input type="hidden" name="planificacion_id" value="<?php echo $planificacion_id ?>">


            </fieldset>
            <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Informe Final</button>
                            <a href="./?page=Informe_final" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
            </form>
        </div>
      </div>    
    </div>

</div>



