<?php
require_once '../config.php';
require_once('inc/header.php');
require_once('../classes/Proyectos.php');


if (!empty($_SESSION['userdata']['id'])) {
    $user_id = $_SESSION['userdata']['id'];
}

$base_url = "http://localhost:5170/api/Proyecto";
$proyecto = new Proyectos($base_url);

$docente_id = $_settings->userdata('id');
 $i = 1;

$docentesObtener = $proyecto->obtenerProyectoPorDocente($docente_id);
$obtenerDocentesResponsables = $proyecto->obtenerDocentesResponsables();
$obtenerDocentesTutores = $proyecto->obtenerDocentesTutores();



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
        "area" => $_POST["area"] ?? '',
        "nombre_proyecto" => $_POST["nombre_proyecto"] ?? '',
        "nombre_docente" => $_POST["nombre_docente"] ?? '',
        "docente_tutor" => $_POST["docente_tutor"] ?? '',
        "users_id" => $_POST["users_id"],
        
    );

    $respuesta = $proyecto->crearProyecto($datos);
    //var_dump($datos);
}

$row = $proyecto->obtenerProyectoPorDocente($docente_id);
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
                    <form id="proyectos_frm" method="post" action="">
                        <fieldset class="border-bottom">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="area" class="control-label">Area:</label>
                                    <select name="area" id="area" class="form-control form-control-sm rounded-0 select2" required>
                                            <option value="" default>Selecciona el tipo de práctica</option>
                                            <option value="Practicas Internas">Practicas Internas</option>
                                            <option value="Practicas Pre-Profesionales">Practicas Pre-Profesionales</option>
                                            <option value="Practicas Vinculacion con la sociedad">Practicas Vinculacion con la sociedad</option>
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

                                                $selected = (isset($row['firstname']) && ($row['firstname'] . ' ' . $row['lastname']) === $nombreCompleto) ? 'selected' : '';
                                                echo "<option value=\"{$nombreCompleto}\" $selected>{$nombreCompleto}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="nombre_proyecto" class="control-label">Nombre proyecto: </label>
                                    <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="form-control form-control-sm rounded-0" placeholder="Ingresa el nombre del proyecto" required autofocus>
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label for="nombre_docente" class="control-label">Docente responsable de prácticas:</label>
                                    <select name="nombre_docente" id="nombre_docente" class="form-control form-control-sm rounded-0 select2" required>
                                        <option value="">Seleccione un docente</option>
                                        <?php
                                        $obtenerDocentesResponsablesUnicos = [];
                                        foreach ($obtenerDocentesResponsables as $d) {
                                            $nombreCompleto = $d['firstname'] . ' ' . $d['lastname'];

                                            if (!in_array($nombreCompleto, $obtenerDocentesResponsablesUnicos)) {
                                                $obtenerDocentesResponsablesUnicos[] = $nombreCompleto;

                                                $selected = (isset($row['firstname']) && ($row['firstname'] . ' ' . $row['lastname']) === $nombreCompleto) ? 'selected' : '';
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
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Proyecto</button>
                            <a href="./?page=Proyectos" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
                        <script>
                            
                            document.addEventListener('DOMContentLoaded', function () {
                            const areaSelect = document.getElementById('area');
                            const docenteSelect = document.getElementById('nombre_docente');
                            const hiddenInput = document.getElementById('nombre_docente_hidden');

                            // Evento cuando el usuario selecciona un docente
                            docenteSelect.addEventListener('change', function () {
                                const selectedOption = this.options[this.selectedIndex];
                                hiddenInput.value = selectedOption.dataset.fullname || "";
                                console.log("Nombre Docente seleccionado (manual):", hiddenInput.value);
                            });

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
                                    // Buscar la opción del select con ese ID
                                    const option = [...docenteSelect.options].find(opt => opt.value === docenteId);
                                    if (option) {
                                        docenteSelect.value = docenteId;

                                        if ($(docenteSelect).hasClass('select2')) {
                                            $(docenteSelect).trigger('change.select2'); 
                                        }

                                        // Actualizar el campo oculto con el fullname
                                        hiddenInput.value = option.dataset.fullname || "";
                                        console.log("Nombre Docente asignado automáticamente:", hiddenInput.value);
                                    }
                                }
                            });
                        });

                        </script>
                    </form>
            

                <div>
                    <div class="card-header">
                        <label>Buscar Proyectos</label>
                        <?php if ($_settings->userdata('type') == 2): ?>
                            <!-- Campo de búsqueda -->
                            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por Area, tipo de proyecto, etc.">
                        <?php endif; ?>
                    </div>

                    <!-- filtrar por tipo de practica -->
                    <div class="card-header">
                        <label for="practicaSelect">Filtrar por tipo de práctica:</label>
                        <select id="practicaSelect" class="form-control">
                            <option value="">Todas las prácticas</option>
                            <?php foreach ($practicas as $practica): ?>
                                <option value="<?php echo $practica; ?>"><?php echo $practica; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>



    <br><br>
      <div class="container-fluid"> 
        <div class="tabla-scrollable">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="bg-gradient-dark text-light">
                    <th>#</th>
                    <th>Area</th>
                    <th>Proyecto Integrador</th>
                    <th>Docente responsable de practicas</th>
                    <th>Docente tutor</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                // Obtiene el tipo de usuario del usuario logueado
                $user_type = $_settings->userdata('type');
                $base_url = "http://localhost:5170/api/Proyecto/detailsByDocente";
                $proyecto = new Proyectos($base_url);
                


                    // Consultar los registros de la tabla planificacion que corresponden al usuario actual
                    $qry = $proyecto->obtenerProyectoPorDocente($docente_id);
              
            
            
                foreach ($qry as $row) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td class="">
                            <p class=""><?php echo $row['area'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['nombre_proyecto'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['nombre_docente'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['docente_tutor'] ?></p>
                        </td>
                       

                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                data-toggle="dropdown">
                                Acción
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item view_data"
                                    href="./?page=Proyectos/view_proyecto&id=<?php echo $row['id'] ?>"><span
                                        class="fa fa-eye text-dark"></span> Ver</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item edit_data"
                                        href="./?page=Proyectos/manage_proyecto&id=<?php echo $row['id'] ?>"><span
                                            class="fa fa-edit text-primary"></span> Editar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data"
                                        href="./?page=Proyectos/delete_proyecto&id=<?php echo $row['id'] ?>"><span
                                            class="fa fa-trash text-danger"></span> Eliminar</a>
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
<script>
document.getElementById('practicaSelect').addEventListener('change', filtrarTabla);

function filtrarTabla() {
    var practicaSeleccionada = document.getElementById('practicaSelect').value.toLowerCase().trim();
    var rows = document.querySelectorAll('table tbody tr');

    rows.forEach(function (row) {
        var nombrePractica = row.querySelector('td:nth-child(2)').innerText.toLowerCase().trim();
        var mostrar = true;
        
       if (practicaSeleccionada && nombrePractica !== practicaSeleccionada) {
                        mostrar = false;
            }
        row.style.display = mostrar ? '' : 'none';
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

