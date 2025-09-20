<?php

require_once '../config.php';
require_once('../classes/ActPract.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$app_Fecha_firma_convenio = '';
$app_Fecha_termino_convenio = '';
$app_Fecha_ini = '';
$app_Fecha_fin = '';


$user_id = $_settings->userdata('id');
$id = $_GET['id'];
$i = 1;

$base_url = "http://localhost:5170/api/ActividadesPracticas"; 
$ActPract = new ActPract($base_url);

$row = $ActPract->obtenerActPractPorUser($id);
$student_id = $row['users_id'];
$obtenerMatriculas = $ActPract->obtenerMatriculacionPorUser($student_id);
$docenteTutor = $ActPract->obtenerDocenteTutor($student_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $datos = array(
        "id" => $_POST["id"],
        "App_Tipo_pract" => $_POST["App_Tipo_pract"],
        "App_Empresa_Institucion" => $_POST["App_Empresa_Institucion"],
        "App_Direccion" => $_POST["App_Direccion"],
        "App_Telefono" => $_POST["App_Telefono"],
        "App_Email" => $_POST["App_Email"],
        "App_Area_dep_proyect" => $_POST["App_Area_dep_proyect"],
        "App_Asignatura_Catedra" => $_POST["App_Asignatura_Catedra"],
        "App_Tutor_ext" => $_POST["App_Tutor_ext"],
        "App_Cargo" => $_POST["App_Cargo"],
    
        "App_Convenio" => $_POST["App_Convenio"],
        "App_Fecha_firma_convenio" => $_POST["App_Fecha_firma_convenio"],
        "App_Fecha_termino_convenio" => $_POST["App_Fecha_termino_convenio"],

        "App_Nom_est" => implode(", ", $_POST['App_Nom_est']),
        "App_Cedula_est" => implode(", ", $_POST['App_Cedula_est']),
        "App_Celular_est" => implode(", ", $_POST['App_Celular_est']),
        "App_Email_est" => implode(", ", $_POST['App_Email_est']),
        "App_Nombre_doc" => $_POST["App_Nombre_doc"],
        "App_Cedula_doc" => $_POST["App_Cedula_doc"],
        "App_Email_doc" => $_POST["App_Email_doc"],
        "App_Fecha_ini" => $_POST["App_Fecha_ini"],
        "App_Fecha_fin" => $_POST["App_Fecha_fin"],
        "users_id" => $_POST["users_id"]
    );

    $respuesta = $ActPract->actualizarActPract($id, $datos);
    //var_dump($datos);
}

$docentesUnicos = [];
$areasUnicas = [];




if (isset($row['app_Fecha_firma_convenio'])) $app_Fecha_firma_convenio = explode('T', $row['app_Fecha_firma_convenio'])[0];
if (isset($row['app_Fecha_termino_convenio'])) $app_Fecha_termino_convenio = explode('T', $row['app_Fecha_termino_convenio'])[0];
if (isset($row['app_Fecha_ini'])) $app_Fecha_ini = explode('T', $row['app_Fecha_ini'])[0];
if (isset($row['app_Fecha_fin'])) $app_Fecha_fin = explode('T', $row['app_Fecha_fin'])[0];
?>
   


<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/js/script.js" defer></script>
<script>
    const docentesPorArea = <?= json_encode($ActPract->obtenerMatriculacionPorUser($student_id)) ?>;
</script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">PLANIFICACIÓN DE ACTIVIDADES DE LA PRÁCTICA PRE PROFESIONAL DE LOS ESTUDIANTES</h3>
        <br>
        <h5 class="card-title"> 1.	DATOS INFORMATIVOS DEL ORGANISMO, EMPRESA, INSTITUCIÓN DE CONTRAPARTE O PROYECTO</h5>
    </div>
   
    <div class="card-body">

        <div class="container-fluid">
            <div class="container-fluid">

            <form id="Act_pract_frm" method="post" action="" onsubmit="return validarCedula();">
            <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="App_Tipo_pract" class="control-label">Tipo de Practica:  </label>
                                <select name="App_Tipo_pract" id="App_Tipo_pract" class="form-control form-control-sm rounded-0 select2" required>
                                        <option value="">Seleccione un área</option>
                                            <?php
                                                
                                                foreach ($obtenerMatriculas as $p) {
                                                    if (!in_array($p['area'], $areasUnicas)) {
                                                        $areasUnicas[] = $p['area'];
                                                        $selected = (isset($row['app_Tipo_pract']) && $row['app_Tipo_pract'] === $p['area']) ? 'selected' : '';
                                                        echo "<option value=\"{$p['area']}\" $selected>{$p['area']}</option>";
                                                    }
                                                }
                                            ?>
                                    </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Empresa_Institucion" class="control-label">Empresa o Institución de Contraparte:  </label>
                                <input type="text" name="App_Empresa_Institucion" id="App_Empresa_Institucion" value="<?php echo $row['app_Empresa_Institucion'] ?>" autofocus  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Direccion" class="control-label">Dirección:</label>
                                <input type="text" name="App_Direccion" id="App_Direccion" value="<?php echo $row['app_Direccion'] ?>" autofocus  class="form-control form-control-sm rounded-0" required>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="App_Telefono" class="control-label">Teléfono: </label>
                                <input type="text" name="App_Telefono" id="App_Telefono"  value="<?php echo $row['app_Telefono'] ?>" autofocus class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="App_Email" class="control-label">E-mail:</label>
                                <input type="text" name="App_Email" id="App_Email" value="<?php echo $row['app_Email'] ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-12">
                                <label for="App_Area_dep_proyect" class="control-label">Área/Departamento y/o Proyecto:</label>
                                <input type="text" name="App_Area_dep_proyect" id="App_Area_dep_proyect" value="<?php echo $row['app_Area_dep_proyect'] ?>"  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Asignatura_Catedra" class="control-label">Asignaturas y/o Cátedra Integradora:   </label>
                                <input type="text" name="App_Asignatura_Catedra" id="App_Asignatura_Catedra" value="<?php echo $row['app_Asignatura_Catedra'] ?>" autofocus  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Tutor_ext" class="control-label">Tutor/a Externo:</label>
                                <input type="text" name="App_Tutor_ext" id="App_Tutor_ext" value="<?php echo $row['app_Tutor_ext'] ?>" autofocus  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Cargo" class="control-label">Cargo:</label>
                                <input type="text" name="App_Cargo" id="App_Cargo" value="<?php echo $row['app_Cargo'] ?>" autofocus class="form-control form-control-sm rounded-0" required >
                            </div>
                        </div>

                        
                        <hr class="custom-divider">
                        <br>
                        <h5 class="card-title">2.	RELACIÓN ACADÉMICA ENTRE EL ORGANISMO, EMPRESA, INSTITUCIÓN DE CONTRAPARTE O PROYECTO Y LA UCACUE</h5>
                        <br><br>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="App_Convenio" class="control-label">Matienen un:</label>
                                <select name="App_Convenio" id="App_Convenio" class="form-control form-control-sm rounded-0 select2" required>
                                    <option  value="<?php echo $row['app_Convenio'] ?>">Convenio Marco</option>
                                    <option  value="<?php echo $row['app_Convenio'] ?>">Convenio Específico</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                            <label for="App_Fecha_firma_convenio" class="control-label">Fecha de Firma Convenio:</label>
                            <input type="date" name="App_Fecha_firma_convenio" id="App_Fecha_firma_convenio" value="<?php echo $app_Fecha_firma_convenio ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="App_Fecha_termino_convenio" class="control-label">Fecha de Término del Convenio:</label>
                                <input type="date" name="App_Fecha_termino_convenio" id="App_Fecha_termino_convenio" value="<?php echo $app_Fecha_termino_convenio ?>" class="form-control form-control-sm rounded-0" required>
                            </div>

                        </div>

                        <h5 class="card-title">3.	DATOS DEL ESTUDIANTE</h5>
                        <button class="add-btn" type="button" onclick="addFieldset()">Agregar Más</button>
                        <br><br>
                        <div id="fieldsets-container">
                            <?php
                            $nombreEst = isset($row['app_Nom_est']) ? explode(", ", $row['app_Nom_est']) : [];
                            $cedulaEst = isset($row['app_Cedula_est']) ? explode(", ", $row['app_Cedula_est']) : [];
                            $celularEst = isset($row['app_Celular_est']) ? explode(", ", $row['app_Celular_est']) : [];
                            $emailEst = isset($row['app_Email_est']) ? explode(", ", $row['app_Email_est']) : [];

                            for ($i = 0; $i < count($nombreEst); $i++) {
                                ?>
                                <div class="fieldset-container">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th style="width: 25%;">Nombres:</th>
                                                <td colspan="2" style="width: 75%;">
                                                    <input type="text" name="App_Nom_est[]" class="form-control" value="<?php echo $nombreEst[$i]; ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Nº de cédula</th>
                                                <th>Nº celular</th>
                                                <th>E-mail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" name="App_Cedula_est[]" value="<?php echo $cedulaEst[$i]; ?>" class="form-control form-control-sm rounded-0" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="App_Celular_est[]" value="<?php echo $celularEst[$i]; ?>" class="form-control form-control-sm rounded-0" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="App_Email_est[]" value="<?php echo $emailEst[$i]; ?>" class="form-control form-control-sm rounded-0" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button class="remove-btn" type="button" onclick="removeFieldset(this)">Quitar</button>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                      
                        <h5 class="card-title">4.	DATOS DEL DOCENTE-TUTOR</h5>
                        <br><br>
                        <?php $nombreSeleccionado = $row['app_Nombre_doc'] ?? ''; ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="App_Nombre_doc" class="control-label">Nombre Docente:</label>
                                <select name="App_Nombre_doc" id="App_Nombre_doc" class="form-control form-control-sm rounded-0 select2" required>
                                    <option value="">Seleccione el docente tutor de sus prácticas</option>
                                    <?php
                                        foreach ($docenteTutor as $p) {
                                            $nombreCompleto = trim($p['firstname'] . ' ' . $p['lastname']);

                                            if (!in_array($nombreCompleto, $docentesUnicos)) {
                                                $docentesUnicos[] = $nombreCompleto;

                                                $cedula = htmlspecialchars($p['cedula']);
                                                $email = htmlspecialchars($p['email']);
                                                $selected = (trim(strtolower($nombreSeleccionado)) === trim(strtolower($nombreCompleto))) ? 'selected' : '';

                                                echo "<option value=\"" . htmlspecialchars($nombreCompleto) . "\" 
                                                            data-cedula=\"$cedula\" 
                                                            data-email=\"$email\" 
                                                            $selected>" 
                                                    . htmlspecialchars($nombreCompleto) . 
                                                    "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="App_Cedula_doc" class="control-label">Nº de cédula: </label>
                                <input type="text" name="App_Cedula_doc" id="App_Cedula_doc" value="<?php echo htmlspecialchars($row['app_Cedula_doc'] ?? '') ?>" class="form-control form-control-sm rounded-0" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="App_Email_doc" class="control-label">E-mail:</label>
                                <input type="text" name="App_Email_doc" id="App_Email_doc" value="<?php echo htmlspecialchars($row['app_Email_doc'] ?? '') ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>


                        <h5 class="card-title">5.	PERÍODO DE DURACIÓN DE LA PRÁCTICA PRE PROFESIONAL</h5>
                        <br><br>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="App_Fecha_ini" class="control-label">Fecha de inicio práctica:</label>
                                <input type="date" name="App_Fecha_ini" id="App_Fecha_ini" value="<?php echo $app_Fecha_ini ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="App_Fecha_fin" class="control-label">Fecha de finalización de práctica:</label>
                                <input type="date" name="App_Fecha_fin" id="App_Fecha_fin" value="<?php echo $app_Fecha_fin ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <input type="hidden" name="users_id" value="<?= $row['users_id'] ?>">
                        </div>
                        </fieldset>
                        <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Actividades Practicas</button>
                            <a href="./?page=ActPract" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
            </form>
            <br><br>
            
    </div>
</div>
