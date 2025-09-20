<?php

require_once '../config.php';
require_once('../classes/DescargaInforme.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'] ?? null;
    $tipo_practica = $_GET['tipo'] ?? null;

    $base_url = "http://localhost:5170/api/DescargaFormatos";
    $DescargaInformes = new DescargaInforme($base_url);
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($user_id);

    $informeTutorias = null;
     if(isset($row['informesTutorias']) && is_array($row['informesTutorias'])) {
        foreach($row['informesTutorias'] as $item) {
            if(isset($item['area_desarrollo']) && $item['area_desarrollo'] == $tipo_practica) {
                $informeTutorias = $item;
                break;
            }
        }
    }


    $rutaZip = $informeTutorias['anexos'] ?? '';
    $fechaIni = date("d-m-y", strtotime($informeTutorias['fecha_inicio'] ?? '')) ;
    $fechaFin = date("d-m-y", strtotime($informeTutorias['fecha_fin'] ?? ''));
    $fechaAprovacion1 = date("d-m-y", strtotime($informeTutorias['fecha_aprovacion1']?? '')); 
    $fechaAprovacion2 = date("d-m-y", strtotime($informeTutorias['fecha_aprovacion2'] ?? ''));
    $fechaAprovacion3 = date("d-m-y", strtotime($informeTutorias['fecha_aprovacion3'] ?? ''));

    $cedulasArray = explode("; ", $informeTutorias['est_cedula']?? ''); 
    $apellidosArray = explode("; ", $informeTutorias['est_apellidos']?? ''); 
    $nombresArray = explode("; ", $informeTutorias['est_nombres']?? ''); 
    $ciclosArray = explode("; ", $informeTutorias['est_ciclo']?? ''); 

    $diaArray = explode(";", $informeTutorias['dia']?? '');
    $mesArray = explode(";", $informeTutorias['mes']?? '');
    $anoArray = explode(";", $informeTutorias['ano']?? '');
    $temaArray = explode(";", $informeTutorias['tema_consulta']?? '') ;
    $cicloArray = explode(";", $informeTutorias['rT_Ciclo']?? '') ;
    $modalidadArray = explode(";", $informeTutorias['modalidad']?? '') ;
    $rTEstudianteArray = explode(";", $informeTutorias['rT_Estudiante']?? '') ;
    $rTCedula_estArray = explode(";", $informeTutorias['rT_Cedula_est']?? '') ;

    $imagenesAnexos = explode(';', $informeTutorias['anexos']?? '') ;
    
   
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<link rel="stylesheet" href="<?php echo base_url ?>admin/InformeTutorias/css/styles.css">
<script src="<?php echo base_url ?>admin/InformeTutorias/js/script.js" defer></script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-body">
        <div class="container-fluid" id="outprint-9">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <img src="../uploads/f-38.png" class="img-fluid" alt="" style="width: 100%;">
                    </div>
                </div>
                <br><br>
                <div class="form-group text-center">
                    <h3 class="card-title">INFORME DE TUTORÍA DE PRÁCTICAS LABORALES Y/O. DE SERVICIO COMUNITARIO  </h3>
                    <br>
                    <h4 class="card-title"> 1. DATOS </h4>
                </div>
                <br>

             <?php if($informeTutorias): ?>

          <form id="InformeTutorias_frm" method="post" action="">
            <table border="1" width="100%" cellspacing="0" cellpadding="8">
                <colgroup>
                    <col width="5%">
                    <col width="7%">
                    <col width="15%">
                </colgroup>
                <tr>
                    <td>
                        <label for="Docente_tutor" class="control-label">Nombres Docente Tutor/a:</label>
                        <input type="text" name="Docente_tutor" id="Docente_tutor" value="<?php echo $informeTutorias['docente_tutor']; ?>" class="form-control form-control-sm rounded-0">
                    </td>
                    <td>
                        <label for="Docente_tutor_est" class="control-label">Nombres del Docente Tutor/a Externo:</label>
                        <input type="text" name="Docente_tutor_est" id="Docente_tutor_est" value="<?php echo $informeTutorias['docente_tutor_est']; ?>" class="form-control form-control-sm rounded-0">
                    </td>
                    <td>
                        <label for="Empresa_proyecto" class="control-label">Empresa/Organización y/o Proyecto:</label>
                        <input type="text" name="Empresa_proyecto" id="Empresa_proyecto" value="<?php echo $informeTutorias['empresa_proyecto']; ?>" class="form-control form-control-sm rounded-0">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Periodo_practicas" class="control-label">Periodo de Prácticas:</label>
                        <input type="text" name="Periodo_practicas" id="Periodo_practicas" value="<?php echo $informeTutorias['periodo_practicas']; ?>" class="form-control form-control-sm rounded-0">
                    </td>
                    <td>
                        <label for="Carrera_est" class="control-label">Carrera:</label>
                        <input type="text" name="Carrera_est" id="Carrera_est" value="<?php echo $informeTutorias['carrera_est']; ?>" class="form-control form-control-sm rounded-0">
                    </td>
                    <td>
                        <label for="Area_desarrollo" class="control-label">Área de desarrollo de Prácticas:</label>
                        <input type="text" name="Area_desarrollo" id="Area_desarrollo" value="<?php echo $informeTutorias['area_desarrollo']; ?>" class="form-control form-control-sm rounded-0">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="Fecha_inicio" class="control-label">Fecha Inicio:</label>
                        <input type="text" name="Fecha_inicio" id="Fecha_inicio" value="<?php echo $fechaIni; ?>" class="form-control form-control-sm rounded-0" required>
                    </td>
                    <td>
                        <label for="Director_carrera" class="control-label">Director/a de Carrera:</label>
                        <input type="text" name="Director_carrera" id="Director_carrera" value="<?php echo $informeTutorias['director_carrera']; ?>" class="form-control form-control-sm rounded-0" required>
                    </td>
                    <td>
                        <label for="Institucion" class="control-label">Institución/Universidad:</label>
                        <input type="text" value="Universidad Católica de Cuenca" class="form-control form-control-sm rounded-0">
                    </td>
                </tr>
            </table>
                        <br><br>
                        <h4 class="card-title">2.	DATOS DEL ESTUDIANTE</h4>
                        <br><br>
                        <div class="table-responsive">
                            <table border="1" width="100%" cellspacing="0" cellpadding="8">
                                <thead>
                                    <tr>
                                        <th class="text-center">Cédula</th>
                                        <th class="text-center">Apellidos</th>
                                        <th class="text-center">Nombres</th>
                                        <th class="text-center">Ciclo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Asumimos que todas las cadenas tienen el mismo número de registros
                                    for ($i = 0; $i < count($cedulasArray); $i++) {
                                        echo "<tr>";
                                        echo "<td><input type='text' name='Est_cedula[]' value='" . htmlspecialchars($cedulasArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='Est_apellidos[]' value='" . htmlspecialchars($apellidosArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='Est_nombres[]' value='" . htmlspecialchars($nombresArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='Est_ciclo[]' value='" . htmlspecialchars($ciclosArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Introduccion" class="control-label">3. Introducción:</label>
                                <h6>Información relevante acorde al entorno de la realización de las prácticas. (Lugar, periodo de Prácticas)</h6>
                                <textarea rows="20" name="Introduccion" id="Introduccion-tutorias" class="form-control form-control-sm rounded-0" required>
                                <?php echo $informeTutorias['introduccion']; ?>
                                </textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Descripcion_actividades" class="control-label">4. Descripción de actividades:</label>
                                <h6>Tareas realizadas( incluir los temas de las tutorías dadas ya sea grupal o individual)</h6>
                                <textarea rows="20" name="Descripcion_actividades" id="Descripcion_actividades" class="form-control form-control-sm rounded-0" required>
                                <?php echo $informeTutorias['descripcion_actividades']; ?>
                                </textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Conclusion" class="control-label">5. Conclusión:</label>
                                <h6>Beneficios adquiridos por parte del estudiante, síntesis de las nuevas competencias adquiridas. Es importante resaltar los beneficios de este período de prácticas en la formación. </h6>
                                <textarea rows="20" name="Conclusion" id="Conclusion" class="form-control form-control-sm rounded-0" required>
                                <?php echo $informeTutorias['conclusion']; ?>
                                </textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border-bottom">
                            <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Observaciones" class="control-label">6. Observaciones:</label>
                                <h6>
                                Hechos o Situaciones que se hayan presentado en el transcurso de la realización de las prácticas , no contempladas en  el plan realizado 
                                </h6>
                                <textarea rows="20" name="Observaciones" id="Observaciones-tutorias" class="form-control form-control-sm rounded-0" required>
                                <?php echo $informeTutorias['observaciones']; ?>
                                </textarea>
                            </div>
                            </div>
                        </fieldset>
                        <br>
                        
                        <div class="page-break"></div>
                        <fieldset>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Anexos" class="control-label">7. ANEXOS:</label>
                                <h6>Carga todas las imagenes de las actividades que servirán como anexos</h6>

                                <!-- Mostrar todas las imágenes -->
                                <?php
                                $imagenesAnexos = explode(';', $informeTutorias['anexos']);
                                foreach ($imagenesAnexos as $imagen) {
                                    echo "<img class='img-anexo' src='" . $imagen . "' alt='Anexo imagen' style='max-width: 100%; margin: auto; width: 100%; display: block;'>";
                                }
                                ?>
                            </div>
                        </div>
                            
                        </fieldset>
                        <br>
                        
                        
                        <div class="page-break"></div>
                        <fieldset>
                            <div class="card-header">
                                <h3 class="card-title">8. REGISTRO DE TUTORÍAS DE PRÁCTICAS LABORAL Y/O DE SERVICIO COMUNITARIO</h3>
                            </div>
                            <table border="1" width="100%" cellspacing="0" cellpadding="8">
                                <tr>
                                <td><strong>UNIDAD ACADÉMICA DE:</strong></td>
                                <td colspan="3">
                                    <span  name="Unidad_academica" id="Unidad_academica"> <?php echo $informeTutorias['unidad_academica']; ?></span>
                                </td>
                                </tr>
                                <tr>
                                <td><strong>COMPONENTE TEMÁTICO:</strong></td>
                                <td colspan="3">
                                    <span  name="Componente_tematico" id="Componente_tematico"> <?php echo $informeTutorias['componente_tematico']; ?></span>
                                </td>
                                </tr>
                                <tr>
                                <td><strong>DOCENTE TUTOR:</strong></td>
                                <td colspan="3">
                                    <span  name="Docente_tutor" id="Docente_tutor">  <?php echo $informeTutorias['docente_tutor']; ?> </span>
                                </td>
                                </tr>
                            </table>
                            <table border="1" width="100%" cellspacing="0" cellpadding="8">
                                <colgroup>
                                    <col width="5%">
                                    <col width="13%">
                                    <col width="15%">
                                    <col width="5%">
                                    <col width="5%">
                                    <col width="20%">
                                    <col width="10%">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>FECHA</th>
                                        <th>TEMA DE CONSULTA</th>
                                        <th>NIVEL (CICLO)</th>
                                        <th>MODALIDAD DE TUTORÍA</th>
                                        <th>NOMBRE DEL/LA ESTUDIANTE</th>
                                        <th>NO. DE CÉDULA O PASAPORTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    for ($i = 0; $i < count($diaArray); $i++) {
                                        echo "<tr>";
                                        echo "<td>" . ($i + 1) . "</td>";
                                        
                                        echo "<td>
                                                <span type='text' name='Dia[]' placeholder='Día' >" . htmlspecialchars($diaArray[$i]).'/' .  "</span>
                                                <span type='text' name='Mes[]' placeholder='Mes' >" . htmlspecialchars($mesArray[$i]).'/' .  "</span>
                                                <span type='text' name='Ano[]' placeholder='Año' >" . htmlspecialchars($anoArray[$i]) .  "</span>
                                            </td>";
                                        
                                        echo "<td><span >" . htmlspecialchars($temaArray[$i]) . "</span></td>";
                                        echo "<td><span >" . htmlspecialchars($cicloArray[$i]) . "</span></td>";
                                        echo "<td><span >" . htmlspecialchars($modalidadArray[$i]) . "</span></td>";
                                        echo "<td><span >" . htmlspecialchars($rTEstudianteArray[$i]) . "</span></td>";
                                        echo "<td><span >" . htmlspecialchars($rTCedula_estArray[$i]) . "</span></td>";

                                        
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </fieldset>
                        <br>
                        
                        <fieldset>
                            <div class="card-header text-center">
                                <h3 class="card-title">9. FIRMA Y ACEPTACIÓN</h3>
                            </div>
                            <table border="1" width="100%" cellspacing="0" cellpadding="8">
                                <thead>
                                <tr>
                                    <th>RESPONSABILIDADES</th>
                                    <th>ACCIÓN</th>
                                    <th>FECHA</th>
                                    <th>FIRMA Y SELLO</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                    <label for="Responsable_docente_tutor" class="control-label"><strong>Nombre y Apellido<br>Docente Tutor:</strong></label>
                                    <input type="text" name="Responsable_docente_tutor" id="Responsable_docente_tutor"  value="<?php echo $informeTutorias['responsable_docente_tutor']; ?>" class="form-control form-control-sm rounded-0">
                                    </td>
                                    <td><input type="text" name="Accion_1" id="Accion_1" value="<?php echo $informeTutorias['accion_1']; ?>" class="form-control form-control-sm rounded-0"></td>
                                    <td>
                                    <input type="text" name="Fecha_aprovacion1" id="Fecha_aprovacion1" value="<?php echo $fechaAprovacion1; ?>" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                    <td>
                                    <br><br>
                                    _____________________________
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <label for="Responsable_ptt" class="control-label"><strong>Nombre y Apellido<br>Docente Responsable de PPP de la Carrera:</strong></label>
                                    <input type="text" name="Responsable_ptt" id="Responsable_ptt"  value="<?php echo $informeTutorias['responsable_ptt']; ?>" class="form-control form-control-sm rounded-0">
                                    </td>
                                    <td><input type="text" name="Accion_2" id="Accion_2" value="<?php echo $informeTutorias['accion_2']; ?>" class="form-control form-control-sm rounded-0"></td>
                                    <td>
                                    <input type="text" name="Fecha_aprovacion2" id="Fecha_aprovacion2" value="<?php echo $fechaAprovacion2; ?>" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                    <td>
                                    <br><br>
                                    _____________________________
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <label for="Responsable_dic_carrera" class="control-label"><strong>Nombre y Apellido<br>Director de Carrera:</strong></label>
                                    <input type="text" name="Responsable_dic_carrera" id="Responsable_dic_carrera" value="<?php echo $informeTutorias['responsable_dic_carrera']; ?>" class="form-control form-control-sm rounded-0">
                                    </td>
                                    <td><input type="text" name="Accion_3" id="Accion_3" value="<?php echo $informeTutorias['accion_3']; ?>" class="form-control form-control-sm rounded-0"></td>
                                    <td>
                                    <input type="text" name="Fecha_aprovacion3" id="Fecha_aprovacion3" value="<?php echo $fechaAprovacion3; ?>" class="form-control form-control-sm rounded-0" required>
                                    </td>
                                    <td>
                                    <br><br>
                                    _____________________________
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                            <input type="hidden" name="planificacion_id" value="<?php echo $planificacion_id ?>">
                            </fieldset>
                        <br><br>
        </form>  

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
</div>

<?php
}
?>