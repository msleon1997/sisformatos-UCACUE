
<?php
require_once '../config.php';
require_once('../classes/CertificadoPract.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$base_url = "http://localhost:5170/api/CertificadoPracticas"; 
$certpract = new CertificadoPract($base_url);
$user_id = $_settings->userdata('id');

$actividades = $certpract->obtenerMatriculacionActividades($user_id);

$fecha_ini = '';
$fecha_fin = '';

if (!empty($actividades) && isset($actividades[0]['app_Fecha_ini'])) {
    $fecha_ini = date('Y-m-d', strtotime($actividades[0]['app_Fecha_ini']));
    $fecha_fin = date('Y-m-d', strtotime($actividades[0]['app_Fecha_fin']));
}

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
        "fecha_emision" => $_POST["fecha_emision"] ?? '',
        "estudiante_nombre" => $_POST["estudiante_nombre"] ?? '',
        "numero_cedula" => $_POST["numero_cedula"] ?? '',
        "tipo_practica" => $_POST["tipo_practica"] ?? '',
		"malla_curricular" => $_POST["malla_curricular"] ?? '',
		"ciclo_est" => $_POST["ciclo_est"] ?? '',
		"proyecto_empresa_entidad" => $_POST["proyecto_empresa_entidad"] ?? '',
		"periodo_fecha_ini" => $_POST["periodo_fecha_ini"] ?? '',
		"periodo_fecha_fin" => $_POST["periodo_fecha_fin"] ?? '',
		"cantidad_horas_pract" => $_POST["cantidad_horas_pract"] ?? '',
        "total_horas_pract" => $_POST["total_horas_pract"] ?? '',
		"users_id" => $_POST["users_id"]
    );
    $respuesta = $certpract->crearCertificadoPract($datos);
//var_dump($datos);
}

?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/CertificadoPract/css/styles.css">
<script src="<?php echo base_url ?>admin/CertificadoPract/js/script.js" defer></script>
<script>
    const datosPorArea = <?= json_encode($actividades) ?>;
</script>
<div class="card card-outline card-primary rounded-0 shadow">
   
    <div class="card-body">
    <?php if ($_settings->userdata('type') == 1): ?>
        <div class="container-fluid">
            <div class="container-fluid">

            
            <form id="Cert_pract_frm" method="post" action="">
                
                    
                
                <fieldset class="border-bottom">
                    
                        <div class="row">
                            <div class="form-group col-md-2 end-column">
                                <label for="fecha_emision" class="control-label">Cuenca,  </label>
                                <input type="date" name="fecha_emision" id="fecha_emision" autofocus  class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>


                        <div class="row">
                            
                            <p>La Jefatura de Vinculación con la Sociedad de la Universidad Católica de Cuenca, a través del Docente Responsable de Prácticas Laborales de la 
                                Carrera de Ingeniería de Software Modalidad Nocturna de la Unidad Académica de Desarrollo de Software de la Universidad Católica de Cuenca – 
                                (matriz, sedes o extensiones); a petición verbal de la parte interesada: </p>
                        </div>

                        <h4 class="title-cert">CERTIFICA:</h4>
                            <p>Que el/ la estudiante <input type="text" name="estudiante_nombre" id="estudiante_nombre" autofocus value="<?php echo ($actividades['lastname_est'] ?? '') . ' ' . ($actividades['firstname_est'] ?? ''); ?>" class="form-control form-control-sm rounded-0" readonly>
                                portador/a del documento único de identidad número:<input type="text" name="numero_cedula" id="numero_cedula" autofocus value="<?php echo $actividades['cedula_est'] ?? ''; ?>"  class="form-control form-control-sm rounded-0" readonly> , ha cumplido con sus horas de 
                                <select name="tipo_practica" id="tipo_practica" class="form-control form-control-sm rounded-0 select2" required onchange="actualizarCampos()">
                                    <option value="">Seleccione un área</option>
                                            <?php
                                                $areasUnicas = [];
                                                if (isset($actividades['matriculaciones']) && is_array($actividades['matriculaciones'])) {
                                                    foreach ($actividades['matriculaciones'] as $p) {
                                                        if (!in_array($p['area'], $areasUnicas)) {
                                                            $areasUnicas[] = $p['area'];
                                                            $selected = (isset($row['area']) && $row['area'] === $p['area']) ? 'selected' : '';
                                                            echo "<option value=\"{$p['area']}\" $selected>{$p['area']}</option>";
                                                        }
                                                    }
                                                }
                                            ?>
                                </select>
                                </p>

                       <div class="row">
                        <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
                            <thead>
                            <tr>
                                <th>Malla</th>
                                <th>Ciclo</th>
                                <th>Proyecto/<br>Empresa/Entidad</th>
                                <th>Período</th>
                                <th>Horas</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                <textarea name="malla_curricular" id="malla_curricular" class="form-control form-control-sm rounded-0" rows="3" placeholder="Colocar la malla a la que pertenece el estudiante"></textarea>
                                </td>
                                <td>
                                <input type="text" name="ciclo_est" id="ciclo_est" class="form-control form-control-sm rounded-0" readonly value="<?php echo $actividades['ciclo'] ?? ''; ?>">
                                </td>
                                <td>
                                <input type="text" name="proyecto_empresa_entidad" id="proyecto_empresa_entidad" value="<?php echo $actividades['nombre_institucion'] ?? '' ?>"  class="form-control form-control-sm rounded-0" readonly>
                                </td>
                                <td>
                                <input type="date" name="periodo_fecha_ini" id="periodo_fecha_ini" 
                                    value="<?php echo isset($actividades['app_Fecha_ini']) ? date('Y-m-d', strtotime($actividades['app_Fecha_ini'])) : ''; ?>" 
                                    class="form-control form-control-sm rounded-0" required>                                al<br>
                                <input type="date" name="periodo_fecha_fin" id="periodo_fecha_fin" 
                                    value="<?php echo isset($actividades['app_Fecha_ini']) ? date('Y-m-d', strtotime($actividades['app_Fecha_ini'])) : ''; ?>" 
                                    class="form-control form-control-sm rounded-0" required>
                                </td>
                                <td>
                                <select name="cantidad_horas_pract" id="cantidad_horas_pract" class="form-control form-control-sm rounded-0 select2">
                                    <option value="120">120 Horas</option>
                                    <option value="240">240 Horas</option>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Total de horas</strong></td>
                                <td>
                                <input type="number" name="total_horas_pract" id="total_horas_pract" class="form-control form-control-sm rounded-0" placeholder="Ingrese el total de horas">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                        <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                        </fieldset>
                        <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Certificado de Practicas</button>
                            <a href="./?page=CertificadoPract" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
            </form>
        </div>
        </div>
    <?php endif;?>
        <?php if ($_settings->userdata('type') == 2): ?>
            <div class="card-header">
                <label>Buscar por estudiante</label>
                    <!-- Campo de búsqueda -->
                    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por Cédula, Estudiante, Empresa o Institucion, etc.">
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
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th class="col-2">Estudiante</th>
                            <th class="col-2">Cédula</th>
                            <th class="col-2">Ciclo</th>
                            <th class="col-2">Empresa/Proyecto</th>
                            <th class="col-9">Tipo Práctica</th>
                            <th class="col-15"># Horas Practica </th>
                            <th class="col-15">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/CertificadoPracticas/detailsByUser"; 
                        $base_urlDoc = "http://localhost:5170/api/CertificadoPracticas"; 
                        $certpract = new CertificadoPract($base_url);
                        $certpractDoc = new CertificadoPract($base_urlDoc);
                        $user_type = $_settings->userdata('type');
                        // Obtener el ID del usuario actualmente logueado

                         $user_id = $_settings->userdata('id');
                         if ($user_type == 1) {
                            $qry = $certpract->obtenerCertificadoPractPorUser($user_id);
                        } else if ($user_type == 2) {
                            $qry = $certpractDoc->obtenerCertificadoPract();
                        }
                        
                        
                        
                         foreach ($qry as $row) {
                            ?>
                                <tr>
                                  <td class="text-center"><?php echo $i++; ?></td>
                                  <td class="">
                                        <p class=""><?php echo $row['estudiante_nombre'] ?></p>
                                    </td>
                                    
                                  <td class="">
                                      <p class=""><?php echo $row['numero_cedula'] ?></p>
                                  </td>  
                                  <td class="">
                                      <p class=""><?php echo $row['ciclo_est'] ?></p>
                                  </td>
                                  <td class="">
                                      <p class=""><?php echo $row['proyecto_empresa_entidad'] ?></p>
                                  </td>
                                  <td class="">
                                      <p class=""><?php echo $row['tipo_practica'] ?></p>
                                  </td>
                                  

                                  <td class="">
                                      <p class="">
                                            <?php
                                            $fecha_inicio = new DateTime($row['periodo_fecha_ini']);
                                            echo $fecha_inicio->format('d/m/Y'); 
                                            ?>
                                        </p>
                                    <p style="text-align: center;">al</p>
                                     <p class="">
                                        <?php
                                            $fecha_fin = new DateTime($row['periodo_fecha_fin']);
                                            echo $fecha_inicio->format('d/m/Y'); 
                                        ?>
                                    </p>
                                    </td>
                                

                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="./?page=CertificadoPract/view_certificado_pract&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                            <?php if ($_settings->userdata('type') == 1) : ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item edit_data" href="./?page=CertificadoPract/manage_certificado_pract&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_data" href="./?page=CertificadoPract/delete_certificado_pract&id=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
            var nombrePractica = row.querySelector('td:nth-child(6) p').innerText.toLowerCase().trim();

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