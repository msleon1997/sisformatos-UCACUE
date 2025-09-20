
<?php
require_once '../config.php';
require_once('../classes/ActaCompro.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}



$id = $_GET['id'];

$base_url = "http://localhost:5170/api/ActaCompromiso"; 

$actaCompro = new ActaCompro($base_url);
  $user_id = $_settings->userdata('id');
    $i = 1;



$row = $actaCompro->obtenerActaComproPorUser($id);
$student_id = $row['users_id'];
$obtenerMatriculas = $actaCompro->obtenerMatriculaciones($student_id);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
    $datos = array(
        "id" => $_POST["id"],
        "Acta_TipoPractica" => implode("; ", $_POST["Acta_TipoPractica"]),
        "Acta_NombresEstudiante" => implode("; ", $_POST["Acta_NombresEstudiante"]),
        "Acta_Carrera" => implode("; ", $_POST["Acta_Carrera"]),
        "Acta_UnidadAcademica" => implode("; ", $_POST["Acta_UnidadAcademica"]),
        "Acta_NombreEmpresa" => implode("; ", $_POST["Acta_NombreEmpresa"]),
        "users_id" => $_POST["users_id"]
    );

    $respuesta = $actaCompro->actualizarActaCompro($id, $datos);

    //var_dump($datos);
}



?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/ActaCompro/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/ActaCompro/js/script.js" defer></script>
<script>
    const datosPorArea = <?= json_encode($actaCompro->obtenerMatriculaciones($student_id)) ?>;
</script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">ANEXOS</h3>
        <br>
        <h5 class="card-title"> 1.	ACTA DE COMPROMISO</h5>
        <?php if ($_settings->userdata('lider_group') == 1):  ?>
        <button class="add-btn" type="button" onclick="addFieldset()">Agregar Más</button>
        <?php endif; ?>
    </div>

    <div class="container mt-5">
        <form id="ActaCompromiso_frm" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row["id"] ?>">

        <div id="fieldsets-container">
                            <?php
                            $tipoPractica = isset($row['acta_TipoPractica']) ? explode("; ", $row['acta_TipoPractica']) : [];
                            $nombreEst = isset($row['acta_NombresEstudiante']) ? explode("; ", $row['acta_NombresEstudiante']) : [];
                            $actaEst = isset($row['acta_Carrera']) ? explode("; ", $row['acta_Carrera']) : [];
                            $actaAcademica = isset($row['acta_UnidadAcademica']) ? explode("; ", $row['acta_UnidadAcademica']) : [];
                            $actaEmpresa = isset($row['acta_NombreEmpresa']) ? explode("; ", $row['acta_NombreEmpresa']) : [];

                            for ($i = 0; $i < count($nombreEst); $i++) {
                                ?>
                                <br> <br> <br>
                                <div class="fieldset-container">
                                <div class="form-group">
                                    <p>
                                        Yo, 
                                        <input type="text" class="form-control form-control-sm rounded-0" 
                                        required id="Acta_NombresEstudiante" name="Acta_NombresEstudiante[]" 
                                        placeholder="Nombres y apellidos completos del estudiante" 
                                        value="<?php echo $nombreEst[$i]; ?>" >, estudiante de la carrera de 
                                        
                                        <input type="text" class="form-control form-control-sm rounded-0" 
                                        required id="Acta_Carrera" name="Acta_Carrera[]" placeholder="Carrera" 
                                        value="<?php echo $actaEst[$i]; ?>" > de la Unidad Académica de 
                                        
                                        <input type="text" class="form-control form-control-sm rounded-0" 
                                        required id="Acta_UnidadAcademica" name="Acta_UnidadAcademica[]" 
                                        placeholder="Unidad Académica" value="<?php echo $actaAcademica[$i]; ?>" >, por medio de la presente me comprometo con 
                                        
                                        <input type="text" class="form-control form-control-sm rounded-0" 
                                        required id="Acta_NombreEmpresa" name="Acta_NombreEmpresa[]" 
                                        placeholder="nombre completo de la empresa, organización o institución y/o proyecto de servicio comunitario" 
                                        value="<?php echo $actaEmpresa[$i]; ?>">. A fin de llevar a cabo las
                                        <?php
                                        $obtenerMatriculas = $actaCompro->obtenerMatriculaciones($user_id);
                                        $datosEst = $obtenerMatriculas[0] ?? null;

                                        $areasUnicas = [];
                                        $selectOptionsHtml = '<option value="">Seleccione un área</option>';
                                        foreach ($obtenerMatriculas as $m) {
                                            if (!in_array($m['area'], $areasUnicas)) {
                                                $areasUnicas[] = $m['area'];
                                                $selected = (isset($tipoPractica[$i]) && $tipoPractica[$i] === $m['area']) ? 'selected' : '';
                                                $selectOptionsHtml .= '<option value="' . htmlspecialchars($m['area']) . '" ' . $selected . '>' . htmlspecialchars($m['area']) . '</option>';
                                            }
                                        }
                                        ?>

                                        <select name="Acta_TipoPractica[]" id="Acta_TipoPractica_<?php echo $i; ?>" class="form-control form-control-sm rounded-0 select2" required>
                                            <?php echo $selectOptionsHtml; ?>
                                        </select>
                                        
                                        <script>
                                            const selectOptionsHTML = `<?= $selectOptionsHtml ?>`;
                                        </script>
                                        , con responsabilidad y total acatamiento a las disposiciones y normas internas de la entidad auspiciadora y/o Proyecto, del Reglamento e Instructivo de prácticas de la Universidad Católica de Cuenca y dando cumplimiento a la presente planificación.
                                        
                                        <input type="hidden" name="users_id" value="<?= $row['users_id'] ?>">

                                    </p>

                                </div>
                                 <?php if ($_settings->userdata('lider_group') == 1):  ?>
                                    <button class="remove-btn" type="button" onclick="removeFieldset(this)">Quitar</button>
                                 <?php endif; ?>
                                </div>
                                <?php
                            }
                            ?>
        </div>



            
            <br> <br> <br>

            <div class="card-footer text-right">
                <button class="btn btn-flat btn-primary btn-sm" type="submit">Actualizar Acta</button>
                <a href="./?page=ActPract/ActaCompro" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
            </div>
        </form>
    </div>
</div>
