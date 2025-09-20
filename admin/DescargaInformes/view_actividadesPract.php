<?php

require_once '../config.php';
require_once('../classes/DescargaInforme.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $tipo_practica = $_GET['tipo'] ?? ''; 

    $base_url = "http://localhost:5170/api/DescargaFormatos"; 
    $DescargaInformes = new DescargaInforme($base_url);
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($id);

    $actPract = null;
    if(isset($row['actividadesPracticas']) && is_array($row['actividadesPracticas'])) {
        foreach($row['actividadesPracticas'] as $item) {
            if(isset($item['app_Tipo_pract']) && $item['app_Tipo_pract'] == $tipo_practica) {
                $actPract = $item;
                break;
            }
        }
    }
    
  


    $fechaIni = date("d/m/Y", strtotime($actPract['app_Fecha_ini'] ?? ''));
    $fechaFin = date("d/m/Y", strtotime($actPract['app_Fecha_fin'] ?? ''));
    $fechaConvenio = date("d/m/Y", strtotime($actPract['app_Fecha_firma_convenio'] ?? ''));
    $fechaTermino = date("d/m/Y", strtotime($actPract['app_Fecha_termino_convenio'] ?? ''));

    $nombreEstArray = explode(",", $actPract['app_Nom_est'] ?? '');
    $cedulaEstArray = explode(",", $actPract['app_Cedula_est'] ?? '');
    $celularEstArray = explode(",", $actPract['app_Celular_est'] ?? '');   
    $emailEstArray = explode(",", $actPract['app_Email_est'] ?? '');
?>

<!-- PAGINA ACTIVIDADES PRACTICAS -->

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-body">
        <div class="container-fluid" id="outprint-2">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <img src="../uploads/f-33.png" class="img-fluid" alt="" style="width: 100%;">
                    </div>
                </div>
                <br>
                <div class="subtitle">
                    <h5 class="card-title">PLANIFICACIÓN DE ACTIVIDADES DE LA PRÁCTICA PRE PROFESIONAL DE LOS ESTUDIANTES</h5>
                
                    <h5 class="card-title"> 1.	DATOS INFORMATIVOS DEL ORGANISMO, EMPRESA, INSTITUCIÓN DE CONTRAPARTE O PROYECTO</h5>
                </div>
                
            <br>
             <?php if($actPract): ?>

            <div class="card-body">
            <fieldset class="border-bottom">
                <table class="table table-bordered">
                    <tr>
                        <th>Empresa o Institución de Contraparte:</th>
                        <td><?php echo $actPract['app_Empresa_Institucion'] ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td><?php echo $actPract['app_Direccion'] ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td><?php echo $actPract['app_Telefono'] ?></td>
                    </tr>
                    <tr>
                        <th>E-mail:</th>
                        <td><?php echo $actPract['app_Email'] ?></td>
                    </tr>
                </table>
            </fieldset>

            <fieldset class="border-bottom">
                <table class="table table-bordered">
                    <tr>
                        <th>Área/Departamento y/o Proyecto:</th>
                        <td><?php echo $actPract['app_Area_dep_proyect'] ?></td>
                    </tr>
                    <tr>
                        <th>Asignaturas y/o Cátedra Integradora:</th>
                        <td><?php echo $actPract['app_Asignatura_Catedra'] ?></td>
                    </tr>
                    <tr>
                        <th>Tutor/a Externo:</th>
                        <td><?php echo $actPract['app_Tutor_ext'] ?></td>
                    </tr>
                    <tr>
                        <th>Cargo:</th>
                        <td><?php echo $actPract['app_Cargo'] ?></td>
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
                                    <td><?php echo $actPract['app_Convenio'] ?></td>
                                    <td><?php echo $fechaConvenio ?></td>
                                    <td><?php echo $fechaTermino ?></td>
                                </tr>
                            </table>
                        </fieldset>

                <hr class="custom-divider">
                <br>
                <h5 class="card-title">3.	DATOS DEL ESTUDIANTE</h5>
                        <br>
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
                        <br>
                        <fieldset class="border-bottom">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th style="width: 33%;">Nombre:</th>
                                    <th style="width: 33%;">Nº de cédula:</th>
                                    <th style="width: 34%;">E-mail:</th>
                                </tr>
                                <tr>
                                    <td><?php echo $actPract['app_Nombre_doc'] ?></td>
                                    <td><?php echo $actPract['app_Cedula_doc'] ?></td>
                                    <td><?php echo $actPract['app_Email_doc'] ?></td>
                                </tr>
                            </table>
                        </fieldset>
                <hr class="custom-divider">
                <br>
                <h5 class="card-title">5.	PERÍODO DE DURACIÓN DE LA PRÁCTICA PRE PROFESIONAL</h5>
                        <br>
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
            <?php else: ?>
                    <div class="container mt-5">
                        <div class="alert alert-danger text-center" role="alert">
                            No se encontraron registros para la práctica seleccionada.
                        </div>
                    </div>
                <?php endif; ?>
        </div>
    </div>
</div>
<?php 
}
?>