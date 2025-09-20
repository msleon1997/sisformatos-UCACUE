<?php
require_once '../config.php';
require_once('../classes/Proyectos.php');


$id = $_GET['id'];

$base_url = "http://localhost:5170/api/Proyecto";
$proyecto = new Proyectos($base_url);

$obtenerDocentesResponsables = $proyecto->obtenerDocentesResponsables();
$obtenerDocentesTutores = $proyecto->obtenerDocentesTutores();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $datos = array(
        "id" => $_POST["id"],
        "area" => $_POST["area"],
        "nombre_proyecto" => $_POST["nombre_proyecto"],
        "nombre_docente" => $_POST["nombre_docente"],
        "docente_tutor" => $_POST["docente_tutor"], 
        "users_id" => $_POST["users_id"],
        
    );

    $respuesta = $proyecto->actualizarProyecto($id, $datos);
    //var_dump($datos);
}

$row = $proyecto->obtenerProyectoPorDocente($id);


?>


<link rel="stylesheet" href="<?php echo base_url ?>admin/Proyectos/css/styles.css">
<script src="<?php echo base_url ?>admin/Proyectos/js/script.js" defer></script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">Unidad Académica de: Informática, Ciencias de la Computación e Innovación Tecnológica
        </h3>
        <br>
        <h4 class="card-title"> Período Lectivo: Marzo 2024 - Agosto 2024</h4>
    </div>
    <hr class="custom-divider">
    <br>
    <div class="card-body">

        <div class="container-fluid">
            <div class="container-fluid">

                    <form id="proyectos_frm" method="post" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id'] ? $id : '' ?>">
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

                                <div class="form-group col-md-4" id="docente_tutor_group">
                                    <label for="docente_tutor" class="control-label">Docente-Tutor:</label>
                                    <select name="docente_tutor" id="docente_tutor"
                                            class="form-control form-control-sm rounded-0 select2">
                                        <option value="">Seleccione un docente</option>
                                        <?php
                                        $obtenerDocentesTutoresUnicos = [];
                                        foreach ($obtenerDocentesTutores as $d) {
                                            $nombreCompleto = $d['firstname'] . ' ' . $d['lastname'];

                                            if (!in_array($nombreCompleto, $obtenerDocentesTutoresUnicos)) {
                                                $obtenerDocentesTutoresUnicos[] = $nombreCompleto;
                                                $selected = (isset($row['docente_tutor']) && $row['docente_tutor'] === $nombreCompleto) ? 'selected' : '';
                                                echo "<option value=\"{$nombreCompleto}\" $selected>{$nombreCompleto}</option>";
                                            }
                                        }
                                        ?> 
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nombre_proyecto" class="control-label">Nombre proyecto: </label>
                                    <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="<?php echo $row['nombre_proyecto']; ?>" class="form-control form-control-sm rounded-0" required autofocus>
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label for="nombre_docente" class="control-label">Docente responsable de prácticas:</label>
                                    <select name="nombre_docente" id="nombre_docente" class="form-control form-control-sm rounded-0 select2" required>
                                        <option value="" disabled selected>Seleccione un docente</option>
                                        <?php
                                        $obtenerDocentesResponsablesUnicos = [];
                                        foreach ($obtenerDocentesResponsables as $d) {
                                            $nombreCompleto = $d['firstname'] . ' ' . $d['lastname'];

                                            if (!in_array($nombreCompleto, $obtenerDocentesResponsablesUnicos)) {
                                                $obtenerDocentesResponsablesUnicos[] = $nombreCompleto;
                                                $selected = (isset($row['nombre_docente']) && $row['nombre_docente'] === $nombreCompleto) ? 'selected' : '';
                                                echo "<option value=\"{$nombreCompleto}\" $selected>{$nombreCompleto}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>



                            </div>
                            </div>
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id') ?>">
                        </fieldset>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Proyecto</button>
                            <a href="./?page=Proyectos" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const areaSelect = document.getElementById('area');
                                const docenteSelect = document.getElementById('nombre_docente');
                                const hiddenInput = document.getElementById('nombre_docente_hidden');

                                // Función para sincronizar el campo oculto con el docente seleccionado
                                function syncHiddenDocente() {
                                    const selectedOption = docenteSelect.options[docenteSelect.selectedIndex];
                                    hiddenInput.value = selectedOption?.dataset.fullname || "";
                                    console.log("Docente sincronizado:", hiddenInput.value);
                                }
                                syncHiddenDocente();

                                docenteSelect.addEventListener('change', syncHiddenDocente);

                                // Cuando cambia el área, se selecciona un docente automáticamente
                                areaSelect.addEventListener('change', function () {
                                    const area = this.value;
                                    let docenteId = null;

                                    if (area === 'Practicas Pre-Profesionales') {
                                        docenteId = '123';
                                    } else if (area === 'Practicas Internas' || area === 'Practicas Vinculacion con la sociedad') {
                                        docenteId = '36';
                                    }

                                    if (docenteId) {
                                        const option = [...docenteSelect.options].find(opt => opt.value === docenteId);
                                        if (option) {
                                            docenteSelect.value = docenteId;

                                            // Si usas select2
                                            if ($(docenteSelect).hasClass('select2')) {
                                                $(docenteSelect).trigger('change.select2');
                                            }

                                            syncHiddenDocente();
                                        }
                                    }
                                });
                            });
                            </script>

                    </form>
            

            </div>
        </div>
    </div>
</div>