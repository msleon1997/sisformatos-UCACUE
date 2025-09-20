<?php
require_once('../config.php');
require_once('inc/header.php');
require_once('../classes/registerareas.php');

if (!empty($_SESSION['userdata']['id'])) {
    $user_id = $_SESSION['userdata']['id'];
}
?>

<?php
// Obtener los proyectos del docente actual

$stmt = $conn->prepare("SELECT nombre_proyecto FROM area_docente WHERE users_id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$proyectos = [];
while ($row = $result->fetch_assoc()) {
    $proyectos[] = $row['nombre_proyecto'];
}
$stmt->close();



$stmt = $conn->prepare("SELECT DISTINCT area FROM area_docente WHERE users_id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$practicas = [];
while ($row = $result->fetch_assoc()) {
    $practicas[] = $row['area'];
}
$stmt->close();

?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estudiantes Matriculados</title>
    <link rel="stylesheet" href="<?php echo base_url ?>admin/students/styles.css">
</head>

<body>
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
            <label>Buscar Estudiantes Matriculados</label>
            <?php if ($_settings->userdata('type') == 1): ?>
                <div class="card-tools">
                    <a href="./?page=matriculacion/manage_matriculacion" class="btn btn-flat btn-sm btn-primary">
                        <span class="fas fa-plus"></span> Agregar Matricula Estudiante
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($_settings->userdata('type') == 2): ?>
                <!-- Campo de búsqueda -->
                <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por cédula, nombre, carrera, área, etc.">
            <?php endif; ?>
        </div>

        <!-- filtrar por proyecto -->
        <div class="card-header">
            <label for="proyectoSelect">Filtrar por Proyecto:</label>
            <select id="proyectoSelect" class="form-control">
                <option value="">Todos los proyectos</option>
                <?php foreach ($proyectos as $proyecto): ?>
                    <option value="<?php echo $proyecto; ?>"><?php echo $proyecto; ?></option>
                <?php endforeach; ?>
            </select>
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

        


        <div class="card-body">
             <div class="container-fluid"> 
                <div class="tabla-scrollable"> 
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr class="bg-gradient-dark text-light">
                                <th>#</th>
                                <th>Cedula Estudiante</th>
                                <th>Nombre Completos</th>
                                <th>Carrera</th>
                                <th>Área</th>
                                <th>Ciclo</th>
                                <th>Nombre Proyecto</th>
                                <th>Email</th>
                                <th>Teléfono/Celular</th>
                                <th>Empresa o Institución</th>
                                <th>Propuesta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener registros de la base de datos
                            $user_type = $_settings->userdata('type');
                            $user_id = $_settings->userdata('id');
                            $i = 1;

                            if ($user_type == 1) {
                                // Consulta para estudiantes

                               $stmt = $conn->prepare("SELECT *, CONCAT(firstname_est, ' ', lastname_est) AS fullname
                                                     FROM matriculacion 
                                                     WHERE users_id = ?
                                                     ORDER BY fullname ASC");

                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $stmt->close();

                            } else if ($user_type == 2) {
                                // Consulta para docentes (solo sus estudiantes)
                                $user_id = $_settings->userdata('id');
                                $qry = $conn->query("SELECT *, CONCAT(firstname_est, ' ', lastname_est) AS fullname 
                                                     FROM matriculacion 
                                                     ORDER BY fullname ASC");

                                                     
                            }

                            while ($row = $qry->fetch_assoc()):
                                $docente_qry = $conn->query("SELECT CONCAT('Ing. ', firstname, ' ', lastname) AS docente_fullname 
                                     FROM users 
                                     WHERE id = '{$row['id']}'");
                                $docente = $docente_qry->fetch_assoc();
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td><?php echo $row['cedula_est'] ?></td>
                                    <td><?php echo $row['fullname'] ?></td>
                                    <td><?php echo $row['carrera'] ?></td>
                                    <td><?php echo $row['area'] ?></td>
                                    <td><?php echo $row['ciclo'] ?></td>
                                    <td><?php echo !empty($row['nombre_proyecto']) 
                                                    ? $row['nombre_proyecto'] 
                                                    : $row['nombre_proyecto_pract_pro'];?>
                                    </td>
                                    <td><?php echo $row['email_est'] ?></td>
                                    <td><?php echo $row['telefono'] ?></td>
                                    <td><?php echo $row['nombre_institucion'] ?></td>
                                    <td><?php echo $row['propuesta'] ?></td>
                                    <td align="center">
                                        <a href="./?page=students/view_student&id=<?= $row['id'] ?>"
                                            class="btn btn-flat btn-default btn-sm border">
                                            <i class="fa fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div> 
            </div> 
        </div>
    </div>
</body>

</html>
<script>
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

            document.getElementById('proyectoSelect').addEventListener('change', filtrarTabla);
            document.getElementById('practicaSelect').addEventListener('change', filtrarTabla);

            function filtrarTabla() {
                var proyectoSeleccionado = document.getElementById('proyectoSelect').value.toLowerCase().trim();
                var practicaSeleccionada = document.getElementById('practicaSelect').value.toLowerCase().trim();

                var rows = document.querySelectorAll('table tbody tr');

                rows.forEach(function (row) {
                    var nombreProyecto = row.querySelector('td:nth-child(7)').innerText.toLowerCase().trim();
                    var nombrePractica = row.querySelector('td:nth-child(5)').innerText.toLowerCase().trim();

                    var mostrar = true;

                    if (proyectoSeleccionado && nombreProyecto !== proyectoSeleccionado) {
                        mostrar = false;
                    }
                    if (practicaSeleccionada && nombrePractica !== practicaSeleccionada) {
                        mostrar = false;
                    }

                    row.style.display = mostrar ? '' : 'none';
                });
            }
</script>