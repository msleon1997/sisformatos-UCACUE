<?php

require_once '../config.php';
require_once('../classes/InformeTutorias.php');


$base_url = "http://localhost:5170/api/InformeTutorias"; 
$informeTutorias = new InformeTutorias($base_url);

 $user_id = $_settings->userdata('id');
 $i = 1;

 $planificacion = $informeTutorias->obtenerPlanificacionPorUser($user_id);
 $planificacion_id = isset($planificacion['id']) ? $planificacion['id'] : null;
 $obtenerPlanActInfo = $informeTutorias->obtenerPlanificacionesActividadesInformes($user_id);

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
$Anexos = [];
$errors = [];

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
                    $errors[] = "No se pudo mover el archivo: $fileName.";
                }
            } else {
                $errors[] = "El formato del archivo <strong>$fileName</strong> no es válido. Solo se permiten archivos: jpg, jpeg, png, gif.";
            }
        } else {
            $errors[] = "Error al cargar el archivo: $fileName. Código de error: $fileError.";
        }
    }
}

// Mostrar errores
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
}

    $rutasImagenes = isset($_POST['rutasImagenes']) ? json_decode($_POST['rutasImagenes'], true) : [];
    if (!is_array($rutasImagenes)) {
        $rutasImagenes = [];
    }

        $datos = array(
            "Docente_tutor" => $_POST["Docente_tutor"] ?? '',
            "Docente_tutor_est" => $_POST["Docente_tutor_est"] ?? '',
            "Empresa_proyecto" => $_POST["Empresa_proyecto"] ?? '',
            "Periodo_practicas" => $_POST["Periodo_practicas"] ?? '',
            "Carrera_est" => $_POST["Carrera_est"] ?? '',
            "Area_desarrollo" => $_POST["Area_desarrollo"] ?? '',
            "Director_carrera" => $_POST["Director_carrera"] ?? '',
            "Fecha_inicio" => $_POST["Fecha_inicio"] ?? '',
            "Fecha_fin" => $_POST["Fecha_fin"] ?? '',
            "Est_cedula" => implode("; ", $_POST['Est_cedula'] ?? ''),
            "Est_apellidos" => implode("; ", $_POST['Est_apellidos'] ?? ''),
            "Est_nombres" => implode("; ", $_POST['Est_nombres'] ?? ''),
            "Est_ciclo" => implode("; ", $_POST['Est_ciclo'] ?? ''),
            "Introduccion" => $_POST["Introduccion"] ?? '',
            "Descripcion_actividades" => $_POST["Descripcion_actividades"] ?? '',
            "Conclusion" => $_POST["Conclusion"] ?? '',
            "Observaciones" => $_POST["Observaciones"] ?? '',
            "Anexos" => implode("; ", $Anexos), 
            "Unidad_academica" => $_POST['Unidad_academica'] ?? '',
            "Componente_tematico" => $_POST['Componente_tematico'] ?? '',
            "Dia" => implode("; ", $_POST['Dia'] ?? ''),
            "Mes" => implode("; ", $_POST['Mes'] ?? ''),
            "Ano" => implode("; ", $_POST['Ano'] ?? ''),
            "Tema_consulta" => implode("; ", $_POST['Tema_consulta'] ?? ''),
            
            "RT_Ciclo" => implode("; ", $_POST['RT_Ciclo'] ?? ''),
            "Modalidad" => implode("; ", $_POST['Modalidad'] ?? ''),
            
           
            "RT_Estudiante" => implode("; ", $_POST['RT_Estudiante'] ?? ''),
            "RT_Cedula_est" => implode("; ", $_POST['RT_Cedula_est'] ?? ''),
   

            "Responsable_docente_tutor" => $_POST["Responsable_docente_tutor"] ?? '',
            "Responsable_ptt" => $_POST["Responsable_ptt"] ?? '',
            "Responsable_dic_carrera" => $_POST["Responsable_dic_carrera"] ?? '',

            "Accion_1" => $_POST["Accion_1"] ?? '',
            "Accion_2" => $_POST["Accion_2"] ?? '',
            "Accion_3" => $_POST["Accion_3"] ?? '',

            "Fecha_aprovacion1" => $_POST["Fecha_aprovacion1"] ?? '',
            "Fecha_aprovacion2" => $_POST["Fecha_aprovacion2"] ?? '',
            "Fecha_aprovacion3" => $_POST["Fecha_aprovacion3"] ?? '',
 
            "Firma_1" => $_POST["Firma_1"] ?? '',
            "Firma_2" => $_POST["Firma_2"] ?? '',
            "Firma_3" => $_POST["Firma_3"] ?? '',

            "users_id" => $_POST["users_id"],
            "planificacion_id" => $planificacion_id
        );

        $respuesta = $informeTutorias->crearInformeTutorias($datos);
       // var_dump($datos);
    }
    $row = $informeTutorias->obtenerInformeTutoriasPorUser($user_id);

?>


<!-- Incluir ckeditor  -->
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
        <?php if ($_settings->userdata('type') == 1) : ?>
            <div class="container-fluid">
            <form id="InformeTutorias_frm" method="post" action="" enctype="multipart/form-data">

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
                                                            $selected = (isset($row['tP_Area']) && $row['tP_Area'] === $p['tP_Area']) ? 'selected' : '';
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
                                <input type="text" name="Director_carrera" id="Director_carrera" value="Ing. Jaime Rodrigo Segarra Escandón, (PHD)." autofocus  class="form-control form-control-sm rounded-0" required>
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
                                <textarea rows="20" name="Introduccion" id="Introduccion-tutorias" class="form-control form-control-sm rounded-0" required></textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Descripcion_actividades" class="control-label">4. Descripción de actividades:</label>
                                <h6>Tareas realizadas( incluir los temas de las tutorías dadas ya sea grupal o individual)</h6>
                                <textarea rows="20" name="Descripcion_actividades" id="Descripcion_actividades" class="form-control form-control-sm rounded-0" required></textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Conclusion" class="control-label">5. Conclusión:</label>
                                <h6>Beneficios adquiridos por parte del estudiante, síntesis de las nuevas competencias adquiridas. Es importante resaltar los beneficios de este período de prácticas en la formación. </h6>
                                <textarea rows="20" name="Conclusion" id="Conclusion" class="form-control form-control-sm rounded-0" required></textarea>
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
                                <textarea rows="20" name="Observaciones" id="Observaciones-tutorias" class="form-control form-control-sm rounded-0" required></textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            

                            <div class="form-group col-md-12">
                                <label for="Anexos" class="control-label">7. ANEXOS (múltiples archivos):</label>
                                <h6>(fotografías,) y bibliografía( obligatorio) de libros y artículos mencionados en el informe, que hayan sido 
                                    utilizados por el docente tutor y el alumno, anexar  el certificado de la Empresa / Organización y /o  
                                    de finalización de prácticas</h6>
                                <input type="file" name="Anexos[]" id="Anexos" class="form-control form-control-sm rounded-0" multiple onchange="previsualizarAnexosImagenes()">
                                
                                <br>
                                <!-- Área donde se mostrarán las imágenes cargadas -->
                                <div id="previsualizacion"></div>
                                <input type="hidden" id="rutasImagenes" name="rutasImagenes">
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
                                        <input type="text" name="Unidad_academica" id="Unidad_academica" value="UNIDAD ACADÉMICA DE INFORMÁTICA, CIENCIAS DE LA COMPUTACIÓN E INNOVACIÓN TECNOLÓGICA" class="form-control form-control-sm rounded-0">
                                    </td>
                                </tr>
                                <tr>
                                <td><strong>COMPONENTE TEMÁTICO:</strong></td>
                                    <td colspan="3">
                                        
                                        <input type="text" name="Componente_tematico" id="Componente_tematico" placeholder="Ingrese el tema de la tutoria que recibió" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                </tr>
                            </table>

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
                                    <!-- Filas dinámicas se agregarán aquí -->
                                </tbody>
                            </table>
                            <br>
                            <button type="button" class="btn btn-success" onclick="agregarRegistro()">Agregar Registro</button>
                            <button type="button" class="btn btn-danger" onclick="eliminarRegistro()">Eliminar Registro</button>


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
                                    <td><input type="text" name="Accion_1" id="Accion_1" value="Realizado por" class="form-control form-control-sm rounded-0"></td>
                                    <td>
                                    <input type="date" name="Fecha_aprovacion1" id="Fecha_aprovacion1" class="form-control form-control-sm rounded-0" required>
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
                                    <td><input type="text" name="Accion_2" id="Accion_2" value="Aprobado" class="form-control form-control-sm rounded-0"></td>
                                    <td>
                                    <input type="date" name="Fecha_aprovacion2" id="Fecha_aprovacion2" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                    <td>
                                    ____________________________
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <label for="Responsable_dic_carrera" class="control-label"><strong>Nombre y Apellido<br>Director de Carrera:</strong></label>
                                    <input type="text" name="Responsable_dic_carrera" id="Responsable_dic_carrera" value="Ing. Jaime Rodrigo Segarra Escandón, (PHD)." class="form-control form-control-sm rounded-0">
                                    </td>
                                    <td><input type="text" name="Accion_3" id="Accion_3" value="Revisado" class="form-control form-control-sm rounded-0"></td>
                                    <td>
                                    <input type="date" name="Fecha_aprovacion3" id="Fecha_aprovacion3" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                    <td>
                                    
                                    _____________________________
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                            <input type="hidden" name="planificacion_id" value="<?php echo $planificacion_id ?>">
                            </fieldset>
                      
                        <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Informe</button>
                            <a href="./?page=InformeTutorias" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>

            </form>  

    </div>
    <?php endif;?>

    <?php if ($_settings->userdata('type') == 2): ?>

            <div class="card-header">
                <label>Buscar por estudiante</label>
                    <!-- Campo de búsqueda -->
                     <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por Cédula, Estudiante, Docente, Empresa o Institucion">
                <label for="practicaSelect">Filtrar por tipo de práctica:</label>
                <select id="practicaSelect" class="form-control">
                    <option value="">Todas las prácticas</option>
                    <?php foreach ($practicas as $practica): ?>
                        <option value="<?php echo $practica; ?>"><?php echo $practica; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    </div>
    <?php endif; ?>
    <div class="card-body">
    <div class="container-fluid">
    <div class="tabla-scrollable">
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="2%">
                        <col width="9%">
                        <col width="9%">
                        <col width="9%">
                        <col width="9%">
                        <col width="10%">
                        <col width="10%">
                        <col width="5%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th>Tipo de Práctica</th>
                            <th>Cedula Estudiantes</th>
                            <th>Nombres Estudiantes</th>
                            <th>Apellidos Estudiantes</th>
                            <th>Docente Tutor</th>
                            <th>Empresa / Institución</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/InformeTutorias/detailsByUser"; 
                        $base_urlDoc = "http://localhost:5170/api/InformeTutorias"; 
                        $informeTutorias = new InformeTutorias($base_url);
                        $informeTutoriasDoc = new InformeTutorias($base_urlDoc);
                        $user_type = $_settings->userdata('type');
                         $user_id = $_settings->userdata('id');
                         if ($user_type == 1) {
                            $qry = $informeTutorias->obtenerInformeTutoriasPorUser($user_id);
                        } else if ($user_type == 2) {
                            $qry = $informeTutoriasDoc->obtenerInformeTutorias();
                        }
                        
                        
                        
                         foreach ($qry as $row) {
                            ?>
                                <tr>
                                  <td class="text-center"><?php echo $i++; ?></td>
                                  <td class="">
                                        <p class=""><?php echo $row['area_desarrollo'] ?></p>
                                    </td>
                                    <td class="">
                                      <p class="">
                                        <ul>
                                            <?php 
                                                $cedulas = explode(';', $row['est_cedula']);
                                                foreach ($cedulas as $cedula) {
                                                    echo "<li>" . htmlspecialchars($cedula) . "</li>"; 
                                                }
                                            ?>
                                        </ul>
                                    </td>

                                  <td class="">
                                      <p class="">
                                        <ul>
                                            <?php 
                                                $nombresEst = explode(';', $row['est_nombres']);
                                                foreach ($nombresEst as $nomnbreEst) {
                                                    echo "<li>" . htmlspecialchars($nomnbreEst) . "</li>"; 
                                                }
                                            ?>
                                        </ul>
                                    </td>

                                  <td class="">
                                      <p class="">
                                        <ul>
                                            <?php 
                                                $apellidosEst = explode(';', $row['est_apellidos']);
                                                foreach ($apellidosEst as $apellidoEst) {
                                                    echo "<li>" . htmlspecialchars($apellidoEst) . "</li>";
                                                }
                                            ?>
                                        </ul>
                                    </td>
                              
                                
                                
                                  <td class="">
                                        <p class=""><?php echo $row['docente_tutor'] ?></p>
                                    </td>
                                    
                                  <td class="">
                                      <p class=""><?php echo $row['empresa_proyecto'] ?></p>
                                    </td>

                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="./?page=InformeTutorias/view_informe_tutorias&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                            <?php if ($_settings->userdata('type') == 1) : ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item edit_data" href="./?page=InformeTutorias/manage_informe_tutorias&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_data" href="./?page=InformeTutorias/delete_informe_tutorias&id=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
     document.getElementById('practicaSelect').addEventListener('change', filtrarTabla);

    function filtrarTabla() {
        var practicaSeleccionada = document.getElementById('practicaSelect').value.toLowerCase().trim();
        var rows = document.querySelectorAll('.table tbody tr');

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