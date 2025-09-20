<?php
require_once '../config.php';
require_once('../classes/Proyectos.php');

// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id de la URL
    $id = $_GET['id'];

    // URL base de la API
    $base_url = "http://localhost:5170/api/Proyecto";

    // Crear una instancia del objeto con la URL base
    $proyecto = new Proyectos($base_url);

    // Obtener los detalles del registro por su id
    $row = $proyecto->obtenerProyectoPorDocente($id);
?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/Proyectos/css/styles.css">
<script src="<?php echo base_url ?>admin/Proyectos/js/view.js" defer></script>
<script src="<?php echo base_url ?>admin/Proyectos/js/script.js" defer></script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=Proyectos/manage_proyecto&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=Proyectos/delete_proyecto&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
            <?php endif; ?>
            <a href="./?page=Proyectos" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
        </div>
    </div>

    <hr class="custom-divider">
    <br>
    <div class="card-body">

        <div class="container-fluid" class="container-fluid" id="outprint">
            <h3 class="card-title">Unidad Académica de: Informática, Ciencias de la Computación e Innovación Tecnológica
            </h3>
            <br>
          
            <br><br>

                    <form id="proyectos_frm" method="post" action="">
                        <fieldset class="border-bottom">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="area" class="control-label">Area:</label>
                                    <select name="area" id="area" class="form-control form-control-sm rounded-0 select2" required>
                                        <option value="Practicas Internas" <?php echo ($row['area'] == 'Practicas Internas') ? 'selected' : ''; ?>>Practicas Internas</option>
                                        <option value="Practicas Pre-Profesionales" <?php echo ($row['area'] == 'Practicas Pre-Profesionales') ? 'selected' : ''; ?>>Practicas Pre-Profesionales</option>
                                        <option value="Practicas Vinculacion con la sociedad" <?php echo ($row['area'] == 'Practicas Vinculacion con la sociedad') ? 'selected' : ''; ?>>Practicas Vinculacion con la sociedad</option>
                                    </select>

                                </div>

                                <div class="form-group col-md-4">
                                    <label for="docente_tutor" class="control-label">Docente-Tutor:</label>
                                    <input type="text" name="docente_tutor" id="docente_tutor" value="<?php echo $row['docente_tutor']; ?>" class="form-control form-control-sm rounded-0" required autofocus>

                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label for="nombre_docente" class="control-label">Docente responsable de prácticas:</label>
                                    <input type="text" name="nombre_docente" id="nombre_docente" value="<?php echo $row['nombre_docente']; ?>" class="form-control form-control-sm rounded-0" required autofocus>

                                </div>

                            </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="nombre_proyecto" class="control-label">Nombre del proyecto: </label>
                                        <textarea rows="8" name="nombre_proyecto" id="nombre_proyecto" class="form-control form-control-sm rounded-0"><?php echo $row['nombre_proyecto']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id') ?>">
                        </fieldset>
                    </form>
            </div>
    </div>
</div>

<?php
}
?>