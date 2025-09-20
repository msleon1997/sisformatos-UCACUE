<?php
require_once '../config.php';
require_once('../classes/InformeFinal.php');



// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id de la URL
    $id = $_GET['id'];

    // URL base de la API
    $base_url = "http://localhost:5170/api/InformeFinal"; 

    // Crear una instancia del objeto Planificacion con la URL base
    $informeFinal = new InformeFinal($base_url);

    // Obtener los detalles del registro de planificación por su id
    $row = $informeFinal->obtenerInformeFinalPorId($id);

    $imagenesAnexos = explode(',', $row['anexos']);
    $imagenesAprobaciones = explode(',', $row['aprobaciones'])
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<link rel="stylesheet" href="<?php echo base_url ?>admin/Informe_final/css/styles.css">
<script src="<?php echo base_url ?>admin/Informe_final/js/view.js" defer></script>
<script src="<?php echo base_url ?>admin/Informe_final/js/script.js" defer></script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=Informe_final/manage_informe_final&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=Informe_final/delete_informe_final&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
            <?php endif; ?>
            <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
            <a href="./?page=Informe_final" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
        </div>
    </div>

        
    <div class="card-body">
        <div class="container-fluid" id="outprint">
            <h5 class="card-title"> INFORME FINAL DE ACTIVIDADES PRÁCTICA LABORAL Y/O DESERVICIO COMUNITARIO </h3>
            <br>
            <h4 class="card-title"> 1. DATOS INFORMATIVOS </h4>
        
            <br><br><br>

            <div class="container-fluid">
            <form id="InformeFinal_frm" method="post" action="">
                <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                    <tr>
                        <th style="border: 1px solid black;">Empresa/Institución de Contraparte y/o Proyecto:</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">
                        <input type="text" name="Empresa_Institucion_Proyecto" id="Empresa_Institucion_Proyecto" value="<?php echo $row['empresa_Institucion_Proyecto']; ?>" class="form-control form-control-sm rounded-0" required>
                        </td>
                    </tr>

                    <tr>
                        <th style="border: 1px solid black;">Tutor Externo:</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">
                        <input type="text" name="Tutor_externo" id="Tutor_externo" class="form-control form-control-sm rounded-0" value="<?php echo $row['tutor_externo']; ?>" placeholder="N/A">
                        </td>
                    </tr>

                    <tr>
                        <th style="border: 1px solid black;">Estudiante o (grupo de estudiantes):</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">
                            <div class="form-control form-control-sm rounded-0" style="height: auto;">
                                    <?php 
                                        echo nl2br(htmlspecialchars(str_replace(',', "\n", $row['autoevL_estudiante'])));
                                    ?>
                            </div>                    
                        </td>
                    </tr>

                    <tr>
                        <th style="border: 1px solid black;">Docente-Tutor:</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">
                        <input type="text" name="Docente_tutor" id="Docente_tutor"  value="<?php echo $row['docente_tutor']; ?>" class="form-control form-control-sm rounded-0">

                    
                        </td>
                    </tr>

                    <tr>
                        <th style="border: 1px solid black;">Período de prácticas:</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">
                        <input type="text" name="Periodo_practicas" id="Periodo_practicas" value="<?php echo $row['periodo_practicas']; ?>"  class="form-control form-control-sm rounded-0" required autofocus>
                        </td>
                    </tr>
                </table>



               
                <fieldset class="border-bottom">
                    <div class="row">
                    <div class="form-group col-md-12">
                        <label for="Introduccion" class="control-label">2. INTRODUCCIÓN:</label>
                        <textarea rows="20" name="Introduccion" id="Introduccion" class="form-control form-control-sm rounded-0" required>
                        <?php echo $row['introduccion']; ?>
                        </textarea>
                    </div>
                    </div>
                </fieldset>

                <div class="card-header">
                    
                    <h4 class="card-title">3. OBJETIVOS</h4>
                </div>
                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Obj_general" class="control-label">3.1. OBJETIVO GENERAL:  </label>
                                <textarea rows="4" name="Obj_general" id="Obj_general" value="<?php echo $row['periodo_practicas']; ?>" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['obj_general']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Obj_especifico" class="control-label">3.2. OBJETIVOS ESPECÍFICOS:  </label>
                                <textarea rows="8" name="Obj_especifico" id="Obj_especifico"  class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['obj_especifico']; ?>
                                </textarea>
                            </div>
                        </div>

                </fieldset>

                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Justificacion" class="control-label">4. JUSTIFICACIÓN:  </label>
                                <textarea rows="20" name="Justificacion" id="Justificacion" class="form-control form-control-sm rounded-0"  required>
                                     <?php echo $row['justificacion']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Antecedentes" class="control-label">5. ANTECEDENTES DE LA INSTITUCIÓN:  </label>
                                <textarea rows="20" name="Antecedentes" id="Antecedentes" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['antecedentes']; ?>
                                </textarea>
                            </div>
                        </div>
                </fieldset>

                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Mision_inst" class="control-label">5.1. Misión:  </label>
                                <textarea rows="6" name="Mision_inst" id="Mision_inst" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['mision_inst']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Vision_inst" class="control-label">5.2. Visión:  </label>
                                <textarea rows="6" name="Vision_inst" id="Vision_inst" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['vision_inst']; ?>
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Obj_inst" class="control-label">5.3. Objetivos de la Institución:  </label>
                                <textarea rows="10" name="Obj_inst" id="Obj_inst" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['obj_inst']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Valores_inst" class="control-label">5.4. Valores de la Institución:  </label>
                                <textarea rows="10" name="Valores_inst" id="Valores_inst" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['valores_inst']; ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="card-header">
                    
                            <h4 class="card-title">5.5. Beneficiarios de la UDIPSAI:
                            </h4>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Bene_directos" class="control-label">5.5.1. Directos:  </label>
                                <textarea rows="10" name="Bene_directos" id="Bene_directos" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['bene_directos']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Bene_indirectos" class="control-label">5.5.2. Indirectos:  </label>
                                <textarea rows="10" name="Bene_indirectos" id="Bene_indirectos" class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['bene_indirectos']; ?>
                                </textarea>
                            </div>
                        </div>
                </fieldset>
                <br>
                <fieldset>
                    <div class="card-header">
                        <h4 class="card-title">6. RESULTADOS DE APRENDIZAJE  A  LOS  QUE  CONTRIBUYE   LA   EJECUCIÓN   DE   LA   PRÁCTICA   LABORAL   O   SERVICIO  COMUNITARIO:</h4>
                    </div>
                    
                    <?php
                    // Dividir los datos en arrays
                    $asignaturas = explode(", ", $row['rA_asignatura']);  
                    $resultados = explode("|", $row['rA_resultado_aprendizaje']);
                    $perfiles = explode(";", $row['rA_perfil_egreso']);

                    $count = max(count($asignaturas), count($resultados), count($perfiles));

                    // Generar las tablas dinámicamente
                    for ($i = 0; $i < $count; $i++) {
                        echo "<table class='table-block' style='margin-bottom: 20px;'>";
                        echo "<tr><td><b>Asignatura:</b></td></tr>";
                        echo "<tr><td><input type='text' name='RA_asignatura[]' value='" . htmlspecialchars($asignaturas[$i] ?? '') . "' class='form-control form-control-sm rounded-0' required></td></tr>";

                        echo "<tr><td><b>Resultado de aprendizaje:</b></td></tr>";
                        echo "<tr><td><input type='text' name='RA_resultado_aprendizaje[]' value='" . htmlspecialchars($resultados[$i] ?? '') . "' class='form-control form-control-sm rounded-0' required></td></tr>";

                        echo "<tr><td><b>Perfil de egreso:</b></td></tr>";
                        echo "<tr><td><input type='text' name='RA_perfil_egreso[]' value='" . htmlspecialchars($perfiles[$i] ?? '') . "' class='form-control form-control-sm rounded-0' required></td></tr>";
                        echo "</table>"; 
                        
                    }
                    ?>
                </fieldset>


                <br>
                
                <fieldset class="border-bottom">
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Evaluacion_impacto" class="control-label">7. EVALUACIÓN DE IMPACTO EN LOS RESULTADOS DE APRENDIZAJE:  </label>
                                <textarea rows="8" name="Evaluacion_impacto" id="Evaluacion_impacto"  class="form-control form-control-sm rounded-0"  required>
                                     <?php echo $row['evaluacion_impacto']; ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Detalle_actividades" class="control-label"> 8. DETALLE DE LAS ACTIVIDADES REALIZADAS:  </label>
                                
                                <textarea rows="20" name="Detalle_actividades" id="Detalle_actividades"  class="form-control form-control-sm rounded-0"  required>
                                    <?php echo $row['detalle_actividades']; ?>
                                </textarea>
                            </div>
                        </div>
                        
                </fieldset>


                <fieldset>
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center;" >
                    <tr>
                        <th colspan="5" style="text-align: left;"> 9. AUTOEVALUACIÓN DEL ESTUDIANTE</th>
                    </tr>
                    <tr>
                        <th rowspan="2" style="width: 50%; text-align: left;">
                            <label class="control-label">Estudiantes:</label>
                            <div class="form-control form-control-sm rounded-0" style="height: auto;">
                                <?php 
                                    echo nl2br(htmlspecialchars(str_replace(',', "\n", $row['autoevL_estudiante'])));
                                ?>
                            </div>
                        </th>
                        <th colspan="5" style="text-align: left;"> Instrucciones: Estimado Estudiante, evalúe sincera y honestamente los indicadores 
                                de desempeño sobre su participación en las prácticas laborales y/o de servicio comunitario, marcando con una X en 
                                el casillero respectivo, que a continuación se detallan:</th>
                    </tr>
                    
                </table>
                </fieldset>
                <fieldset>
                
                    <div class="row">
                    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                        <tr>
                            
                            <th rowspan="2" style="width: 50%;"> INDICADORES DE DESEMPEÑO </th>
                            <th colspan="5">  Nomenclatura empleada  </th>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="width: 10%;">ALTO = 3</td>
                            <td style="width: 10%;">MEDIO = 2</td>
                            <td style="width: 10%;">BAJO = 1</td>
                        </tr>
                        <tr>
                            <td>1. Las prácticas laborales y/o de servicio comunitario aportaron en la
                            consolidación de los conocimientos para la vida profesional</td>
                            <td><input type="radio" name="AUTOEVL_pregunta1" id="AUTOEVL_pregunta1_3" value="3"<?php echo $row['autoevL_pregunta1'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta1" id="AUTOEVL_pregunta1_2" value="2"<?php echo $row['autoevL_pregunta1'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta1" id="AUTOEVL_pregunta1_1" value="1"<?php echo $row['autoevL_pregunta1'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>2. Acepté el horario establecido por la institución receptora</td>
                            <td><input type="radio" name="AUTOEVL_pregunta2" id="AUTOEVL_pregunta2_3" value="3"<?php echo $row['autoevL_pregunta2'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta2" id="AUTOEVL_pregunta2_2" value="2"<?php echo $row['autoevL_pregunta2'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta2" id="AUTOEVL_pregunta2_1" value="1"<?php echo $row['autoevL_pregunta2'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>3. Recibí y puse en práctica la orientación enseñanza aprendizaje por
                            parte del docente tutor.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta3" id="AUTOEVL_pregunta3_3" value="3"<?php echo $row['autoevL_pregunta3'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta3" id="AUTOEVL_pregunta3_2" value="2"<?php echo $row['autoevL_pregunta3'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta3" id="AUTOEVL_pregunta3_1" value="1"<?php echo $row['autoevL_pregunta3'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>4. Participé activa y efectivamente en las actividades grupales e
                            individuales</td>
                            <td><input type="radio" name="AUTOEVL_pregunta4" id="AUTOEVL_pregunta4_3" value="3"<?php echo $row['autoevL_pregunta4'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta4" id="AUTOEVL_pregunta4_2" value="2"<?php echo $row['autoevL_pregunta4'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta4" id="AUTOEVL_pregunta4_1" value="1"<?php echo $row['autoevL_pregunta4'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>5. Fui responsable con las obligaciones y actividades asignadas dentro
                            de mi campo</td>
                            <td><input type="radio" name="AUTOEVL_pregunta5" id="AUTOEVL_pregunta5_3" value="3"<?php echo $row['autoevL_pregunta5'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta5" id="AUTOEVL_pregunta5_2" value="2"<?php echo $row['autoevL_pregunta5'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta5" id="AUTOEVL_pregunta5_1" value="1"<?php echo $row['autoevL_pregunta5'] == 1? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>6. Respeté a las compañeras y compañeros que participaron en las
                            prácticas.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta6" id="AUTOEVL_pregunta6_3" value="3"<?php echo $row['autoevL_pregunta6'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta6" id="AUTOEVL_pregunta6_2" value="2"<?php echo $row['autoevL_pregunta6'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta6" id="AUTOEVL_pregunta6_1" value="1"<?php echo $row['autoevL_pregunta6'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>7. Demostré interés y motivación por intercambiar conocimientos
                            académicos</td>
                            <td><input type="radio" name="AUTOEVL_pregunta7" id="AUTOEVL_pregunta7_3" value="3"<?php echo $row['autoevL_pregunta7'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta7" id="AUTOEVL_pregunta7_2" value="2"<?php echo $row['autoevL_pregunta7'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta7" id="AUTOEVL_pregunta7_1" value="1"<?php echo $row['autoevL_pregunta7'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>8. Acepté las sugerencias del docente tutor: responsabilidad, actitud,
                            interés, etc.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta8" id="AUTOEVL_pregunta8_3" value="3"<?php echo $row['autoevL_pregunta8'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta8" id="AUTOEVL_pregunta8_2" value="2"<?php echo $row['autoevL_pregunta8'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta8" id="AUTOEVL_pregunta8_1" value="1"<?php echo $row['autoevL_pregunta8'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>9. Expuse con argumentos las ideas y conocimientos adquiridos en la
                            Universidad.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta9" id="AUTOEVL_pregunta9_3" value="3"<?php echo $row['autoevL_pregunta9'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta9" id="AUTOEVL_pregunta9_2" value="2"<?php echo $row['autoevL_pregunta9'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta9" id="AUTOEVL_pregunta9_1" value="1"<?php echo $row['autoevL_pregunta9'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>10. Aporté con conocimientos en la solución de casos presentados.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta10" id="AUTOEVL_pregunta10_3" value="3"<?php echo $row['autoevL_pregunta10'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta10" id="AUTOEVL_pregunta10_2" value="2"<?php echo $row['autoevL_pregunta10'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta10" id="AUTOEVL_pregunta10_1" value="1"<?php echo $row['autoevL_pregunta10'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>11. Di solución adecuada a problemas relacionados con las actividades
                            de prácticas.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta11" id="AUTOEVL_pregunta11_3" value="3"<?php echo $row['autoevL_pregunta11'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta11" id="AUTOEVL_pregunta11_2" value="2"<?php echo $row['autoevL_pregunta11'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta11" id="AUTOEVL_pregunta11_1" value="1"<?php echo $row['autoevL_pregunta11'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>12. Comprendí los contenidos y procedimientos presentados.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta12" id="AUTOEVL_pregunta12_3" value="3"<?php echo $row['autoevL_pregunta12'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta12" id="AUTOEVL_pregunta12_2" value="2"<?php echo $row['autoevL_pregunta12'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta12" id="AUTOEVL_pregunta12_1" value="1"<?php echo $row['autoevL_pregunta12'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>13. Desarrollé actividades de trabajo autónomo, cooperativo, entre otros.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta13" id="AUTOEVL_pregunta13_3" value="3"<?php echo $row['autoevL_pregunta13'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta13" id="AUTOEVL_pregunta13_2" value="2"<?php echo $row['autoevL_pregunta13'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta13" id="AUTOEVL_pregunta13_1" value="1"<?php echo $row['autoevL_pregunta13'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>14. Procuré la calidad en los documentos evidenciables.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta14" id="AUTOEVL_pregunta14_3" value="3"<?php echo $row['autoevL_pregunta14'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta14" id="AUTOEVL_pregunta14_2" value="2"<?php echo $row['autoevL_pregunta14'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta14" id="AUTOEVL_pregunta14_1" value="1"<?php echo $row['autoevL_pregunta14'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>15. Ejecuté las actividades de acuerdo con lo planificado.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta15" id="AUTOEVL_pregunta15_3" value="3"<?php echo $row['autoevL_pregunta15'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta15" id="AUTOEVL_pregunta15_2" value="2"<?php echo $row['autoevL_pregunta15'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta15" id="AUTOEVL_pregunta15_1" value="1"<?php echo $row['autoevL_pregunta15'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>16. Entregué a tiempo los informes para su validación.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta16" id="AUTOEVL_pregunta16_3" value="3"<?php echo $row['autoevL_pregunta16'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta16" id="AUTOEVL_pregunta16_2" value="2"<?php echo $row['autoevL_pregunta16'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta16" id="AUTOEVL_pregunta16_1" value="1"<?php echo $row['autoevL_pregunta16'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>17. Cumplí con las horas asignadas de prácticas laborales y/o de servicio comunitario.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta17" id="AUTOEVL_pregunta17_3" value="3"<?php echo $row['autoevL_pregunta17'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta17" id="AUTOEVL_pregunta17_2" value="2"<?php echo $row['autoevL_pregunta17'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta17" id="AUTOEVL_pregunta17_1" value="1"<?php echo $row['autoevL_pregunta17'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>18. Considero que la formación académica que recibí en la Universidad mesirvió para 
                                realizar las prácticas laborales y/o de servicio comunitario.</td>
                            <td><input type="radio" name="AUTOEVL_pregunta18" id="AUTOEVL_pregunta18_3" value="3"<?php echo $row['autoevL_pregunta18'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta18" id="AUTOEVL_pregunta18_2" value="2"<?php echo $row['autoevL_pregunta18'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="AUTOEVL_pregunta18" id="AUTOEVL_pregunta18_1" value="1"<?php echo $row['autoevL_pregunta18'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        
                    </table>
                    </div>
                </fieldset>

              
                <br>
                <fieldset>
                        <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="Conclusiones" class="control-label">10. CONCLUSIONES:  </label>
                                    <textarea rows="10" name="Conclusiones" id="Conclusiones" class="form-control form-control-sm rounded-0"  required>
                                        <?php echo $row['conclusiones']; ?>
                                    </textarea>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <label for="Recomendaciones" class="control-label">11. RECOMENDACIONES:  </label>
                                    <textarea rows="10" name="Recomendaciones" id="Recomendaciones" class="form-control form-control-sm rounded-0" required>
                                        <?php echo $row['recomendaciones']; ?>
                                    </textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="Biografia" class="control-label">12. BIBLIOGRAFÍA: </label>
                                    <textarea rows="10" name="Biografia" id="Biografia" class="form-control form-control-sm rounded-0" required>
                                        <?php echo $row['biografia']; ?>
                                    </textarea>
                                </div>
                            </div>


                </fieldset>

                <fieldset>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Anexos" class="control-label">13. ANEXOS (Fotos y evidencia relevante del proceso de la práctica):</label>
                                <h6>Carga todas las imagenes de las actividades que servirán como anexos</h6>

                                <!-- Mostrar todas las imágenes -->
                                <?php
                                $imagenesAnexos = explode(',', $row['anexos']);
                                foreach ($imagenesAnexos as $imagen) {
                                    echo "<img class='img-logo-empresa' src='" . $imagen . "' alt='Anexo imagen' style='max-width: 700px; max-height: 700px; margin: auto;'>";
                                }
                                ?>
                            </div>

                                
                            
                                <div class="form-group col-md-12">
                                    <label for="Aprobaciones" class="control-label">14. APROBACIÓN DEL INFORME POR PARTE DEL TUTOR: </label>
                                    <h6>Se solicita pegar en este espacio una imagen del correo electrónico institucional del estudiante a través del cual se remitió el presente informe.</h6>
                                    <!-- Mostrar todas las imágenes -->
                                <?php
                                $imagenesAprobaciones = explode(',', $row['aprobaciones']);
                                foreach ($imagenesAprobaciones as $imagen) {
                                    echo "<img class='img-logo-empresa' src='" . $imagen . "' alt='Aprobacion imagen' style='max-width: 700px; max-height: 700px; margin: auto;'>";
                                }
                                ?>
                                
                        </div>
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                            <input type="hidden" name="planificacion_id" value="<?php echo $planificacion_id ?>">


                </fieldset>
            <br><br>              
            </form>
        </div>
      </div>    
    </div>

</div>
<noscript id="print-header">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <img src="../uploads/f-37.png" class="img-fluid" alt="" style="max-width: 100%;">
        </div>
    </div>
    <br><br><br><br><br>
</noscript>

<?php 
}
?>

