<?php
require_once '../config.php';
require_once('../classes/Planificacion.php');

// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id de la URL
    $id = $_GET['id'];

    // URL base de la API
    $base_url = "http://localhost:5170/api/Planificacion"; 

    // Crear una instancia del objeto Planificacion con la URL base
    $planificacion = new Planificacion($base_url);

    // Obtener los detalles del registro de planificación por su id
    $row = $planificacion->obtenerPlanificacionPorId($id);
?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/planificacion/css/styles.css">
<script src="<?php echo base_url ?>admin/planificacion/js/view.js" defer></script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=planificacion/manage_planificacion&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=planificacion/delete_planificacion&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
            <?php endif; ?>
            <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
            <a href="./?page=planificacion" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
        </div>
    </div>

    <div class="card-body">
        <div class="container-fluid" id="outprint">
            <h5 class="card-title">PLANIFICACIÓN DE ACTIVIDADES DE LAS PRÁCTICAS DE LOS ESTUDIANTES</h5>

            <style>
                #sys_logo {
                    width: 5em;
                    height: 5em;
                    object-fit: scale-down;
                    object-position: center center;
                }
                /* Estilo para hacer la tabla scrollable */
                .table-responsive {
                    max-height: 600px;
                    overflow-y: auto;
                    display: block;
                }
                .table {
                    width: 100%;
                    table-layout: fixed;
                }
                .table th, .table td {
                    white-space: nowrap;
                    text-overflow: ellipsis;
                    overflow: hidden;
                }
            </style>
            <br><br><br>

            <form id="Planificacion_frm" method="post" action="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Carrera</th>
                            <th>Área</th>
                            <th>Docente Responsable de Prácticas</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['tP_Carrera']; ?></td>
                            <td><?php echo $row['tP_Area']; ?></td>
                            <td><?php echo $row['tP_Docente']; ?></td>
                        </tr>

                        <tr>
                            <th>Ciclo</th>
                            <th>Cátedra Integradora</th>
                            <th>Proyecto Integrador</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['tP_Ciclo']; ?></td>
                            <td><?php echo $row['tP_Categra_Int']; ?></td>
                            <td><?php echo $row['tP_Proyecto_Integrador']; ?></td>
                        </tr>

                        <tr>
                            <th>Proyecto de Servicio Comunitario</th>
                            <th>Número de estudiantes que deben hacer prácticas</th>
                            <th>Nómina de estudiantes asignados</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['tP_Proyecto_Serv_Com']; ?></td>
                            <td><?php echo $row['tP_Num_Est_Pract']; ?></td>
                            <td>
                                <ul>
                                    <?php
                                    $estudiantes = explode(',', $row['tP_Nomina_est_asig']);
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
                            <td><?php echo $row['estudianteLider']; ?></td>
                            <td><?php echo $row['tP_Horas_Pract']; ?></td>
                            <td><?php echo $row['tP_Act_Realizar']; ?></td>
                        </tr>

                        <tr>
                            <th>Docente Tutor asignado por grupo de estudiantes</th>
                            <th>Instituciones o Empresas</th>
                            <th>Propuesta en la que va a participar</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['tP_Docente_tutor']; ?></td>
                            <td><?php echo $row['tP_Inst_Emp']; ?></td>
                            <td><?php echo $row['tP_Propuesta']; ?></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<noscript id="print-header">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <img src="../uploads/f-31.png" class="img-fluid" alt="" style="max-width: 100%;">
        </div>
    </div>
</noscript>

<script>
    $(function() {
        $('#print').click(function() {
            start_loader();
            var _h = $('head').clone();
            var _p = $('#outprint').clone();  
            var _ph = $('noscript#print-header').html();
            var _el = $('<div>');
            
            _p.find('.badge').css({'border': 'unset'});
            
            _el.append(_h);
            _el.append(_ph);
            _el.append(_p);

            var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200');
            nw.document.write(_el.html());
            nw.document.close();

            setTimeout(() => {
                nw.print();
                setTimeout(() => {
                    nw.close();
                    end_loader();
                }, 300);
            }, (750));
        });
    });
</script>

<?php 
}
?>
