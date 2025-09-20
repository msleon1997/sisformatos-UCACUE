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
<script src="<?php echo base_url ?>admin/students/script.js" defer></script>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Información Estudiante Matriculado</h5>
            <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): // Usuario tipo 1 (Estudiante) ?>
            <a class="btn btn-sm btn-primary btn-flat" href="./?page=students/manage_student&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                    <a class="btn btn-sm btn-danger btn-flat" href="./?page=students/delete_student&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
                <?php endif; ?>
                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=students" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid" id="outprint">
                
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
                                <div class="pl-4"><?= isset($docente_id) ? $docente_id : 'N/A' ?></div>
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
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
    <div class="row">
        <div class="col-2 d-flex justify-content-center align-items-center">
            <img src="<?= validate_image($_settings->info('logo')) ?>" class="img-circle" id="sys_logo" alt="System Logo">
        </div>
        <div class="col-8">
            <h4 class="text-center"><b><?= $_settings->info('name') ?></b></h4>
            <h3 class="text-center"><b>Registros Estudiante</b></h3>
        </div>
        <div class="col-2"></div>
    </div>
</noscript>
