<?php
require_once '../config.php';
require_once('../classes/EvaluacionFinalCert.php');


// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $base_url = "http://localhost:5170/api/EvaluacionFinalCertificado"; 

    $evaluacionFinalCert = new EvaluacionFinalCert($base_url);

    $row = $evaluacionFinalCert->obtenerEvaluacionFinalCertPorId($id);


?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/EvaluacionFinalCertificado/css/styles.css">
<script src="<?php echo base_url ?>admin/EvaluacionFinalCertificado/js/view.js" defer></script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">EVALUACIÓN FINAL DE LA PRÁCTICA PRE PROFESIONAL</h3>
        
            <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): // Usuario tipo 1 (Estudiante) ?>

                <a class="btn btn-sm btn-primary btn-flat" href="./?page=EvaluacionFinalCertificado/manage_evaluacionFinalCert&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=EvaluacionFinalCertificado/delete_evaluacionFinalCert&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
                <?php endif; ?>

                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=EvaluacionFinalCertificado" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
    </div>
    
    <div class="card-body">
            <div class="container-fluid" id="outprint">
            <style>
                    #sys_logo {
                        width: 5em;
                        height: 5em;
                        object-fit: scale-down;
                        object-position: center center;
                    }
                </style>
               
            <form id="EvaluacionFinal_frm" method="post" action="">
                <fieldset class="border-bottom">
                        <div class="row">
                            <div class="ml-auto d-flex">
                                <div class="form-group col-md-6">
                                    <label for="FechaRegistro" class="control-label">Cuenca : </label>
                                </div>
                                <div class="form-group col-md-8">
                                    <div class=""><?php
                                            $fecha_registro = new DateTime($row['fechaRegistro']);
                                            echo $fecha_registro->format('d/m/Y'); 
                                            ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        
                        <div class="form-group col-md-12">
                            <h3>Doctor(a)</h3>
                            <label for="Nom_director_carrera" class="control-label">Nombre del Director de Carrera(A):</label>
                            <div class="name-dir"><?= $row['nom_director_carrera'] ?></div>
                            <br>
                            <h4 class="text-director">DIRECTOR DE CARRERA DE LA UNIDAD ACADÉMICA DE DESARROLLO DE SOFTWARE DE LA UNIVERSIDAD CATÓLICA DE CUENCA</h4>
                            <h6>Su despacho.-</h6>
                        </div>
                        <div class="form-group">
                            <p class="form-group col-md-12">Por medio de la presente reciba un cordial saludo, a su vez doy a conocer que <?= $row['nom_est'] ?>, 
                            con documento de identidad Nº <?= $row['num_cedula'] ?>, ha realizado su <?= $row['tipo_pract'] ?> en el área de <?= $row['area_desarrollo'] ?>, con una duración de 
                            <?= $row['duracion_horas'] ?> horas. El estudiante asistió a esta institución desde <?= (new DateTime($row['fecha_inicio']))->format('d/m/Y') ?> 
                            hasta <?= (new DateTime($row['fecha_fin']))->format('d/m/Y') ?>. 
                            <br>
                            Sus actividades las realizó de manera satisfactoria en esta institución.
                            <br>
                            Al presente adjunto la evaluación realizada al estudiante.</p>
                        </div>

							<div class="form-group col-md-6">
								<h6>Con sentimientos de consideración y estima, suscribo</h6>
							</div>

                            <div class="form-group col-md-12 text-center d-flex flex-column align-items-center">
                                <h6>Atentamente</h6>
                                <label for="Representante_empresa" class="control-label">Nombres y apellidos del representante legal:</label>
                                <div  class=" text-center" ><?= $row['representante_empresa'] ?></div>
                                <h5>CARGO REPRESENTANTE LEGAL INSTITUCIÓN</h5>
                            </div>


                            
                        </div>
                        <div class="card-header">
                            <h4 class="card-title">1. DATOS DEL ESTUDIANTE</h4>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Est_nombre" class="control-label">Nombres y apellidos:</label>
                                <div  class="form-control form-control-sm rounded-0"><?= $row['est_nombre'] ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Est_carrera" class="control-label">Carrera:</label>
                                <div class="form-control form-control-sm rounded-0"><?= $row['est_carrera'] ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Est_ciclo" class="control-label">Ciclo:</label>
                                <div  class="form-control form-control-sm rounded-0"><?= $row['est_ciclo'] ?></div>
                            </div>
                            
                        </div>

                        
                </fieldset>
                
               <br>

                <fieldset>
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center;" >
                    <tr>
                        <th colspan="5" style="text-align: left;">2. NOMENCLATURA EMPLEADA Y PARÁMETRO DE CALIFICACIÓN</th>
                    </tr>
                    <tr>
                        <td>Excelente <br> E = 5</td>
                        <td>Muy Bueno <br> MB = 4</td>
                        <td>Bueno <br> B = 3</td>
                        <td>Regular <br> R = 2</td>
                        <td>Malo <br> M = 1</td>
                    </tr>
                </table>
                </fieldset>
                <fieldset>
                    <div class="card-header">
                        <h4 class="card-title">3. INFORME TÉCNICO Y CALIFICACIÓN</h4>
                    </div>

                    <div class="row">
                    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                        <tr>
                            <th rowspan="2" style="width: 50%;">Responsabilidad y Cumplimiento de Actividades</th>
                            <th colspan="5">Parámetro de Calificación</th>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="width: 10%;">E = 5</td>
                            <td style="width: 10%;">MB = 4</td>
                            <td style="width: 10%;">B = 3</td>
                            <td style="width: 10%;">R = 2</td>
                            <td style="width: 10%;">M = 1</td>
                        </tr>
                        <tr>
                            <td>Asume con responsabilidad su práctica y acepta sugerencias</td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_5" value="5" <?php echo $row['rcaPregunta1'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_4" value="4" <?php echo $row['rcaPregunta1'] == 4  ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_3" value="3" <?php echo $row['rcaPregunta1'] == 3  ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_2" value="2" <?php echo $row['rcaPregunta1'] == 2  ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_1" value="1" <?php echo $row['rcaPregunta1'] == 1  ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>El cumplimiento del horario acordado en la planificación es</td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_5" value="5" <?php echo $row['rcaPregunta2'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_4" value="4" <?php echo $row['rcaPregunta2'] == 4 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_3" value="3" <?php echo $row['rcaPregunta2'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_2" value="2" <?php echo $row['rcaPregunta2'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_1" value="1" <?php echo $row['rcaPregunta2'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>Trata a las personas con igualdad y sin prejuicios o estereotipos</td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_5" value="5" <?php echo $row['rcaPregunta3'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_4" value="4" <?php echo $row['rcaPregunta3'] == 4 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_3" value="3" <?php echo $row['rcaPregunta3'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_2" value="2" <?php echo $row['rcaPregunta3'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_1" value="1" <?php echo $row['rcaPregunta3'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>Colabora en otras actividades programadas por la institución</td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_5" value="5" <?php echo $row['rcaPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_4" value="4" <?php echo $row['rcaPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_3" value="3" <?php echo $row['rcaPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_2" value="2" <?php echo $row['rcaPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_1" value="1" <?php echo $row['rcaPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td>Sobre el uso de terminología, expresión oral y escrita es</td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_5" value="5" <?php echo $row['rcaPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_4" value="4" <?php echo $row['rcaPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_3" value="3" <?php echo $row['rcaPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_2" value="2" <?php echo $row['rcaPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_1" value="1" <?php echo $row['rcaPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                        </tr>
                        <tr>
                            <td><strong for="Subtotal1">SUBTOTAL 1:</strong></td>
                            <td colspan="5">
                                <input type="text" name="Subtotal1" id="Subtotal1" readonly value="<?= $row['subtotal1'] ?>">
                                
                            </td>
                        </tr>
                    </table>

                       
                    </div>
                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                            <tr>
                                <th rowspan="2" style="width: 50%;">Área Cognoscitiva</th>
                                <th colspan="5">Parámetro de Calificación</th>
                            </tr>
                            <tr style="text-align: center;">
                                <td style="width: 10%;">E = 5</td>
                                <td style="width: 10%;">MB = 4</td>
                                <td style="width: 10%;">B = 3</td>
                                <td style="width: 10%;">R = 2</td>
                                <td style="width: 10%;">M = 1</td>
                            </tr>
                            <tr>
                                <td>Capacidad para identificar y definir problemas</td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="5" <?php echo $row['acPregunta1'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="4" <?php echo $row['acPregunta1'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="3" <?php echo $row['acPregunta1'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="2" <?php echo $row['acPregunta1'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="1" <?php echo $row['acPregunta1'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Aplica sus cocimientos para resolver problemas con facilidad</td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="5" <?php echo $row['acPregunta2'] == 5 ? 'checked' : ''; ?> ></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="4" <?php echo $row['acPregunta2'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="3" <?php echo $row['acPregunta2'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="2" <?php echo $row['acPregunta2'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="1" <?php echo $row['acPregunta2'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Capacidad para seleccionar procedimientos válidos</td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="5" <?php echo $row['acPregunta3'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="4" <?php echo $row['acPregunta3'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="3" <?php echo $row['acPregunta3'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="2" <?php echo $row['acPregunta3'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="1" <?php echo $row['acPregunta3'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Capacidad para interpretar y procesar información</td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="5" <?php echo $row['acPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="4" <?php echo $row['acPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="3" <?php echo $row['acPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="2" <?php echo $row['acPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="1" <?php echo $row['acPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Los conocimientos en el área para el uso de métodos y técnicas es</td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="5" <?php echo $row['acPregunta5'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="4" <?php echo $row['acPregunta5'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="3" <?php echo $row['acPregunta5'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="2" <?php echo $row['acPregunta5'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="1" <?php echo $row['acPregunta5'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td><strong for="Subtotal2">SUBTOTAL 2:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal2" id="Subtotal1" readonly value="<?= $row['subtotal2'] ?>">
                            </td>
                            </tr>
                        </table>
                    </div>

                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                            <tr>
                                <th rowspan="2" style="width: 50%;">Habilidades y Destrezas</th>
                                <th colspan="5">Parámetro de Calificación</th>
                            </tr>
                            <tr style="text-align: center;">
                                <td style="width: 10%;">E = 5</td>
                                <td style="width: 10%;">MB = 4</td>
                                <td style="width: 10%;">B = 3</td>
                                <td style="width: 10%;">R = 2</td>
                                <td style="width: 10%;">M = 1</td>
                            </tr>
                            <tr>
                                <td>Su capacidad de interrelación es</td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="5" <?php echo $row['hdPregunta1'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="4" <?php echo $row['hdPregunta1'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="3" <?php echo $row['hdPregunta1'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="2" <?php echo $row['hdPregunta1'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="1" <?php echo $row['hdPregunta1'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>La puntualidad en la presentación de trabajos es</td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="5" <?php echo $row['hdPregunta2'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="4" <?php echo $row['hdPregunta2'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="3" <?php echo $row['hdPregunta2'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="2" <?php echo $row['hdPregunta2'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="1" <?php echo $row['hdPregunta2'] == 1 ? 'checked' : ''; ?>></td>
                            </tr> 
                            <tr> 
                                <td>Su capacidad de trabajo en equipo es</td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="5" <?php echo $row['hdPregunta3'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="4" <?php echo $row['hdPregunta3'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="3" <?php echo $row['hdPregunta3'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="2" <?php echo $row['hdPregunta3'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="1" <?php echo $row['hdPregunta3'] == 1 ? 'checked' : ''; ?>></td>
                            </tr> 
                            <tr> 
                                <td>La ética en el desempeño de sus labores es</td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="5" <?php echo $row['hdPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="4" <?php echo $row['hdPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="3" <?php echo $row['hdPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="2" <?php echo $row['hdPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="1" <?php echo $row['hdPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                            </tr> 
                            <tr> 
                                <td>La responsabilidad y el cumplimiento de su trabajo es</td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="5" <?php echo $row['hdPregunta5'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="4" <?php echo $row['hdPregunta5'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="3" <?php echo $row['hdPregunta5'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="2" <?php echo $row['hdPregunta5'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="1" <?php echo $row['hdPregunta5'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                             <tr>
                                <td><strong for="Subtotal3">SUBTOTAL 3:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal3" id="Subtotal3" readonly value="<?= $row['subtotal3'] ?>">
                            </td>
                            </tr>
                        </table>
                    </div>

                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                            <tr>
                                <th rowspan="2" style="width: 50%;">Área Actitudinal</th>
                                <th colspan="5">Parámetro de Calificación</th>
                            </tr>
                            <tr style="text-align: center;">
                                <td style="width: 10%;">E = 5</td>
                                <td style="width: 10%;">MB = 4</td>
                                <td style="width: 10%;">B = 3</td>
                                <td style="width: 10%;">R = 2</td>
                                <td style="width: 10%;">M = 1</td>
                            </tr>

                            <tr>
                                <td>Posee destreza en el manejo de equipos</td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="5" <?php echo $row['aaPregunta1'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="4" <?php echo $row['aaPregunta1'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="3" <?php echo $row['aaPregunta1'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="2" <?php echo $row['aaPregunta1'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="1" <?php echo $row['aaPregunta1'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Precisión y cumplimiento en las labores designadas</td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="5" <?php echo $row['aaPregunta2'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="4" <?php echo $row['aaPregunta2'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="3" <?php echo $row['aaPregunta2'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="2" <?php echo $row['aaPregunta2'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="1" <?php echo $row['aaPregunta2'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Planifica y desarrolla las actividades en forma ordenada</td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="5" <?php echo $row['aaPregunta3'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="4" <?php echo $row['aaPregunta3'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="3" <?php echo $row['aaPregunta3'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="2" <?php echo $row['aaPregunta3'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="1" <?php echo $row['aaPregunta3'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Domina operaciones y procesos tecnológicos</td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="5" <?php echo $row['aaPregunta4'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="4" <?php echo $row['aaPregunta4'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="3" <?php echo $row['aaPregunta4'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="2" <?php echo $row['aaPregunta4'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="1" <?php echo $row['aaPregunta4'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td>Es original y creativo en el desarrollo del trabajo</td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="5" <?php echo $row['aaPregunta5'] == 5 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="4" <?php echo $row['aaPregunta5'] == 4 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="3" <?php echo $row['aaPregunta5'] == 3 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="2" <?php echo $row['aaPregunta5'] == 2 ? 'checked' : ''; ?>></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="1" <?php echo $row['aaPregunta5'] == 1 ? 'checked' : ''; ?>></td>
                            </tr>
                            <tr>
                                <td><strong for="Subtotal4">SUBTOTAL 4:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal4" id="Subtotal4" readonly value="<?= $row['subtotal4'] ?>">
                                
                            </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                            <tr>
                                <div class="form-group col-md-12">
                                    <td><strong for="Subtotal1">TOTAL (Sobre 100 puntos):</strong></td>
                                    <td colspan="5"><input type="text" name="Total" id="Total"  value="<?php echo  $row['total'] ?>">
                                </div>
                            </td>
                              
                            </tr>
                            
                        </table>
                       
                    </div>
                </fieldset>

              
                <br>
                <fieldset>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="Observaciones" class="control-label">4.	OBSERVACIONES DEL TUTOR(A) DE LA EMPRESA/INSTITUCIÓN:  </label>
                                    <textarea rows="4" name="Observaciones" id="Observaciones" readonly class="form-control form-control-sm rounded-0" ><?= $row['observaciones'] ?></textarea>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <label for="Recomendaciones" class="control-label">5.	RECOMENDACIONES DEL TUTOR(A) DE LA EMPRESA/INSTITUCIÓN:  </label>
                                    <textarea rows="4" name="Recomendaciones" id="Recomendaciones" readonly class="form-control form-control-sm rounded-0" ><?= $row['recomendaciones'] ?></textarea>
                                </div>
                                
                            </div>

                        


                </fieldset>
                <br><br>

                <fieldset>
                            <div class="form-group col-md-12 text-center d-flex flex-column align-items-center">
                                    
                                    <div  class=" text-center" ><?= $row['nombre_Tutor_empresa'] ?></div>
                                    <label for="Nombre_Tutor_empresa" class="control-label">Nombre y Apellido </label>
                                    <Strong>TUTOR(A)</Strong>
                                    <div  class=" text-center" ><?= $row['nombre_empresa'] ?></div>
                                    <img class="img-logo-empresa" src="<?= $row['logo_empresa'] ?>" alt="" style="width:250px" >
                            </div>
                            <div type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                </fieldset>
                    
            </form>
            </div>

    </div>

    

</div>
<!-- Agregar cabecera en el pdf -->
<noscript id="print-header">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <img src="../uploads/f-36.png" class="img-fluid" alt="" style="max-width: 100%;">
        </div>
    </div>
    <br><br><br><br><br>
</noscript>

<?php 
}
?>

