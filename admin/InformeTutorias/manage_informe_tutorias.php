<?php

require_once '../config.php';
require_once('../classes/InformeTutorias.php');


// Obtener el id de la URL
$user_id = $_settings->userdata('id');
$id = $_GET['id'];

$base_url = "http://localhost:5170/api/InformeTutorias"; 
$informeTutorias = new InformeTutorias($base_url);
$row = $informeTutorias->obtenerInformeTutoriasPorUser($id);
$student_id = $row['users_id'];
$planificacion = $informeTutorias->obtenerPlanificacionPorUser($student_id);
$planificacion_id = isset($planificacion['id']) ? $planificacion['id'] : null;
$obtenerPlanActInfo = $informeTutorias->obtenerPlanificacionesActividadesInformes($student_id);




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Anexos = isset($_POST['AnexosActuales']) ? json_decode($_POST['AnexosActuales'], true) : [];

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
                    } else {
                        echo "<script>
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Error al mover el archivo.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = './?page=InformeTutorias';
                                    }
                                });
                            </script>";
                        exit;
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
                                    window.location.href = './?page=InformeTutorias';
                                }
                            });
                        </script>";
                    exit;
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
                        window.location.href = './?page=InformeTutorias';
                    }
                });
            </script>
            ";
    }

    $rutasImagenes = isset($_POST['rutasImagenes']) ? json_decode($_POST['rutasImagenes'], true) : [];
    
    if (!is_array($rutasImagenes)) {
        $rutasImagenes = [];
    }
        $datos = array(
            "id" => $_POST["id"],
            "Docente_tutor" => $_POST["Docente_tutor"],
            "Docente_tutor_est" => $_POST["Docente_tutor_est"],
            "Empresa_proyecto" => $_POST["Empresa_proyecto"],
            "Periodo_practicas" => $_POST["Periodo_practicas"],
            "Carrera_est" => $_POST["Carrera_est"],
            "Area_desarrollo" => $_POST["Area_desarrollo"],
            "Director_carrera" => $_POST["Director_carrera"],
            "Fecha_inicio" => $_POST["Fecha_inicio"],
            "Fecha_fin" => $_POST["Fecha_fin"],

            "Est_cedula" => implode("; ", $_POST['Est_cedula']),
            "Est_apellidos" => implode("; ", $_POST['Est_apellidos']),
            "Est_nombres" => implode("; ", $_POST['Est_nombres']),
            "Est_ciclo" => implode("; ", $_POST['Est_ciclo']),

            "Introduccion" => $_POST["Introduccion"],
            "Descripcion_actividades" => $_POST["Descripcion_actividades"],
            "Conclusion" => $_POST["Conclusion"],
            "Observaciones" => $_POST["Observaciones"],

            "Anexos" => implode("; ", $Anexos), 
            "Unidad_academica" => $_POST["Unidad_academica"],
            "Componente_tematico" => $_POST["Componente_tematico"],

            "Dia" => implode("; ", $_POST['Dia']),
            "Mes" => implode("; ", $_POST['Mes']),
            "Ano" => implode("; ", $_POST['Ano']),
            "Tema_consulta" => implode("; ", $_POST['Tema_consulta']),
            
            "RT_Ciclo" => implode("; ", $_POST['RT_Ciclo']),
            "Modalidad" => implode("; ", $_POST['Modalidad']),
            
           
            "RT_Estudiante" => implode("; ", $_POST['RT_Estudiante']),
            "RT_Cedula_est" => implode("; ", $_POST['RT_Cedula_est']),
   

            "Responsable_docente_tutor" => $_POST["Responsable_docente_tutor"],
            "Responsable_ptt" => $_POST["Responsable_ptt"],
            "Responsable_dic_carrera" => $_POST["Responsable_dic_carrera"],

            "Accion_1" => $_POST["Accion_1"],
            "Accion_2" => $_POST["Accion_2"],
            "Accion_3" => $_POST["Accion_3"],

            "Fecha_aprovacion1" => $_POST["Fecha_aprovacion1"],
            "Fecha_aprovacion2" => $_POST["Fecha_aprovacion2"],
            "Fecha_aprovacion3" => $_POST["Fecha_aprovacion3"],
 
            "Firma_1" => $_POST["Firma_1"] ?? '',
            "Firma_2" => $_POST["Firma_2"] ?? '',
            "Firma_3" => $_POST["Firma_3"] ?? '',

            "users_id" => $_POST["users_id"],
            "planificacion_id" => $_POST["planificacion_id"]
        );

        $respuesta = $informeTutorias->actualizarInformeTutorias($id, $datos);
        //var_dump($datos);
    }

 
    
?>


<!-- Incluir ckeditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<link rel="stylesheet" href="<?php echo base_url ?>admin/InformeTutorias/css/styles.css">
<script src="<?php echo base_url ?>admin/InformeTutorias/js/script.js" defer></script>
<script>
    const datosPorArea = <?= json_encode($obtenerPlanActInfo) ?>;
</script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">INFORME DE TUTORÍA DE PRÁCTICAS LABORALES Y/O. DE SERVICIO COMUNITARIO  </h3>
        <br>
        <h4 class="card-title"> 1. DATOS </h4>
    </div>
    <div class="card-body">
       
            <div class="container-fluid">
            <form id="InformeTutorias_frm" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id'] ? $id : '' ?>">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="Docente_tutor" class="control-label">Nombres Docente Tutor/a:  </label>
                                <input type="text" name="Docente_tutor" id="Docente_tutor" value="<?php echo $obtenerPlanActInfo['docente_tutor'] ?? '' ?>" class="form-control form-control-sm rounded-0" readonly required>
                                <br>
                                <label for="Docente_tutor_est" class="control-label">Nombres del Docente Tutor/a Externo:  </label>
                                <input type="text" name="Docente_tutor_est" id="Docente_tutor_est" autofocus value="<?php echo $obtenerPlanActInfo['tutor_externo'] ?? '' ?>"  class="form-control form-control-sm rounded-0" readonly required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Empresa_proyecto" class="control-label">Empresa/Organización y/o Proyecto:</label>
                                <input type="text" name="Empresa_proyecto" id="Empresa_proyecto"  value="<?php echo $obtenerPlanActInfo['tP_Inst_Emp'] ?? '' ?>"  class="form-control form-control-sm rounded-0" readonly required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Periodo_practicas" class="control-label">Periodo de Prácticas: </label>
                                <input type="text" name="Periodo_practicas" id="Periodo_practicas" autofocus value="<?php echo $obtenerPlanActInfo['periodo_practicas'] ?? '' ?>" class="form-control form-control-sm rounded-0" readonly required>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="Carrera_est" class="control-label">Carrera:  </label>
                                <input type="text" name="Carrera_est" id="Carrera_est" autofocus value="<?php echo $obtenerPlanActInfo['tP_Carrera'] ?? '' ?>" class="form-control form-control-sm rounded-0" readonly required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Area_desarrollo" class="control-label">Área de desarrollo de Prácticas:</label>
                                <select name="Area_desarrollo" id="Area_desarrollo" class="form-control form-control-sm rounded-0 select2" required onchange="actualizarCampos()">
                                        <option value="">Seleccione un área</option>
                                            <?php
                                                $areasUnicas = [];
                                                if (isset($obtenerPlanActInfo['planificaciones']) && is_array($obtenerPlanActInfo['planificaciones'])) {
                                                    foreach ($obtenerPlanActInfo['planificaciones'] as $p) {
                                                        if (!in_array($p['tP_Area'], $areasUnicas)) {
                                                            $areasUnicas[] = $p['tP_Area'];
                                                            $selected = (isset($row['area_desarrollo']) && $row['area_desarrollo'] === $p['tP_Area']) ? 'selected' : '';
                                                            echo "<option value=\"{$p['tP_Area']}\" $selected>{$p['tP_Area']}</option>";
                                                        }
                                                    }
                                                }
                                            ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Fecha_inicio" class="control-label">Fecha Inicio: </label>
                                <input type="date" name="Fecha_inicio" id="Fecha_inicio" value="<?php echo $obtenerPlanActInfo['app_Fecha_ini'] ?? '' ?>" class="form-control form-control-sm rounded-0" readonly required>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="Director_carrera" class="control-label">Director/a de Carrera:  </label>
                                <input type="text" name="Director_carrera" id="Director_carrera" value="<?php echo $row['director_carrera']; ?>" autofocus  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Institucion" class="control-label">Institucion/Universidad:</label>
                                <input type="text" autofocus value="Universidad Católica de Cuenca" class="form-control form-control-sm rounded-0" >

                            </div>
                            <div class="form-group col-md-4">
                                <label for="Fecha_fin" class="control-label">Fecha Final: </label>
                                <input type="date" name="Fecha_fin" id="Fecha_fin" value="<?php echo $obtenerPlanActInfo['app_Fecha_fin'] ?? '' ?>"  class="form-control form-control-sm rounded-0" readonly required>
                            </div>
                        </div>
                        
                        <h4 class="card-title">2.	DATOS DEL ESTUDIANTE</h4>
                        <br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Cédula</th>
                                        <th class="text-center">Apellidos</th>
                                        <th class="text-center">Nombres</th>
                                        <th class="text-center">Ciclo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr>
                                        <td><input type="text" name="Est_cedula[]" id="Est_cedula" value="<?php echo $obtenerPlanActInfo['cedula_est'] ?? ''  ?>" class="form-control form-control-sm rounded-0" required></td>
                                        <td><input type="text" name="Est_apellidos[]" id="Est_apellidos" value="<?php echo $obtenerPlanActInfo['lastname_est'] ?? '' ?>" class="form-control form-control-sm rounded-0" required></td>
                                        <td><input type="text" name="Est_nombres[]" id="Est_nombres" value="<?php echo $obtenerPlanActInfo['firstname_est'] ?? '' ?>" class="form-control form-control-sm rounded-0" required></td>
                                        <td><input type="text" name="Est_ciclo[]" id="Est_ciclo" value="<?php echo $obtenerPlanActInfo['ciclo'] ?? '' ?>" class="form-control form-control-sm rounded-0" required></td>
                                     </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success" onclick="agregarFila()">Agregar Estudiante</button>
                            <button type="button" class="btn btn-danger" onclick="eliminarFila()">Eliminar Estudiante</button>
                        </div>
                      <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Introduccion" class="control-label">3. Introducción:</label>
                                <h6>Información relevante acorde al entorno de la realización de las prácticas. (Lugar, periodo de Prácticas)</h6>
                                <textarea rows="20" name="Introduccion" id="Introduccion" class="form-control form-control-sm rounded-0" required>
                                <?php echo $row['introduccion']; ?>
                                </textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Descripcion_actividades" class="control-label">4. Descripción de actividades:</label>
                                <h6>Tareas realizadas( incluir los temas de las tutorías dadas ya sea grupal o individual)</h6>
                                <textarea rows="20" name="Descripcion_actividades" id="Descripcion_actividades" class="form-control form-control-sm rounded-0" required>
                                <?php echo $row['descripcion_actividades']; ?>
                                </textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Conclusion" class="control-label">5. Conclusión:</label>
                                <h6>Beneficios adquiridos por parte del estudiante, síntesis de las nuevas competencias adquiridas. Es importante resaltar los beneficios de este período de prácticas en la formación. </h6>
                                <textarea rows="20" name="Conclusion" id="Conclusion" class="form-control form-control-sm rounded-0" required>
                                <?php echo $row['conclusion']; ?>
                                </textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Observaciones" class="control-label">6. Observaciones:</label>
                                <h6>
                                Hechos o Situaciones que se hayan presentado en el transcurso de la realización de las prácticas , no contempladas en  el plan realizado 
                                </h6>
                                <textarea rows="20" name="Observaciones" id="Observaciones-tutorias" class="form-control form-control-sm rounded-0" required>
                                <?php echo $row['observaciones']; ?>
                                </textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            

                        <div class="form-group col-md-12">
                            <label for="Anexos" class="control-label">13. ANEXOS (múltiples archivos):</label>
                            <h6>(fotografías,) y bibliografía( obligatorio) de libros y artículos mencionados en el informe, que hayan sido 
                                        utilizados por el docente tutor y el alumno, anexar  el certificado de la Empresa / Organización y /o  
                                        de finalización de prácticas</h6>
                            <input type="file" name="Anexos[]" id="Anexos" class="form-control form-control-sm rounded-0" multiple onchange="previsualizarAnexosImagenes()">
                            
                            <br>
                            
                            <h6>Imágenes cargadas anteriormente:</h6>
                            <div id="imagenesGuardadas">
                                <?php
                                $imagenesAnexos = explode(';', $row['anexos']);
                                
                                foreach ($imagenesAnexos as $imagen) {
                                    echo "<img class='img-logo-empresa' src='" . $imagen . "' alt='Anexo imagen' style='max-width: 100%; margin: auto; width: 100%; display: block;'>";
                                }
                                ?>
                            </div>
                        
                         <div id="previsualizacion"></div>
                            <input type="hidden" name="AnexosActuales" value='<?= json_encode($imagenesAnexos) ?>'>
                        </div>
                        </fieldset>
                        <br>
                        
                        

                        <fieldset>
                            <div class="card-header">
                                <h3 class="card-title">8. REGISTRO DE TUTORÍAS DE PRÁCTICAS LABORAL Y/O DE SERVICIO COMUNITARIO</h3>
                            </div>
                            <table border="1" width="100%" cellspacing="0" cellpadding="8">
                                <tr>
                                <td><strong>UNIDAD ACADÉMICA DE:</strong></td>
                                <td colspan="3">
                                    <input type="text" name="Unidad_academica" id="Unidad_academica" value="<?php echo $row['unidad_academica']; ?>" class="form-control form-control-sm rounded-0">
                                </td>
                                </tr>
                                <tr>
                                <td><strong>COMPONENTE TEMÁTICO:</strong></td>
                                <td colspan="3">
                                    <input type="text" name="Componente_tematico" id="Componente_tematico" value="<?php echo $row['componente_tematico']; ?>" class="form-control form-control-sm rounded-0">
                                </td>
                                </tr>
                            </table>
                            <div class="table-responsive">
                            <table border="1" width="100%" cellspacing="0" cellpadding="8" class="registro-tutorias">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>FECHA</th>
                                    <th>TEMA DE CONSULTA</th>
                                    <th>NIVEL (CICLO)</th>
                                    <th>MODALIDAD DE TUTORÍA</th>
                                    <th>NOMBRE DEL/LA ESTUDIANTE</th>
                                    <th>NO. DE CÉDULA O PASAPORTE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $dias = isset($row['dia']) ? array_filter(array_map('trim', explode(";", $row['dia']))) : [];
                                    $meses = isset($row['mes']) ? array_filter(array_map('trim', explode(";",  $row['mes']))) : [];
                                    $anos = isset($row['ano']) ? array_filter(array_map('trim', explode(";",  $row['ano']))) : [];
                                    $temas = isset($row['tema_consulta']) ? array_filter(array_map('trim', explode(";", $row['tema_consulta']))) : [];
                                    $ciclos = isset($row['rT_Ciclo']) ? array_filter(array_map('trim', explode(";", $row['rT_Ciclo']))) : [];
                                    $modalidades = isset($row['modalidad']) ? array_filter(array_map('trim', explode(";",  $row['modalidad']))) : [];
                                    $estudiantes = isset($row['rT_Estudiante']) ? array_filter(array_map('trim', explode(";",  $row['rT_Estudiante']))) : [];
                                    $cedulas = isset($row['rT_Cedula_est']) ? array_filter(array_map('trim', explode(";", $row['rT_Cedula_est']))) : [];

                                    $count = max(count($dias), count($meses), count($anos), count($temas), count($ciclos), count($modalidades), count($estudiantes), count($cedulas));

                                    for ($i = 0; $i < $count; $i++) {  
                                        echo "<tr>";
                                        echo "<td>" . ($i + 1) . "</td>";
                                        echo "<td>";
                                        echo "<input type='text' name='Dia[]' placeholder='Día' value='" . htmlspecialchars($dias[$i] ?? '') . "' class='form-control form-control-sm rounded-0' style='width: 30%; display: inline;'>";
                                        echo "<input type='text' name='Mes[]' placeholder='Mes' value='" . htmlspecialchars($meses[$i] ?? '') . "' class='form-control form-control-sm rounded-0' style='width: 30%; display: inline;'>";
                                        echo "<input type='text' name='Ano[]' placeholder='Año' value='" . htmlspecialchars($anos[$i] ?? '') . "' class='form-control form-control-sm rounded-0' style='width: 30%; display: inline;'>";
                                        echo "</td>";
                                        echo "<td><input type='text' name='Tema_consulta[]' value='" . htmlspecialchars($temas[$i] ?? '') . "' class='form-control form-control-sm rounded-0'></td>";
                                        echo "<td><input type='text' name='RT_Ciclo[]' value='" . htmlspecialchars($ciclos[$i] ?? '') . "' class='form-control form-control-sm rounded-0'></td>";
                                        echo "<td><select name='Modalidad[]' class='form-control form-control-sm rounded-0' required>";
                                        $modalidad_actual = $modalidades[$i] ?? '';
                                        echo "<option value='Individual'" . ($modalidad_actual == 'Individual' ? ' selected' : '') . ">Individual</option>";
                                        echo "<option value='Grupal'" . ($modalidad_actual == 'Grupal' ? ' selected' : '') . ">Grupal</option>";
                                        echo "<option value='Externa'" . ($modalidad_actual == 'Externa' ? ' selected' : '') . ">Externa</option>";
                                        echo "</select></td>";
                                        echo "<td><input type='text' name='RT_Estudiante[]' value='" . htmlspecialchars($estudiantes[$i] ?? '') . "' class='form-control form-control-sm rounded-0'></td>";
                                        echo "<td><input type='text' name='RT_Cedula_est[]' value='" . htmlspecialchars($cedulas[$i] ?? '') . "' class='form-control form-control-sm rounded-0'></td>";
                                        echo "</tr>";
                                    }
                                    ?>


                                <tr>
                                   
                                </tbody>
                            </table>
                            <br>
                            <button type="button" class="btn btn-success" onclick="agregarRegistro()">Agregar Registro</button>
                            <button type="button" class="btn btn-danger" onclick="eliminarRegistro()">Eliminar Registro</button>
                            </div>
                            </fieldset>


                        <br>
                        
                        <fieldset>
                            <div class="card-header text-center">
                                <h3 class="card-title">9. FIRMA Y ACEPTACIÓN</h3>
                            </div>
                            <table border="1" width="100%" cellspacing="0" cellpadding="8">
                                <thead>
                                <tr>
                                    <th>RESPONSABILIDADES</th>
                                    <th>ACCIÓN</th>
                                    <th>FECHA</th>
                                    <th>FIRMA Y SELLO</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                    <label for="Responsable_docente_tutor" class="control-label"><strong>Nombre y Apellido<br>Docente Tutor:</strong></label>
                                    <input type="text" name="Responsable_docente_tutor" id="Responsable_docente_tutor" value="<?php echo $obtenerPlanActInfo['docente_tutor'] ?? '' ?>" class="form-control form-control-sm rounded-0" placeholder="Nombres del docente tutor" readonly required>

                                    </td>
                                    <td>
                                        <input type="text" name="Accion_1" id="Accion_1" value="Realizado por" class="form-control form-control-sm rounded-0">
                                    </td>
                                    <td>
                                        <input type="date" name="Fecha_aprovacion1" id="Fecha_aprovacion1" value="<?php echo isset($row['fecha_aprovacion1']) ? date('Y-m-d', strtotime($row['fecha_aprovacion1'])) : ''; ?>" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                    <td>
                                    ___________________________
                                    </td>
                                </tr>
                                 <tr>
                                    <td>
                                    <label for="Responsable_ptt" class="control-label"><strong>Nombre y Apellido<br>Docente Responsable de PPP de la Carrera:</strong></label>
                                        <input type="text" name="Responsable_ptt" id="Responsable_ptt" value="<?php echo $obtenerPlanActInfo['docente_tutor'] ?? '' ?>" class="form-control form-control-sm rounded-0" placeholder="Nombres del docente tutor" readonly required>
                                    </td>
                                    <td>
                                        <input type="text" name="Accion_2" id="Accion_2" value="Aprobado" class="form-control form-control-sm rounded-0">
                                    </td>
                                    <td>
                                        <input type="date" name="Fecha_aprovacion2" id="Fecha_aprovacion2" value="<?php echo isset($row['fecha_aprovacion2']) ? date('Y-m-d', strtotime($row['fecha_aprovacion2'])) : ''; ?>" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                    <td>
                                    ____________________________
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Responsable_dic_carrera" class="control-label"><strong>Nombre y Apellido<br>Director de Carrera:</strong></label>
                                        <input type="text" name="Responsable_dic_carrera" id="Responsable_dic_carrera" value="<?php echo $row['responsable_dic_carrera'] ?? '' ?>"  class="form-control form-control-sm rounded-0">
                                    </td>
                                    <td>
                                        <input type="text" name="Accion_3" id="Accion_3" value="Revisado" class="form-control form-control-sm rounded-0">
                                    </td>
                                    <td>
                                        <input type="date" name="Fecha_aprovacion3" id="Fecha_aprovacion3" value="<?php echo isset($row['fecha_aprovacion3']) ? date('Y-m-d', strtotime($row['fecha_aprovacion3'])) : ''; ?>" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                    <td>
                                    
                                    _____________________________
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            
                            <input type="hidden" name="users_id" value="<?= $row['users_id'] ?>">
                            <input type="hidden" name="planificacion_id" value="<?php echo $planificacion_id ?>">
                            </fieldset>
                      
                        <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Informe</button>
                            <a href="./?page=InformeTutorias" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>

            </form>  

    </div>

    

</div>


