<?php
require_once '../config.php';
require_once('../classes/ActPract.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id de la URL
    $id = $_GET['id'];

    // URL base de la API
    $base_url = "http://localhost:5170/api/ActividadesPracticas"; 

    $ActPract = new ActPract($base_url);
    
    $row = $ActPract->obtenerActPractPorId($id);

    // Verificar si se obtuvieron datos
    // Convertir la fecha al formato dd-mm-yy
    $fechaIni = date("d/m/Y", strtotime($row['app_Fecha_ini']));
    $fechaFin = date("d/m/Y", strtotime($row['app_Fecha_fin']));
    $fechaConvenio = date("d/m/Y", strtotime($row['app_Fecha_firma_convenio']));
    $fechaTermino = date("d/m/Y", strtotime($row['app_Fecha_termino_convenio']));

    $nombreEstArray = explode(",", $row['app_Nom_est']);
    $cedulaEstArray = explode(",", $row['app_Cedula_est']);
    $celularEstArray = explode(",", $row['app_Celular_est']);   
    $emailEstArray = explode(",", $row['app_Email_est']);
?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/js/view.js" defer></script>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
        <div class="card-tools">
        <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): // Usuario tipo 1 (Estudiante) ?>
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=ActPract/manage_actpract&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=ActPract/delete_actpract&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
        <?php endif; ?>        
                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=ActPract" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
            
        </div>
        <div class="container-fluid" id="outprint">
            <div class="subtitle">
                <h2 class="card-title">PLANIFICACIÓN DE ACTIVIDADES DE LA PRÁCTICA PRE PROFESIONAL DE LOS ESTUDIANTES</h2>
                <br>
                <h5 class="card-title"> 1.	DATOS INFORMATIVOS DEL ORGANISMO, EMPRESA, INSTITUCIÓN DE CONTRAPARTE O PROYECTO</h5>
            </div>
           
            <br>
            <div class="card-body">
            <fieldset class="border-bottom">
                <table class="table table-bordered">
                    <tr>
                        <th>Empresa o Institución de Contraparte:</th>
                        <td><?php echo $row['app_Empresa_Institucion'] ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td><?php echo $row['app_Direccion'] ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td><?php echo $row['app_Telefono'] ?></td>
                    </tr>
                    <tr>
                        <th>E-mail:</th>
                        <td><?php echo $row['app_Email'] ?></td>
                    </tr>
                </table>
            </fieldset>

            <fieldset class="border-bottom">
                <table class="table table-bordered">
                    <tr>
                        <th>Área/Departamento y/o Proyecto:</th>
                        <td><?php echo $row['app_Area_dep_proyect'] ?></td>
                    </tr>
                    <tr>
                        <th>Asignaturas y/o Cátedra Integradora:</th>
                        <td><?php echo $row['app_Asignatura_Catedra'] ?></td>
                    </tr>
                    <tr>
                        <th>Tutor/a Externo:</th>
                        <td><?php echo $row['app_Tutor_ext'] ?></td>
                    </tr>
                    <tr>
                        <th>Cargo:</th>
                        <td><?php echo $row['app_Cargo'] ?></td>
                    </tr>
                </table>
            </fieldset>


                  
                <hr class="custom-divider">
                <br>
                <h5 class="card-title">2.	RELACIÓN ACADÉMICA ENTRE EL ORGANISMO, EMPRESA, INSTITUCIÓN DE CONTRAPARTE O PROYECTO Y LA UCACUE</h5>
                        <br><br>
                        <fieldset class="border-bottom">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th style="width: 33%;">Mantienen un:</th>
                                    <th style="width: 33%;">Fecha de Firma Convenio:</th>
                                    <th style="width: 34%;">Fecha de Término del Convenio:</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row['app_Convenio'] ?></td>
                                    <td><?php echo $fechaConvenio ?></td>
                                    <td><?php echo $fechaTermino ?></td>
                                </tr>
                            </table>
                        </fieldset>

                <hr class="custom-divider">
                <br>
                <h5 class="card-title">3.	DATOS DEL ESTUDIANTE</h5>
                        <br><br>
                        <?php
                            $totalRegistros = count($nombreEstArray); 

                            for ($i = 0; $i < $totalRegistros; $i++) {
                                echo "<fieldset class='border-bottom mb-3'>";
                                echo "<table class='table table-bordered text-center'>";
                                
                                echo "<tr>";
                                echo "<th style='width: 25%;'>Nombres:</th>";
                                echo "<td colspan='2' style='width: 75%;'><input type='text' name='app_Nom_est[]' value='" . htmlspecialchars($nombreEstArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<th style='width: 33%;'>Nº de cédula:</th>";
                                echo "<th style='width: 33%;'>Nº celular:</th>";
                                echo "<th style='width: 33%;'>E-mail:</th>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><input type='text' name='app_Cedula_est[]' value='" . htmlspecialchars($cedulaEstArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                echo "<td><input type='text' name='app_Celular_est[]' value='" . htmlspecialchars($celularEstArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                echo "<td><input type='text' name='app_Email_est[]' value='" . htmlspecialchars($emailEstArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                echo "</tr>";

                                echo "</table>";
                                echo "</fieldset>";
                            }
                            ?>

                        </fieldset>


                <hr class="custom-divider">
                <br>
                <h5 class="card-title">4.	DATOS DEL DOCENTE-TUTOR</h5>
                        <br><br>
                        <fieldset class="border-bottom">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th style="width: 33%;">Nombre:</th>
                                    <th style="width: 33%;">Nº de cédula:</th>
                                    <th style="width: 34%;">E-mail:</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row['app_Nombre_doc'] ?></td>
                                    <td><?php echo $row['app_Cedula_doc'] ?></td>
                                    <td><?php echo $row['app_Email_doc'] ?></td>
                                </tr>
                            </table>
                        </fieldset>
                <hr class="custom-divider">
                <br>
                <h5 class="card-title">5.	PERÍODO DE DURACIÓN DE LA PRÁCTICA PRE PROFESIONAL</h5>
                        <br><br>
                        <fieldset class="border-bottom">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th style="width: 50%;">Fecha de inicio práctica:</th>
                                    <th style="width: 50%;">Fecha de finalización de práctica:</th>
                                </tr>
                                <tr>
                                    <td><?php echo $fechaIni ?></td>
                                    <td><?php echo $fechaFin ?></td>
                                </tr>
                            </table>
                        </fieldset>

            </div>
        </div>
        
    </div>
</div>

<?php 
 
}
?>

<noscript id="print-header">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <img src="../uploads/f-33.png" class="img-fluid" alt="" style="max-width: 100%;">
        </div>
    </div>
    <br><br><br><br><br>
</noscript>

