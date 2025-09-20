<?php
require_once '../config.php';
require_once('../classes/Matriculacion.php');


$base_url = "http://localhost:5170/api/Matriculacion";
$matriculacion = new Matriculacion($base_url);

// Obtener el ID del usuario actualmente logueado
$user_id = $_settings->userdata('id');
$i = 1;


$stmt = $conn->prepare("SELECT *, CONCAT(firstname, ' ', lastname) AS fullname
                        FROM users 
                        WHERE id = ? 
                        ORDER BY fullname ASC");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$estudiante = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cambiar aquí para recibir nombres completos

    $datos = array(
        "cedula_est" => $_POST["cedula_est"] ?? '',
        "firstname_est" => $_POST["firstname_est"] ?? '',
        "lastname_est" => $_POST["lastname_est"] ?? '',
        "carrera" => $_POST["carrera"] ?? '',
        "area" => $_POST["area"] ?? '',
        "ciclo" => $_POST["ciclo"] ?? '',
        "nombre_proyecto" => $_POST["nombre_proyecto"] ?? '',
        "nombre_proyecto_pract_pro" => $_POST["nombre_proyecto_pract_pro"] ?? '',
        "email_est" => $_POST["email_est"] ?? '',
        "telefono" => $_POST["telefono"] ?? '',
        "nombre_institucion" => $_POST["nombre_institucion"] ?? '',
        "propuesta" => $_POST["propuesta"] ?? '',
        "users_id" => $_POST["users_id"] ?? ''
    );
    

    $respuesta = $matriculacion->crearMatriculacion($datos);
     //var_dump($datos);
}

$obtenerProyectos = $matriculacion->obtenerProyectos();


?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/matriculacion/css/styles.css">
<script src="<?php echo base_url ?>admin/matriculacion/js/script.js" defer></script>
<div class="content py-3">
    <div class="card card-outline card-primary shadow rounded-0">
        <div class="card-header">
            <h3 class="card-title">
                <b><?= isset($id) ? "Actualizar Información Estudiante - " . $roll : "Matriculación Prácticas Pre-profesionales, Internas y Vinculación" ?></b>
            </h3>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <form id="matriculacion_frm" method="post" action="">
                    
                    <input type="hidden" name="users_id"
                        value="<?php echo isset($_GET['student_id']) ? $_GET['student_id'] : '' ?>">
                    <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="roll" class="control-label">Ingrese su carrera: </label>
                                <input type="text" name="carrera" id="carrera" autofocus
                                class="form-control form-control-sm rounded-0" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="area" class="control-label">Área:</label>
                                <select name="area" id="area" class="form-control form-control-sm rounded-0 select2" required onchange="actualizarVisibilidadCampos();">
                                <option value="">Seleccione un área</option>
                                <?php
                                    $proyectos = $matriculacion->obtenerProyectos();
                                    $areasUnicas = [];
                                    foreach ($proyectos as $p) {
                                        if (!in_array($p['area'], $areasUnicas)) {
                                            $areasUnicas[] = $p['area'];
                                            $selected = (isset($row['area']) && $row['area'] === $p['area']) ? 'selected' : '';
                                            echo "<option value=\"{$p['area']}\" $selected>{$p['area']}</option>";
                                        }
                                    }
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="ciclo" class="control-label">Ciclo:</label>
                                <select name="ciclo" id="ciclo" class="form-control form-control-sm rounded-0 select2">
                                    <option value="1er Ciclo">1er Ciclo</option>
                                    <option value="2do Ciclo">2do Ciclo</option>
                                    <option value="3er Ciclo">3er Ciclo</option>
                                    <option value="4to Ciclo">4to Ciclo</option>
                                    <option value="5to Ciclo">5to Ciclo</option>
                                    <option value="6to Ciclo">6to Ciclo</option>
                                    <option value="7mo Ciclo">7mo Ciclo</option>
                                    <option value="8vo Ciclo">8vo Ciclo</option>
                                </select>
                            </div>


                            <div class="form-group col-md-4" id="proyecto_select_group">
                                <label for="proyecto_select" class="control-label">Nombre del Proyecto:</label>
                                <select name="nombre_proyecto" id="proyecto_select" class="form-control form-control-sm rounded-0 select2">
                                    <option value="">Seleccione un proyecto</option>
                                    <?php
                                    $proyectos = $matriculacion->obtenerProyectos();
                                    $proyectosUnicos = [];
                                    foreach ($proyectos as $p) {
                                        if (!in_array($p['nombre_proyecto'], $proyectosUnicos)) {
                                            $proyectosUnicos[] = $p['nombre_proyecto'];
                                            $selected = (isset($row['nombre_proyecto']) && $row['nombre_proyecto'] == $p['nombre_proyecto']) ? 'selected' : '';
                                            echo "<option value=\"{$p['nombre_proyecto']}\" $selected>{$p['nombre_proyecto']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4" id="proyecto_input_group">
                                <label for="nombre_proyecto_pract_pro" class="control-label">Nombre del Proyecto:</label>
                                <input type="text" name="nombre_proyecto_pract_pro" id="nombre_proyecto_pract_pro" value="<?= $row['nombre_proyecto_pract_pro'] ?? '' ?>" class="form-control form-control-sm rounded-0">
                            </div>


                            <div class="form-group col-md-4">
                                <label for="email_est" class="control-label">Email estudiante:</label>
                                <input type="text" name="email_est" id="email_est" autofocus readonly
                                    value="<?= $estudiante['email'] ?? '' ?>"
                                    class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="firstname_est" class="control-label">Nombre estudiante:</label>
                                <input type="text" name="firstname_est" id="firstname_est"
                                    value="<?= $estudiante['firstname'] ?? '' ?>"
                                    class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lastname_est" class="control-label">Apellido estudiante:</label>
                                <input type="text" name="lastname_est" id="lastname_est"
                                    value="<?= $estudiante['lastname'] ?? '' ?>"
                                    class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cedula_est" class="control-label">Cédula estudiante:</label>
                                <input type="text" name="cedula_est" id="cedula_est"
                                    value="<?= $estudiante['cedula'] ?? '' ?>"
                                    class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="telefono" class="control-label">Teléfono/Celular:</label>
                                <input type="text" name="telefono" id="telefono"
                                    class="form-control form-control-sm rounded-0" required>
                            </div>
                           

                            <div class="form-group col-md-4">
                                <label for="nombre_institucion" class="control-label">Institución y/o Empresa:</label>
                                <input type="text" name="nombre_institucion" id="nombre_institucion"
                                    value="<?= isset($nombre_institucion) ? $nombre_institucion : "" ?>"
                                    class="form-control form-control-sm rounded-0" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="propuesta" class="control-label">Propuesta</label>
                                <textarea rows="3" name="propuesta" id="propuesta"
                                    class="form-control form-control-sm rounded-0"
                                    required></textarea>
                            </div>
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id') ?>">
                        </div>


                    </fieldset>
                    <div class="card-footer text-right">
                        <button class="btn btn-flat btn-primary btn-sm" type="submit">Registrar Matricula</button>
                        <a href="./?page=matriculacion/manage_matriculacion"
                            class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                    </div>

                </form>
                <?php if ($_settings->userdata('type') == 2): ?>
                    <div class="search-box mb-3">
                        <label for="searchInput">BUSCAR REGISTRO</label>
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Buscar por Nombre de proyecto">
                    </div>
                <?php endif; ?>
            </div>
        </div>


<div class="tabla-scrollable">
        <table class="table table-bordered table-hover table-striped">

            
            <thead>
                <tr class="bg-gradient-dark text-light">
                    <th>#</th>
                    <th>Carrera</th>
                    <th>Area</th>
                    <th>Ciclo</th>
                    <th>Estudiante</th>
                    <th>Institución/Empresa</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $user_type = $_settings->userdata('type');
                $base_url = "http://localhost:5170/api/Matriculacion/detailsByUser";
                $proyecto = new Matriculacion($base_url);
                    // Consultar los registros de la tabla planificacion que corresponden al usuario actual
                    $qry = $proyecto->obtenerMatriculacionPorUser($user_id);
                    
                foreach ($qry as $row) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td class="">
                            <p class=""><?php echo $row['carrera'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['area'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['ciclo'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $estudiante['fullname'] ?></p>
                        </td>
                        <td class="">
                            <p class=""><?php echo $row['nombre_institucion'] ?></p>
                        </td>
                       

                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                data-toggle="dropdown">
                                Acción
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item view_data"
                                    href="./?page=matriculacion/view_matriculacion&id=<?php echo $row['id'] ?>"><span
                                        class="fa fa-eye text-dark"></span> Ver</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item edit_data"
                                        href="./?page=matriculacion/manage_matriculacion&id=<?php echo $row['id'] ?>"><span
                                            class="fa fa-edit text-primary"></span> Editar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data"
                                        href="./?page=matriculacion/delete_matriculacion&id=<?php echo $row['id'] ?>"><span
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
document.addEventListener("DOMContentLoaded", function () {
    actualizarVisibilidadCampos();
});
</script>




