<?php

require_once '../config.php';
require_once('../classes/DescargaInforme.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $tipo_practica = $_GET['tipo'] ?? ''; 

    $base_url = "http://localhost:5170/api/DescargaFormatos"; 
    $DescargaInformes = new DescargaInforme($base_url);
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($id);

    $planificacion = null;
    if(isset($row['planificaciones']) && is_array($row['planificaciones'])) {
        foreach($row['planificaciones'] as $item) {
            if(isset($item['tP_Area']) && $item['tP_Area'] == $tipo_practica) {
                $planificacion = $item;
                break;
            }
        }
    }



?>

<!-- PAGINA PLANIFICACION -->
       

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-body">
        <div class="container-fluid" id="outprint-1">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <img src="../uploads/f-33.png" class="img-fluid" alt="" style="width: 100%;">
                    </div>
                </div>
                <br><br>
                <div class="form-group text-center">
                    <h3 class="card-title">PLANIFICACIÓN DE ACTIVIDADES DE LAS PRÁCTICAS DE LOS ESTUDIANTES </h3>
                </div>
            

             <?php if($planificacion): ?>
            <form id="Planificacion_frm" method="post" action="">
                <div class="table-responsive">
                    <h5 class="card-title">Información sobre la planificación del estudiante</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Carrera</th>
                            <th>Área</th>
                            <th>Docente Responsable de Prácticas</th>
                        </tr>
                        <tr>
                            <td><?php echo $planificacion['tP_Carrera']; ?></td>
                            <td><?php echo $planificacion['tP_Area']; ?></td>
                            <td><?php echo $planificacion['tP_Docente']; ?></td>
                        </tr>

                        <tr>
                            <th>Ciclo</th>
                            <th>Cátedra Integradora</th>
                            <th>Proyecto Integrador</th>
                        </tr>
                        <tr>
                            <td><?php echo $planificacion['tP_Ciclo']; ?></td>
                            <td><?php echo $planificacion['tP_Categra_Int']; ?></td>
                            <td><?php echo $planificacion['tP_Proyecto_Integrador']; ?></td>
                        </tr>

                        <tr>
                            <th>Proyecto de Servicio Comunitario</th>
                            <th>Número de estudiantes que deben hacer prácticas</th>
                            <th>Nómina de estudiantes asignados</th>
                        </tr>
                        <tr>
                            <td><?php echo $planificacion['tP_Proyecto_Serv_Com']; ?></td>
                            <td><?php echo $planificacion['tP_Num_Est_Pract']; ?></td>
                            <td>
                                <ul>
                                    <?php
                                    $estudiantes = explode(',', $planificacion['tP_Nomina_est_asig']);
                                    foreach ($estudiantes as $estudiante) {
                                        echo "<li>" . trim($estudiante) . "</li>";
                                    }
                                    ?>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th>Nombre estudiante</th>
                            <th>Número de Horas de Práctica</th>
                            <th>Actividades a realizar</th>
                        </tr>
                        <tr>
                            <td><?php echo $planificacion['estudianteLider']; ?></td>
                            <td><?php echo $planificacion['tP_Horas_Pract']; ?></td>
                            <td><?php echo $planificacion['tP_Act_Realizar']; ?></td>
                        </tr>

                        <tr>
                            <th>Docente Tutor asignado por grupo de estudiantes</th>
                            <th>Instituciones o Empresas</th>
                            <th>Propuesta en la que va a participar</th>
                        </tr>
                        <tr>
                            <td><?php echo $planificacion['tP_Docente_tutor']; ?></td>
                            <td><?php echo $planificacion['tP_Inst_Emp']; ?></td>
                            <td><?php echo $planificacion['tP_Propuesta']; ?></td>
                        </tr>
                    </table>
                </div>
            </form>
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