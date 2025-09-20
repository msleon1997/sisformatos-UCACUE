
<?php
require_once '../config.php';
require_once('../classes/ActPract.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$base_url = "http://localhost:5170/api/ActividadesPracticas"; 
$actpract = new ActPract($base_url);


$user_id = $_settings->userdata('id');
$i = 1;
$obtenerMatriculas = $actpract->obtenerMatriculacionPorUser($user_id);
$docenteTutor = $actpract->obtenerDocenteTutor($user_id);
//var_dump($docenteTutor);
$estudiante = $obtenerMatriculas;
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



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $datos = array(
        "App_Tipo_pract" => $_POST["App_Tipo_pract"] ?? '',
        "App_Empresa_Institucion" => $_POST["App_Empresa_Institucion"] ?? '',
        "App_Direccion" => $_POST["App_Direccion"] ?? '',
        "App_Telefono" => $_POST["App_Telefono"] ?? '',
        "App_Email" => $_POST["App_Email"] ?? '',
		"App_Area_dep_proyect" => $_POST["App_Area_dep_proyect"] ?? '',
		"App_Asignatura_Catedra" => $_POST["App_Asignatura_Catedra"] ?? '',
		"App_Tutor_ext" => $_POST["App_Tutor_ext"] ?? '',
		"App_Cargo" => $_POST["App_Cargo"] ?? '',
		"App_Convenio" => $_POST["App_Convenio"] ?? '',
		"App_Fecha_firma_convenio" => $_POST["App_Fecha_firma_convenio"] ?? '',
        "App_Fecha_termino_convenio" => $_POST["App_Fecha_termino_convenio"],
        "App_Nom_est" => implode(", ", $_POST['App_Nom_est']  ?? ''),
        "App_Cedula_est" => implode(", ", $_POST['App_Cedula_est']  ?? ''),
        "App_Celular_est" => implode(", ", $_POST['App_Celular_est']  ?? ''),
        "App_Email_est" => implode(", ", $_POST['App_Email_est']  ?? ''),
        "App_Nombre_doc" => $_POST["App_Nombre_doc"]  ?? '',
        "App_Cedula_doc" => $_POST["App_Cedula_doc"]  ?? '',
        "App_Email_doc" => $_POST["App_Email_doc"]  ?? '',
        "App_Cedula_doc" => $_POST["App_Cedula_doc"]  ?? '',
        "App_Fecha_ini" => $_POST["App_Fecha_ini"]  ?? '',
        "App_Fecha_fin" => $_POST["App_Fecha_fin"]  ?? '',
		"users_id" => $_POST["users_id"]
    );

    // Crear la nueva planificación
    $respuesta = $actpract->crearActPract($datos);

   
}
?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/js/script.js" defer></script>
<script>
    const docentesPorArea = <?= json_encode($actpract->obtenerMatriculacionPorUser($user_id)) ?>;
</script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">PLANIFICACIÓN DE ACTIVIDADES DE LA PRÁCTICA PRE PROFESIONAL DE LOS ESTUDIANTES</h3>
        <br>
        <h5 class="card-title"> 1.	DATOS INFORMATIVOS DEL ORGANISMO, EMPRESA, INSTITUCIÓN DE CONTRAPARTE O PROYECTO</h5>
    </div>
   
    <div class="card-body">
    <?php if ($_settings->userdata('type') == 1): // Usuario tipo 1 (Estudiante) ?>
        <div class="container-fluid">
            <form id="Act_pract_frm" method="post" action="" onsubmit="return validarCedula();">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="App_Tipo_pract" class="control-label">Tipo de Practica:  </label>
                                <select name="App_Tipo_pract" id="App_Tipo_pract" class="form-control form-control-sm rounded-0 select2" required>
                                        <option value="">Seleccione un área</option>
                                            <?php
                                                $matriculas = $actpract->obtenerMatriculacionPorUser($user_id);
                                                $areasUnicas = [];
                                                foreach ($matriculas as $m) {
                                                    if (!in_array($m['area'], $areasUnicas)) {
                                                        $areasUnicas[] = $m['area'];
                                                        $selected = (isset($row['area']) && $row['area'] === $m['area']) ? 'selected' : '';
                                                        echo "<option value=\"{$m['area']}\" $selected>{$m['area']}</option>";
                                                    }
                                                }
                                            ?>
                                    </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Empresa_Institucion" class="control-label">Empresa o Institución de Contraparte:  </label>
                                <input type="text" name="App_Empresa_Institucion" id="App_Empresa_Institucion" value="<?php echo $obtenerMatriculas['nombre_institucion'] ?? '' ?>" placeholder="Ingrese el nombre de la institucion o empresa que esta realizando las practicas"  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Direccion" class="control-label">Dirección:</label>
                                <input type="text" name="App_Direccion" id="App_Direccion" autofocus placeholder="Ingrese la direccion de la empresa o institución"  class="form-control form-control-sm rounded-0" required>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="App_Telefono" class="control-label">Teléfono: </label>
                                <input type="text" name="App_Telefono" id="App_Telefono" autofocus placeholder="Ingrese el teléfono o número de contacto" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="App_Email" class="control-label">E-mail:</label>
                                <input type="text" name="App_Email" id="App_Email" placeholder="Ingrese el correo de la empresa o institución" class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>


                        <div class="row">
                            
                            <div class="form-group col-md-12">
                                <label for="App_Area_dep_proyect" class="control-label">Área/Departamento y/o Proyecto:</label>
                                <input type="text" name="App_Area_dep_proyect" id="App_Area_dep_proyect" placeholder="Ingrese el area o departamento que esta involucrada"  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Asignatura_Catedra" class="control-label">Asignaturas y/o Cátedra Integradora:   </label>
                                <input type="text" name="App_Asignatura_Catedra" id="App_Asignatura_Catedra" placeholder="Agregue las materias que cree que involucran en sus practicas" autofocus  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Tutor_ext" class="control-label">Tutor/a Externo:</label>
                                <input type="text" name="App_Tutor_ext" id="App_Tutor_ext" value="No aplica" autofocus  class="form-control form-control-sm rounded-0" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="App_Cargo" class="control-label">Cargo:</label>
                                <input type="text" name="App_Cargo" id="App_Cargo" value="No aplica" autofocus class="form-control form-control-sm rounded-0" readonly >
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
                                    <option value="Convenio Marco">Convenio Marco</option>
                                    <option value="Convenio Específico">Convenio Específico</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="App_Fecha_firma_convenio" class="control-label">Fecha de Firma Convenio:</label>
                                <input type="date" name="App_Fecha_firma_convenio" id="App_Fecha_firma_convenio"  class="form-control form-control-sm rounded-0" required>
                            </div>
                           
                            
                            <div class="form-group col-md-4">
                                <label for="App_Fecha_termino_convenio" class="control-label">Fecha de Término del Convenio:</label>
                                <input type="date" name="App_Fecha_termino_convenio" id="App_Fecha_termino_convenio"  class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>


                    

                        <h5 class="card-title">3.	DATOS DE LOS ESTUDIANTES</h5>
                        <br><br>  
                        <div id="fieldsets-container">
                        <div class="fieldset-container">
                        <button class="add-btn" type="button" onclick="addFieldset()">Agregar Más</button>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Nombres:</th>
                                    <td colspan="2" style="width: 75%;"><input type="text" name="App_Nom_est[]" class="form-control"  value="<?php echo htmlspecialchars( $primerEstudiante['firstname_est'] ." ". $primerEstudiante['lastname_est']) ?? ''; ?>" readonly></td>
                                </tr>
                                <tr>
                                    <th>Nº de cédula</th>
                                    <th>Nº celular</th>
                                    <th>E-mail</th>
                           
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="App_Cedula_est[]" class="form-control" maxlength="10"  value="<?php echo htmlspecialchars ($primerEstudiante['cedula_est']) ?? ''; ?>" readonly ></td>
                                    <td><input type="text" name="App_Celular_est[]" class="form-control"  value="<?php echo htmlspecialchars ($primerEstudiante['telefono'] )?? ''; ?>" readonly></td>
                                    <td><input type="text" name="App_Email_est[]" class="form-control"  value="<?php echo  htmlspecialchars ($primerEstudiante['email_est']) ?? ''; ?>" readonly></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                            <button class="remove-btn"  type="button" onclick="removeFieldset(this)">Quitar</button>
                        
                        </div>
                    </div>

                        <h5 class="card-title">4.	DATOS DEL DOCENTE-TUTOR</h5>
                        <br><br>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="App_Nombre_doc" class="control-label">Nombre:</label>
                                    <select name="App_Nombre_doc" id="App_Nombre_doc" class="form-control form-control-sm rounded-0 select2" required>
                                        <option value="">Seleccione el docente tutor de sus prácticas</option>
                                        <?php
                                        $docentesTutores = $actpract->obtenerDocenteTutor($user_id);
                                        $docentesUnicos = [];

                                        foreach ($docentesTutores as $d) {
                                            $nombreCompleto = trim($d['firstname'] . ' ' . $d['lastname']);

                                            if (!in_array($nombreCompleto, $docentesUnicos)) {
                                                $docentesUnicos[] = $nombreCompleto;

                                                $cedula = htmlspecialchars($d['cedula']);
                                                $email = htmlspecialchars($d['email']);
                                                $selected = ($nombreSeleccionado === $nombreCompleto) ? 'selected' : '';

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
                                <input type="text" name="App_Cedula_doc" id="App_Cedula_doc" value="<?php echo $docenteTutor['cedula'] ?? '' ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="App_Email_doc" class="control-label">E-mail:</label>
                                <input type="text" name="App_Email_doc" id="App_Email_doc" value="<?php echo $docenteTutor['email'] ?? '' ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>

                        <h5 class="card-title">5.	PERÍODO DE DURACIÓN DE LA PRÁCTICA PRE PROFESIONAL</h5>
                        <br><br>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="App_Fecha_ini" class="control-label">Fecha de inicio práctica:</label>
                                <input type="date" name="App_Fecha_ini" id="App_Fecha_ini"  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="App_Fecha_fin" class="control-label">Fecha de finalización de práctica:</label>
                                <input type="date" name="App_Fecha_fin" id="App_Fecha_fin"  class="form-control form-control-sm rounded-0" required>
                            </div>
                            <input type="hidden" name="users_id" value="<?php echo htmlspecialchars ($_settings->userdata('id'))?>">
                        </div>
                        </fieldset>
                        <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Actividades Practicas</button>
                            <a href="./?page=ActPract" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
            </form>
        </div>
        </div>
        <?php endif;?>
                <div>
                    <?php if ($_settings->userdata('type') == 2): ?>
                    <div class="card-header">
                        <label>Buscar por estudiante</label>
                        
                            <!-- Campo de búsqueda -->
                            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por Cedula, estudiante, docente o tipo de proyecto, etc.">
                    </div>

                    <!-- filtrar por tipo de practica -->
                    <div class="card-header">
                        <label for="practicaSelect">Filtrar por tipo de práctica:</label>
                        <select id="practicaSelect" class="form-control">
                            <option value="">Todas las prácticas</option>
                            <?php foreach ($practicas as $practica): ?>
                                <option value="<?php echo htmlspecialchars ($practica); ?>"><?php echo htmlspecialchars ($practica); ?></option>
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
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="25%">
                        <col width="25%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                        <col width="50%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th class="col-1">Empresa o Institución</th>
                            <th class="col-1">Tipo de práctica</th>
                           
                            <th class="col-5">Área/Departamento y/o Proyecto</th>
                            <th class="col-6">Asignaturas y/o Cátedra Integradora</th>
                            <th class="col-8">Tutor/a Externo</th>
                            <th class="col-9">Cargo</th>
            
                            <th class="col-15">Nombres del estudiante</th>
                            <th class="col-15">Nº de cédula</th>
                            
                            <th class="col-15">Nombres del docente </th>
                            
                            <th class="col-15">Fecha de inicio práctica</th>
                            <th class="col-15">Fecha de finalización de práctica</th>
                            <th class="col-15">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/ActividadesPracticas/detailsByUser"; 
                        $base_urlDoc = "http://localhost:5170/api/ActividadesPracticas"; 
                        $actpract = new ActPract($base_url);
                        $actpractDoc = new ActPract($base_urlDoc);
                        $user_type = $_settings->userdata('type');
                        // Obtener el ID del usuario actualmente logueado

                         $user_id = $_settings->userdata('id');
                         if ($user_type == 1) {
                            $qry = $actpract->obtenerActPractPorUser($user_id);
                        } else if ($user_type == 2) {
                            $qry = $actpractDoc->obtenerActPrat();
                        }
                        
                        
                        
                         foreach ($qry as $row) {
                            ?>
                                <tr>
                                  <td class="text-center"><?php echo $i++; ?></td>
                                  <td class="">
                                    <p class=""><?php echo htmlspecialchars ($row['app_Empresa_Institucion']) ?></p>
                                  </td>
                                  <td class="">
                                    <p class=""><?php echo htmlspecialchars ($row['app_Tipo_pract'] )?></p>
                                  </td>
                                    
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['app_Area_dep_proyect']) ?></p>
                                    </td>
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['app_Asignatura_Catedra'] )?></p>
                                    </td>
                                  
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['app_Tutor_ext'] )?></p>
                                    </td>
                                  <td class="">
                                      <p class=""><?php echo htmlspecialchars ($row['app_Cargo'] )?></p>
                                    </td>
                    
                                    <td class="">
                                        <p class="">
                                            <?php 
                                            $nombres = explode(',', $row['app_Nom_est']);
                                            echo isset($nombres[0]) ? htmlspecialchars($nombres[0]) : 'N/A'; 
                                            ?>
                                        </p>
                                    </td>
                                    <td class="">
                                        <p class="">
                                            <?php 
                                            // Obtener la primera cédula
                                            $cedulas = explode(',', $row['app_Cedula_est']);
                                            echo isset($cedulas[0]) ? htmlspecialchars($cedulas[0]) : 'N/A';
                                            ?>
                                        </p>
                                    </td>

                                  
                                  <td class="">
                                      <p class=""><?php echo $row['app_Nombre_doc']?></p>
                                    </td>
                                 
                                <td>
                                    <p><?php echo htmlspecialchars (date("d/m/Y", strtotime($row['app_Fecha_ini']))); ?></p>
                                </td>
                                <td>
                                    <p><?php echo htmlspecialchars (date("d/m/Y", strtotime($row['app_Fecha_fin']))); ?></p>
                                </td>

                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="./?page=ActPract/view_actpract&id=<?php echo htmlspecialchars ($row['id']) ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                            <!-- <a class="dropdown-item view_data" href="./?page=ActPract/CronoActPract/view_crono&id=<?php echo $_settings->userdata('id')?>"><span class="fa fa-calendar text-dark"></span> Ver Cronograma</a> -->
                                            <?php if ($_settings->userdata('type') == 1) : ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item edit_data" href="./?page=ActPract/manage_actpract&id=<?php echo htmlspecialchars ($row['id']) ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_data" href="./?page=ActPract/delete_actpract&id=<?php echo htmlspecialchars ($row['id']) ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
    var rows = document.querySelectorAll('table tbody tr');

    rows.forEach(function (row) {
        var nombrePractica = row.querySelector('td:nth-child(3) p').innerText.toLowerCase().trim();

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