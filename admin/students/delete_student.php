<?php
require_once '../config.php';
require_once('../classes/Matriculacion.php');



if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT *, CONCAT(firstname_est,' ', lastname_est) as fullname FROM `matriculacion` where id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k))
                $$k = $v;
        }
    }
}




?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/students/styles.css">
<script src="<?php echo base_url ?>admin/students/script.js"></script>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Información Estudiante Matriculado</h5>
           
        </div>
        <div class="card-body">
            <div class="container-fluid" id="outprint">
                
                <form id="matriculacion_frm_delete" method="post">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <!-- Agregar un campo oculto para indicar la acción de eliminación -->
                <input type="hidden" name="action" value="delete">
                <fieldset class="border-bottom">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label text-muted">Cedula del estudiante:</label>
                                <div class="pl-4"><?= isset($cedula_est) ? $cedula_est : 'N/A' ?></div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label text-muted">Nombres Completos:</label>
                                    <div class="pl-4"><?= isset($fullname) ? $fullname : 'N/A' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                
                <fieldset class="border-bottom">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label class="control-label text-muted">Área:</label>
                                <div class="pl-4"><?= isset($area) ? $area : 'N/A' ?></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label text-muted">Nombre del Proyecto</label>
                                <div class="pl-4"><?= isset($nombre_proyecto) ? $nombre_proyecto : 'N/A' ?></div>
                            </div>
                    </div>
                </fieldset>

                    <fieldset>
                        <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label text-muted">Carrera:</label>
                                <div class="pl-4"><?= isset($carrera) ? $carrera : 'N/A' ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label text-muted">Ciclo:</label>
                                <div class="pl-4"><?= isset($ciclo) ? $ciclo : 'N/A' ?></div>
                            </div>
                        </div>
                       
                    </div>
                </fieldset>
                    
                <fieldset>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label text-muted">Email / Correo:</label>
                                <div class="pl-4"><?= isset($email_est) ? $email_est : 'N/A' ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label text-muted">Teléfono / Celular:</label>
                                <div class="pl-4"><?= isset($telefono) ? $telefono  : 'N/A' ?></div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label text-muted">Docente Tutor:</label>
                                <div class="pl-4"><?= isset($email_est) ? $email_est : 'N/A' ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label text-muted">Nombre Empresa o Institución</label>
                                <div class="pl-4"><?= isset($nombre_institucion) ? $nombre_institucion  : 'N/A' ?></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                    
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label text-muted">Propuesta:</label>
                                <div class="pl-4"><?= isset($propuesta) ? $propuesta : 'N/A' ?></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div>
                    <button class="btn btn-flat btn-danger btn-sm" id="btn-eliminar" type="submit">Eliminar Matricula</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
                
