<?php
require_once '../config.php';
require_once('../classes/Matriculacion.php');

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM `matriculacion` WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $res = $result->fetch_array(MYSQLI_ASSOC);
        foreach ($res as $k => $v) {
            $$k = $v;
        }
    }
}


// Consulta SQL para estudiantes
$stmt = $conn->prepare("SELECT *, CONCAT(firstname, ' ', lastname) AS fullname 
                        FROM users 
                        WHERE id = ? 
                        ORDER BY fullname ASC");
$stmt->bind_param("i", $id);
$stmt->execute();
$estudiante = $stmt->get_result()->fetch_assoc();



?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/students/styles.css">
<script src="<?php echo base_url ?>admin/students/script.js" defer></script>

<div class="content py-3">
    <div class="card card-outline card-primary shadow rounded-0">
        <div class="card-header">
            <h3 class="card-title"><b>Actualizar Información Estudiante Matriculación Prácticas Pre-profesionales, Internas y Vinculación</b></h3>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <form id="matriculacion_frm_update" method="post" action="">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <input type="hidden" name="users_id" value="<?php echo isset($_GET['student_id']) ? $_GET['student_id'] : '' ?>">
                    <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="roll" class="control-label">Ingrese su carrera: </label>
                                <input type="text" name="carrera"  value="<?= isset($carrera) ? $carrera : "" ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="area" class="control-label">Area:</label>
                                <select name="area" id="area" value="<?= isset($area) ? $area : "" ?>" class="form-control form-control-sm rounded-0 select2" required>
                                    <option <?= isset($area) && $area == 'Práctica Laboral' ? 'selected' : '' ?>>Práctica Laboral</option>
                                    <option <?= isset($area) && $area == 'Práctica Servicio Comunitario' ? 'selected' : '' ?>>Práctica Servicio Comunitario</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="ciclo" class="control-label">Ciclo:</label>
                                <input type="text" name="ciclo" id="ciclo" value="<?= isset($ciclo) ? $ciclo : "" ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                           
                            <div class="form-group col-md-4" id="nombre_proyecto_div" style="display: none;">
                                <label for="nombre_proyecto" class="control-label">Nombre del Proyecto:</label>
                                <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="<?= isset($nombre_proyecto) ? $nombre_proyecto : "" ?>" class="form-control form-control-sm rounded-0" required/>
                            </div>

                            <div class="form-group col-md-4" id="nombre_proyecto_select_div" style="display: none;">
                                <label for="nombre_proyecto_select" class="control-label">Nombre del Proyecto:</label>
                                <select name="nombre_proyecto" id="nombre_proyecto_select" class="form-control form-control-sm rounded-0 select2" required>
                                    <option value="" disabled <?= empty($nombre_proyecto) ? 'selected' : '' ?>>Seleccione un proyecto</option>
                                    <option value="CORAZONES AZULES" <?= isset($nombre_proyecto) && $nombre_proyecto == 'CORAZONES AZULES' ? 'selected' : '' ?>>CORAZONES AZULES</option>
                                    <option value="UDIPSAI" <?= isset($nombre_proyecto) && $nombre_proyecto == 'UDIPSAI' ? 'selected' : '' ?>>UDIPSAI</option>
                                    <option value="STEAM" <?= isset($nombre_proyecto) && $nombre_proyecto == 'STEAM' ? 'selected' : '' ?>>STEAM</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="email_est" class="control-label">Email estudiante:</label>
                                <input type="email" name="email_est" id="email_est" autofocus value="<?= isset($email_est) ? $email_est : "" ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="firstname_est" class="control-label">Nombre estudiante:</label>
                                <input type="text" name="firstname_est" id="firstname_est" value="<?= isset($firstname_est) ? $firstname_est : "" ?>" class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lastname_est" class="control-label">Apellido estudiante:</label>
                                <input type="text" name="lastname_est" id="lastname_est" value="<?= isset($lastname_est) ? $lastname_est : "" ?>" class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cedula_est" class="control-label">Cédula estudiante:</label>
                                <input type="text" name="cedula_est" id="cedula_est" value="<?= isset($cedula_est) ? $cedula_est : "" ?>" class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                        </div>

                        <div class="row">
                             <div class="form-group col-md-4">
                                <label for="telefono" class="control-label">Teléfono/Celular:</label>
                                <input type="text" name="telefono" id="telefono" value="<?= isset($telefono) ? $telefono : "" ?>" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="docente_tutor" class="control-label">Docente Tutor:</label>
                                <select name="docente_tutor" id="docente_tutor" class="form-control form-control-sm rounded-0 select2" required>
                                    <!-- Las opciones se llenarán mediante JavaScript -->
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nombre_institucion" class="control-label">Institución y/o Empresa:</label>
                                <select name="nombre_institucion" id="nombre_institucion" class="form-control form-control-sm rounded-0 select2" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="Universidad Católica de Cuenca" <?= isset($nombre_institucion) && $nombre_institucion == 'Universidad Católica de Cuenca' ? 'selected' : '' ?>>Universidad Católica de Cuenca</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="propuesta" class="control-label">Propuesta</label>
                                <textarea rows="3" name="propuesta" id="propuesta" class="form-control form-control-sm rounded-0" required><?= isset($propuesta) ? $propuesta : "" ?></textarea>
                            </div>
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                        </div>

                    </fieldset>
                    <div class="card-footer text-right">
                        <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Matricula</button>
                        <a href="./?page=students" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    //JS DE manage_students.php
document.addEventListener('DOMContentLoaded', function() {
   
   var selectArea = document.getElementById('area');
   var docenteTutorSelect = document.getElementById('docente_tutor');
   var nombreProyectoDiv = document.getElementById('nombre_proyecto_div');
   var nombreProyectoSelectDiv = document.getElementById('nombre_proyecto_select_div');
   var inputNombreProyecto = document.getElementById('nombre_proyecto');
   var selectNombreProyecto = document.getElementById('nombre_proyecto_select');

   // Función para actualizar campos y validaciones
   function updateFields() {
        if (selectArea.value === 'Práctica Laboral') {
        nombreProyectoDiv.style.display = 'block';
        nombreProyectoSelectDiv.style.display = 'none';
        docenteTutorSelect.innerHTML = `
            <option value="Ing. Diana Poma" >Ing. Diana Poma</option>`;
        inputNombreProyecto.setAttribute('required', 'required');
        selectNombreProyecto.removeAttribute('required');

        } else if (selectArea.value === 'Práctica Servicio Comunitario') {
            nombreProyectoDiv.style.display = 'none';
            nombreProyectoSelectDiv.style.display = 'block';
            docenteTutorSelect.innerHTML = `
                <option value="Ing. Isael Sañay" >Ing. Isael Sañay</option>
                <option value="Ing. Antonio Cajamarca" >Ing. Antonio Cajamarca</option>
                <option value="Ing. Juan Pablo Cuenca" >Ing. Juan Pablo Cuenca</option>
                <option value="Ing. Blanca Ávila" >Ing. Blanca Ávila</option>`;
            selectNombreProyecto.setAttribute('required', 'required');
            inputNombreProyecto.removeAttribute('required');
        }


       // Sincronizar valores entre el input y el select
       inputNombreProyecto.addEventListener('input', function() {
           selectNombreProyecto.value = ''; 
       });

       selectNombreProyecto.addEventListener('change', function() {
           inputNombreProyecto.value = selectNombreProyecto.value;
       });
   }

   selectArea.addEventListener('change', updateFields);
   updateFields();
});
</script>