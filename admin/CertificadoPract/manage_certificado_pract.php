
<?php
require_once '../config.php';
require_once('../classes/CertificadoPract.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


    $id = $_GET['id'];
    $base_url = "http://localhost:5170/api/CertificadoPracticas"; 
    $certpract = new CertificadoPract($base_url);
    $user_id = $_settings->userdata('id');
    $row = $certpract->obtenerCertificadoPractPorUser($id);
    $student_id = $row['users_id'];
    $actividades = $certpract->obtenerMatriculacionActividades($student_id);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $datos = array(
        "id" => $_POST["id"],
        "fecha_emision" => $_POST["fecha_emision"],
        "estudiante_nombre" => $_POST["estudiante_nombre"],
        "numero_cedula" => $_POST["numero_cedula"],
        "tipo_practica" => $_POST["tipo_practica"],
		"malla_curricular" => $_POST["malla_curricular"],
		"ciclo_est" => $_POST["ciclo_est"],
		"proyecto_empresa_entidad" => $_POST["proyecto_empresa_entidad"],
		"periodo_fecha_ini" => $_POST["periodo_fecha_ini"],
		"periodo_fecha_fin" => $_POST["periodo_fecha_fin"],
		"cantidad_horas_pract" => $_POST["cantidad_horas_pract"],
        "total_horas_pract" => $_POST["total_horas_pract"],
		"users_id" => $_POST["users_id"]
    );
    $respuesta = $certpract->actualizarCertificadoPract($id, $datos);
//var_dump($datos);
}



$fechaEmision = date("Y-m-d", strtotime($row['fecha_emision']));
$fechaIni = date("Y-m-d", strtotime($row['periodo_fecha_ini']));
$fechaFin = date("Y-m-d", strtotime($row['periodo_fecha_fin']));


?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/CertificadoPract/css/styles.css">
<script src="<?php echo base_url ?>admin/CertificadoPract/js/script.js" defer></script>
<script>
    const datosPorArea = <?= json_encode($certpract->obtenerMatriculacionActividades($student_id)) ?>;
</script>
<div class="card card-outline card-primary rounded-0 shadow">
   
    <div class="card-body">
    <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
        <div class="container-fluid">
            <div class="container-fluid">
            <form id="Cert_pract_frm" method="post" action="">
            <input type="hidden" name="id" value="<?php echo $row['id'] ? $id : '' ?>">

                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-2 end-column">
                                <label for="fecha_emision" class="control-label">Cuenca,  </label>
                                <input type="date" name="fecha_emision" id="fecha_emision" value="<?php echo $fechaEmision ?>"  class="form-control form-control-sm rounded-0" required>
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
                                                            $selected = (isset($row['tipo_practica']) && $row['tipo_practica'] === $p['area']) ? 'selected' : '';
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
                                <textarea name="malla_curricular" id="malla_curricular" class="form-control form-control-sm rounded-0" rows="3"  placeholder="Colocar la malla a la que pertenece el estudiante">
                                    <?php echo $row['malla_curricular']; ?>
                                </textarea>
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
                                    <option value="120" <?php echo ($row['cantidad_horas_pract'] == '120') ? 'selected' : ''; ?>>120 Horas</option>
                                    <option value="240" <?php echo ($row['cantidad_horas_pract'] == '240') ? 'selected' : ''; ?>>240 Horas</option>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Total de horas</strong></td>
                                <td>
                                <input type="number" name="total_horas_pract" id="total_horas_pract" value="<?php echo $row['total_horas_pract'] ?>" class="form-control form-control-sm rounded-0" placeholder="Ingrese el total de horas">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                        <input type="hidden" name="users_id" value="<?= $row['users_id'] ?>">
                        </fieldset>
                        <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Certificado de Practicas</button>
                            <a href="./?page=CertificadoPract" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
            </form>
        </div>
        </div>
    <?php endif;?>
</div>

</div>
