
<?php
require_once '../config.php';
require_once('../classes/DescargaInforme.php');


$base_url = "http://localhost:5170/api/DescargaFormatos";
$DescargaInformes = new DescargaInforme($base_url);

 $user_id = $_settings->userdata('id');


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
            
            "Empresa_proyecto" => $_POST["Empresa_proyecto"] ?? '',
            "Periodo_practicas" => $_POST["Periodo_practicas"] ?? '',
            "Carrera_est" => $_POST["Carrera_est"] ?? '',
            "Area_desarrollo" => $_POST["Area_desarrollo"] ?? '',
            "Est_cedula" => implode("; ", $_POST['Est_cedula'] ?? ''),
            "Est_apellidos" => implode("; ", $_POST['Est_apellidos'] ?? ''),
            "Est_nombres" => implode("; ", $_POST['Est_nombres'] ?? ''),
            "Est_ciclo" => implode("; ", $_POST['Est_ciclo'] ?? ''),
            "users_id" => $_POST["users_id"]
        );
    }
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($user_id);
  
    //var_dump($row)
?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/DescargaInformes/css/styles.css">
<script src="<?php echo base_url ?>admin/DescargaInformes/js/script.js" defer></script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">DESCARGA DE INFORME COMPLETO DE PRACTICAS DEL ESTUDIANTE</h3>
        <br>
    </div>

    <div>
        <?php if ($_settings->userdata('type') == 2): ?>
        <div class="card-header">
                <label>Buscar por estudiante</label>
                <?php if ($_settings->userdata('type') == 2): ?>
                    <!-- Campo de búsqueda -->
                     <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por Cédula, Estudiante, Docente, Empresa o Institucion">
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
        <?php endif; ?>
    </div>
    <div class="card-body">
    <div class="container-fluid">
        <div class="tabla-scrollable">
            <table class="table table-bordered table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="20%">
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-dark text-light">
                        <th>#</th>
                        <th>Tipo de Práctica</th>
                        <th>Cédula Estudiante</th>
                        <th>Estudiante</th>
                        <th>Carrera</th>
                        <th>Ciclo</th>
                        <th>Periodo de prácticas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                   
                        $base_url = "http://localhost:5170/api/DescargaFormatos";
                        $base_urlDoc = "http://localhost:5170/api/DescargaFormatos";
                        $descargaInformes = new DescargaInforme($base_url);
                        $descargaInformesDoc = new DescargaInforme($base_urlDoc);
                        $user_type = $_settings->userdata('type');
                         $user_id = $_settings->userdata('id');
                         if ($user_type == 1) {
                            $qry = $descargaInformes->obtenerFormatosCompletosPorUser($user_id);
                        } else if ($user_type == 2) {
                            $qry = $descargaInformesDoc->obtenerFormatosCompletos();
                        }

                     if(is_array($qry) && !empty($qry)) {
                        if(isset($qry['actividadesPracticas']) && is_array($qry['actividadesPracticas'])) {
                            foreach($qry['actividadesPracticas'] as $actividad) {
                                
                                
                                if(isset($qry['planificaciones']) && is_array($qry['planificaciones'])) {
                                    foreach($qry['planificaciones'] as $planificacion) {
                                        if($planificacion['tP_Area'] == $actividad['app_Tipo_pract'] &&
                                           $planificacion['estudianteLider'] == $actividad['app_Nom_est']) {
                                            $ciclo = $planificacion['tP_Ciclo'] ?? 'N/A';
                                            break;
                                        }
                                    }
                                }
                                
                                if(!empty($actividad['app_Fecha_ini']) && !empty($actividad['app_Fecha_fin'])) {
                                    $periodo = date('d/m/Y', strtotime($actividad['app_Fecha_ini'])).' - '.date('d/m/Y', strtotime($actividad['app_Fecha_fin']));
                                } 
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td><?php echo $actividad['app_Tipo_pract'] ?? 'N/A'; ?></td>
                                    <td><?php echo $actividad['app_Cedula_est'] ?? 'N/A'; ?></td>
                                    <td><?php echo $actividad['app_Nom_est'] ?? 'N/A'; ?></td>
                                    <td><?php echo $planificacion['tP_Carrera'] ?? 'N/A'; ?></td>
                                    <td><?php echo $ciclo; ?></td>
                                    <td><?php echo $periodo; ?></td>
                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="./?page=DescargaInformes/view_informes&id=<?php echo $actividad['users_id']; ?>&tipo=<?php echo urlencode($actividad['app_Tipo_pract'] ?? ''); ?>">
                                                <span class="fa fa-eye text-dark"></span> Ver
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php

                                
                             }
                        }
                    } else {
                        echo '<tr><td colspan="9" class="text-center">No se encontraron datos</td></tr>';
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
        var rows = document.querySelectorAll('.table tbody tr');

        rows.forEach(function (row) {
            var nombrePractica = row.querySelector('td:nth-child(2)').innerText.toLowerCase().trim();

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