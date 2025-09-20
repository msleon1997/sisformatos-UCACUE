<?php

require_once '../config.php';
require_once('../classes/DescargaInforme.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'] ?? null;
    $tipo_practica = $_GET['tipo'] ?? null;

    $base_url = "http://localhost:5170/api/DescargaFormatos";
    $DescargaInformes = new DescargaInforme($base_url);
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($user_id);

    $cumplimientoHoras = null;
     if(isset($row['cumplimientoHoras']) && is_array($row['cumplimientoHoras'])) {
        foreach($row['cumplimientoHoras'] as $item) {
            if(isset($item['tipo_area']) && $item['tipo_area'] == $tipo_practica) {
                $cumplimientoHoras = $item;
                break;
            }
        }
    }


    $fechaArray = explode(", ", $cumplimientoHoras['fecha'] ?? '');
    $hora_EntradaArray = explode(", ", $cumplimientoHoras['hora_Entrada'] ?? '');
    $hora_SalidaArray = explode(", ", $cumplimientoHoras['hora_Salida'] ?? '');
    $actividades_RealizadasArray = explode(", ", $cumplimientoHoras['actividades_Realizadas'] ?? '');
?>


<link rel="stylesheet" href="<?php echo base_url ?>admin/CumplimientoHoras/css/styles.css">
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-body">
        <div class="container-fluid" id="outprint-5">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <img src="../uploads/f-34.png" class="img-fluid" alt="" style="width: 100%;">
                    </div>
                </div>
                <br><br>
                <div class="form-group text-center">
                    <h5 class="card-title">8. REGISTRO DE HORAS DE PRÁCTICA PRE PROFESIONAL Y/O DE SERVICIO COMUNITARIO</h5>
                    <br>
                </div>
                <br>

             <?php if($cumplimientoHoras): ?>
        <div class="card-body">
            <div class="container-fluid">
                    <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="empresa_institucion_proyecto" class="control-label">Empresa/Institución de Contraparte y/o Proyecto:</label>
                                <div class="form-control form-control-sm rounded-0"><?= $cumplimientoHoras['empresa_institucion_proyecto'] ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tutor_externo" class="control-label">Tutor Externo:</label>
                                <div class="form-control form-control-sm rounded-0"><?= $cumplimientoHoras['tutor_Externo'] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="docente_tutor" class="control-label">Docente-Tutor:</label>
                                <div class="form-control form-control-sm rounded-0"><?= $cumplimientoHoras['docente_tutor'] ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="estudiante" class="control-label">Estudiante:</label>
                                <div class="form-control form-control-sm rounded-0"><?= $cumplimientoHoras['estudiante'] ?></div>
                            </div>
                        </div>
                        <div class="row-table">
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
                                        for ($i = 0; $i < count($fechaArray); $i++) {
                                            echo "<tr>";
                                            echo "<td><input type='date' name='fecha[]' value='" . htmlspecialchars($fechaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                            echo "<td><input type='text' name='hora_Entrada[]' value='" . htmlspecialchars($hora_EntradaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                            echo "<td><input type='text' name='hora_Salida[]' value='" . htmlspecialchars($hora_SalidaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                            echo "<td><textarea name='actividades_Realizadas[]' class='form-control form-control-sm rounded-0' required>" . htmlspecialchars($actividades_RealizadasArray[$i]) . "</textarea></td>";
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
            <?php else: ?>
                    <div class="container mt-5">
                        <div class="alert alert-danger text-center" role="alert">
                            No se encontraron registros para la práctica seleccionada.
                        </div>
                    </div>
                <?php endif; ?>
                <br>
                
        </div>
</div>




<?php

}
?>