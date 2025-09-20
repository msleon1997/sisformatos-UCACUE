
<?php
require_once '../config.php';
require_once('../classes/ActaCompro.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$base_url = "http://localhost:5170/api/ActaCompromiso";
$actaCompro = new ActaCompro($base_url);

    $user_id = $_settings->userdata('id');
    $i = 1;

$obtenerMatriculas = $actaCompro->obtenerMatriculaciones($user_id);
$datosEst = $obtenerMatriculas[0] ?? null;



if ($_SERVER["REQUEST_METHOD"] == "POST") {

$datos = array(
    "Acta_TipoPractica" => $_POST["Acta_TipoPractica"] ?? '',
    "Acta_NombresEstudiante" => implode("; ", $_POST["Acta_NombresEstudiante"] ?? ''),
    "Acta_Carrera" => implode("; ", $_POST["Acta_Carrera"] ?? ''),
    "Acta_UnidadAcademica" => implode("; ", $_POST["Acta_UnidadAcademica"] ?? ''),
    "Acta_NombreEmpresa" => implode("; ", $_POST["Acta_NombreEmpresa"] ?? ''),
    "users_id" => $_POST["users_id"]
);

$respuesta = $actaCompro->crearActaCompro($datos);

}



?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/ActaCompro/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/ActaCompro/js/script.js" defer></script>
<script>
    const datosPorArea = <?= json_encode($actaCompro->obtenerMatriculaciones($user_id)) ?>;
</script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">ANEXOS</h3>
        <br>
        <h5 class="card-title"> 1.	ACTA DE COMPROMISO</h5>
    </div>
    <?php if ($_settings->userdata('type') == 1):  ?>
        <p class="subtitle">En caso de ser estudiante lider de grupo deberá agregar de los demás estudiantes que conforman su grupo</p>
    <div class="container mt-5">
        <form id="ActaCompromiso_frm" method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <div id="fieldsets-container">
                    <div class="fieldset-container">
                    <?php if ($_settings->userdata('lider_group') == 1):  ?>
                    <button class="add-btn" type="button" onclick="addFieldset()">Agregar Más</button>
                    <?php endif; ?>
                        <p>
                            Yo, 
                            
                            <input type="text" class="form-control form-control-sm rounded-0" required id="Acta_NombresEstudiante" name="Acta_NombresEstudiante[]" placeholder="Nombres y apellidos completos del estudiante"  value="<?php echo $datosEst['firstname_est'] ." ". $datosEst['lastname_est']?? '' ?>" >, estudiante de la carrera de 
                            <input type="text" class="form-control form-control-sm rounded-0" required id="Acta_Carrera" name="Acta_Carrera[]" placeholder="Carrera" value="<?php echo $datosEst['carrera']  ?? ''?>"> de la Unidad Académica de 
                            <input type="text" class="form-control form-control-sm rounded-0" required id="Acta_UnidadAcademica" name="Acta_UnidadAcademica[]" placeholder="Unidad Académica" value="Desarrollo de Software de la Universidad Católica de Cuenca" >, por medio de la presente me comprometo con 
                            <input type="text" class="form-control form-control-sm rounded-0" required id="Acta_NombreEmpresa" name="Acta_NombreEmpresa[]" value="<?php echo $datosEst['nombre_institucion']  ?? ''?>" placeholder="nombre completo de la empresa, organización o institución y/o proyecto de servicio comunitario">. A fin de llevar a cabo las  
                            <?php
                            $obtenerMatriculas = $actaCompro->obtenerMatriculaciones($user_id);
                            $datosEst = $obtenerMatriculas[0] ?? null;

                            $areasUnicas = [];
                            $selectOptionsHtml = '<option value="">Seleccione un área</option>';
                            foreach ($obtenerMatriculas as $m) {
                                if (!in_array($m['area'], $areasUnicas)) {
                                    $areasUnicas[] = $m['area'];
                                    $selectOptionsHtml .= '<option value="' . htmlspecialchars($m['area']) . '">' . htmlspecialchars($m['area']) . '</option>';
                                }
                            }
                            ?>

                            <select name="Acta_TipoPractica" id="Acta_TipoPractica" class="form-control form-control-sm rounded-0 select2" required>
                                <?php echo $selectOptionsHtml; ?>
                            </select>
                            
                            <script>
                                const selectOptionsHTML = `<?= $selectOptionsHtml ?>`;
                            </script>
                            , con responsabilidad y total acatamiento a las disposiciones y normas internas de la entidad auspiciadora y/o Proyecto, del Reglamento e Instructivo de prácticas de la Universidad Católica de Cuenca y dando cumplimiento a la presente planificación.
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">

                        </p>
                        </div>

                       
                        <?php if ($_settings->userdata('lider_group') == 1):  ?>
                        <button class="remove-btn"  type="button" onclick="removeFieldset(this)">Quitar</button>
                        <?php endif; ?>

                       <div class="form-group signature-container">
                        <!-- <p class="firma">FIRMA DEL ESTUDIANTE</p> -->
                        </div>
                    </div>
                </div>

            <div class="card-footer text-right">
                <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Acta</button>
                <a href="./?page=ActPract/ActaCompro" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
            </div>
        </form>
    </div>
    <?php endif; ?>


    <?php if ($_settings->userdata('type') == 2): ?>
    <div class="container mt-3">
        <label for="searchInput">BUSCAR REGISTRO</label>
        <input type="text" id="searchInput" placeholder="Buscar por Nombres del Estudiante, carrera, unidad academica, etc." class="form-control mb-3">
    </div>
    <?php endif; ?>

    <br>
    <div class="card-body">
    <div class="container-fluid">  
    <div class="tabla-scrollable">
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="15%">
                        <col width="12%">
                        <col width="10%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th class="col-1">Tipo Práctica</th>
                            <th class="col-2">Nombres y apellidos completos del estudiante</th>
                            <th class="col-3">Carrera</th>
                            <th class="col-4">Unidad Académica</th>
                            <th class="col-5">Nombre de la Empresa</th>
                            <th class="col-6">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/ActaCompromiso/detailsByUser"; 
                        $base_urlDoc = "http://localhost:5170/api/ActaCompromiso"; 

                        $actaCompro = new ActaCompro($base_url);
                        $actaComproDoc = new ActaCompro($base_urlDoc);
                        $user_type = $_settings->userdata('type');

                        // Obtener el ID del usuario actualmente logueado
                         $user_id = $_settings->userdata('id');

                         if ($user_type == 1) {
                            $qry = $actaCompro->obtenerActaComproPorUser($user_id);

                            
                        } else if ($user_type == 2) {

                            $qry = $actaComproDoc->obtenerActaCompro($base_urlDoc);

                        }

                        
                         foreach ($qry as $row) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class="">
                                        <p class=""><?php echo $row['acta_TipoPractica'] ?></p>
                                    </td>
                                    <td class="">
                                        <p class=""><?php echo $row['acta_NombresEstudiante'] ?></p>
                                    </td>
                                    <td class="">
                                        <p class=""><?php echo $row['acta_Carrera'] ?></p>
                                    </td>
                                  <td class="">
                                      <p class=""><?php echo $row['acta_UnidadAcademica'] ?></p>
                                    </td>
                                  <td class="">
                                      <p class=""><?php echo $row['acta_NombreEmpresa'] ?></p>
                                    </td>
                                  
                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="./?page=ActPract/ActaCompro/view_acta&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                            <?php if ($_settings->userdata('type') == 1) : ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item edit_data" href="./?page=ActPract/ActaCompro/manage_acta&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_data" href="./?page=ActPract/ActaCompro/delete_acta&id=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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