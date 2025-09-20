<?php
require_once '../config.php';
require_once '../classes/CumplimientoHoras.php';

// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $base_url = "http://localhost:5170/api/CumplimientoHoras"; 

    $cumplimientoHoras = new CumplimientoHoras($base_url);

    $row = $cumplimientoHoras->obtenerCumplimientoHorasPorId($id);

    // Convertir la fecha al formato dd-mm-yy
    $fechaFormateada = date("d-m-y", strtotime($row['fecha']));
    


    $fechaArray = explode(", ", $row['fecha']);
    $hora_EntradaArray = explode(", ", $row['hora_Entrada']);
    $hora_SalidaArray = explode(", ", $row['hora_Salida']);
    $actividades_RealizadasArray = explode(", ", $row['actividades_Realizadas']);

?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/CumplimientoHoras/css/styles.css">
<script src="<?php echo base_url ?>admin/CumplimientoHoras/js/view.js" defer></script>

<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): // Usuario tipo 1 (Estudiante) ?>
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=CumplimientoHoras/manage_cumplimiento_horas&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=CumplimientoHoras/delete_cumplimiento_horas&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
            <?php endif; ?>        
                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=CumplimientoHoras" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
            <h5 class="card-title">REGISTRO DE HORAS DE PRÁCTICA PRE PROFESIONAL Y/O DE SERVICIO COMUNITARIO</h5>
            <br>
        </div>

        <div class="card-body">
            <div class="container-fluid" id="outprint">
                <fieldset class="border-bottom">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="empresa_institucion_proyecto" class="control-label">Empresa/Institución de Contraparte y/o Proyecto:</label>
                            <div class="form-control form-control-sm rounded-0"><?= $row['empresa_institucion_proyecto'] ?></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tutor_externo" class="control-label">Tutor Externo:</label>
                            <div class="form-control form-control-sm rounded-0"><?= $row['tutor_Externo'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="docente_tutor" class="control-label">Docente-Tutor:</label>
                            <div class="form-control form-control-sm rounded-0"><?= $row['docente_tutor'] ?></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="estudiante" class="control-label">Estudiante:</label>
                            <div class="form-control form-control-sm rounded-0"><?= $row['estudiante'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered" id="activity-table">
                            <colgroup>
                                <col width="15%">
                                <col width="15%">
                                <col width="15%">
                                <col width="50%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora Entrada</th>
                                    <th>Hora Salida</th>
                                    <th>Actividades realizadas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Asumimos que todas las cadenas tienen el mismo número de registros
                                    for ($i = 0; $i < count($fechaArray); $i++) {
                                        echo "<tr>";
                                        echo "<td><input type='date' name='fecha[]' value='" . htmlspecialchars($fechaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='hora_Entrada[]' value='" . htmlspecialchars($hora_EntradaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='hora_Salida[]' value='" . htmlspecialchars($hora_SalidaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='actividades_Realizadas[]' value='" . htmlspecialchars($actividades_RealizadasArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "</tr>";
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                    <br><br><br>
                 
                </fieldset>
            </div>
        </div>


        
    </div>
</div>

<noscript id="print-header">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <img src="../uploads/f-34.png" class="img-fluid" alt="" style="max-width: 100%;">
        </div>
    </div>
    <br><br><br><br><br>
</noscript>

<?php 
}
?>

