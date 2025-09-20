<?php

require_once '../config.php';
require_once('../classes/EvaluacionFinalCert.php');


$base_url = "http://localhost:5170/api/EvaluacionFinalCertificado"; 
$evaluacionFinalCert = new EvaluacionFinalCert($base_url);

$user_id = $_settings->userdata('id');
$i = 1;

$stmt = $conn->prepare("SELECT *, CONCAT(firstname_est, ' ', lastname_est) AS fullname 
                     FROM matriculacion 
                     WHERE users_id = ? 
                     ORDER BY fullname ASC");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();


$estudiante = $result->fetch_assoc();

$obtenerActividades = $evaluacionFinalCert->obtenerActividadesPorUser($user_id);
$stmt = $conn->prepare("SELECT DISTINCT area FROM area_docente WHERE users_id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$practicas = [];
while ($row = $result->fetch_assoc()) {
    $practicas[] = $row['area'];
}
$stmt->close();
//var_dump($obtenerActividades);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $logo_empresa = '';

  
    

    if (isset($_FILES['logo_empresa'])) {
        $fileError = $_FILES['logo_empresa']['error'];
    
        if ($fileError == UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            $fileName = basename($_FILES['logo_empresa']['name']);
            $targetFilePath = $uploadDir . $fileName;
            
            $_FILES['logo_empresa']['name'] . "<br>";
            $targetFilePath . "<br>"; 
    
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
             if (in_array(strtolower($fileType), $allowedTypes)) {
                if (move_uploaded_file($_FILES['logo_empresa']['tmp_name'], $targetFilePath)) {
                    //echo "Archivo movido exitosamente.";
                    $logo_empresa = $targetFilePath; 
                } else {
                   // echo "Error al mover el archivo.";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Tipo de archivo no permitido.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=EvaluacionFinalCertificado';
                    }
                });
                    </script>";
                exit;
            }
        } else {
           
        }
    } else {
        echo "
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'No se encontró ningún archivo para subir.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './?page=EvaluacionFinalCertificado';
                    }
                });
                </script>
                ";
        exit;
    }
    

   
    

    $datos = array(
        "Nom_director_carrera" => $_POST["Nom_director_carrera"] ?? '',
        "Nom_est" => $_POST["Nom_est"] ?? '',
        "Num_cedula" => $_POST["Num_cedula"] ?? '',
        "Tipo_pract" => $_POST["Tipo_pract"] ?? '',
        "Area_desarrollo" => $_POST["Area_desarrollo"] ?? '',
        "Duracion_horas" => $_POST["Duracion_horas"] ?? '',
        "Fecha_inicio" => $_POST["Fecha_inicio"] ?? '',
        "Fecha_fin" => $_POST["Fecha_fin"] ?? '',
        "Representante_empresa" => $_POST["Representante_empresa"] ?? '',
        "Est_nombre" => $_POST["Est_nombre"] ?? '',
        "Est_carrera" => $_POST["Est_carrera"] ?? '',
        "Est_ciclo" => $_POST["Est_ciclo"],
        "RCAPregunta1" => $_POST["RCAPregunta1"] ?? '',
        "RCAPregunta2" => $_POST["RCAPregunta2"] ?? '',
        "RCAPregunta3" => $_POST["RCAPregunta3"] ?? '',
        "RCAPregunta4" => $_POST["RCAPregunta4"] ?? '',
        "RCAPregunta5" => $_POST["RCAPregunta5"] ?? '',
        "Subtotal1" => $_POST["Subtotal1"] ?? '',
        "ACPregunta1" => $_POST["ACPregunta1"] ?? '',
        "ACPregunta2" => $_POST["ACPregunta2"] ?? '',
        "ACPregunta3" => $_POST["ACPregunta3"] ?? '',
        "ACPregunta4" => $_POST["ACPregunta4"] ?? '',
        "ACPregunta5" => $_POST["ACPregunta5"] ?? '',
        "Subtotal2" => $_POST["Subtotal2"] ?? '',
        "HDPregunta1" => $_POST["HDPregunta1"] ?? '',
        "HDPregunta2" => $_POST["HDPregunta2"] ?? '',
        "HDPregunta3" => $_POST["HDPregunta3"] ?? '',
        "HDPregunta4" => $_POST["HDPregunta4"] ?? '',
        "HDPregunta5" => $_POST["HDPregunta5"] ?? '',
        "Subtotal3" => $_POST["Subtotal3"] ?? '',
        "AAPregunta1" => $_POST["AAPregunta1"] ?? '',
        "AAPregunta2" => $_POST["AAPregunta2"] ?? '',
        "AAPregunta3" => $_POST["AAPregunta3"] ?? '',
        "AAPregunta4" => $_POST["AAPregunta4"] ?? '',
        "AAPregunta5" => $_POST["AAPregunta5"] ?? '',
        "Subtotal4" => $_POST["Subtotal4"] ?? '',
        "Total" => $_POST["Total"] ?? '',
        "Observaciones" => $_POST["Observaciones"] ?? '',
        "Recomendaciones" => $_POST["Recomendaciones"] ?? '',
        "FechaRegistro" => $_POST["FechaRegistro"] ?? '',
        "Nombre_Tutor_empresa" => $_POST["Nombre_Tutor_empresa"] ?? '',
        "Nombre_empresa" => $_POST["Nombre_empresa"] ?? '',
        "logo_empresa" => $logo_empresa,
        "users_id" => $_POST["users_id"]
    );

    $respuesta = $evaluacionFinalCert->crearEvaluacionFinalCert($datos);

}

?>



<link rel="stylesheet" href="<?php echo base_url ?>admin/EvaluacionFinalCertificado/css/styles.css">
<script src="<?php echo base_url ?>admin/EvaluacionFinalCertificado/js/script.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const actividadesPorArea = <?= json_encode($evaluacionFinalCert->obtenerActividadesPorUser($user_id)) ?>;
</script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">EVALUACIÓN FINAL DE LA PRÁCTICA PRE PROFESIONAL</h3>
        <br>
    </div>
        
    <div class="card-body">

         <?php if ($_settings->userdata('type') == 1) : ?>
            <div class="container-fluid">
            <form id="EvaluacionFinal_frm" method="post" action="" enctype="multipart/form-data">
                    <fieldset class="border-bottom">
                        <div class="row">
                            <div class="ml-auto d-flex">
                                <div class="form-group col-md-5">
                                    <label for="FechaRegistro" class="control-label">Cuenca : </label>
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="date" name="FechaRegistro" id="FechaRegistro" autofocus class="form-control form-control-sm rounded-0" required>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="form-group col-md-12">
                                <h3>Doctor(a)</h3>
                                <label for="Nom_director_carrera" class="control-label">Nombre del Director de Carrera(A):</label>
                                <input type="text" name="Nom_director_carrera" id="odc_repre_legal"  class="form-control form-control-sm rounded-0" placeholder="" value="Ing. Jaime Rodrigo Segarra Escandón, (PHD)." required>
                                <h3 class="text-director">DIRECTOR DE CARRERA DE LA UNIDAD ACADÉMICA DE DESARROLLO DE SOFTWARE DE LA UNIVERSIDAD CATÓLICA DE CUENCA</h3>
                                <h6>Su despacho.-</h6>
                            </div>

                            <div class="form-group">
                                <p class="form-group col-md-12">Por medio de la presente reciba un cordial saludo, a su vez doy a conocer que <input type="text" name="Nom_est" id="Nom_est" autofocus  class="col-md-4"
								placeholder="NOMBRES Y APELLIDOS COMPLETOS DEL ESTUDIANTE" value="<?php echo $estudiante['fullname']  ?? ''?>" required>, con documento de identidad Nº <input type="text" name="Num_cedula" id="Num_cedula" autofocus  class=""
								placeholder="Ingrese su cedula" value="<?php echo $estudiante['cedula_est'] ?? '' ?>" required>, ha realizado su
                                <select name="Tipo_pract" id="Tipo_pract" class="col-md-3" required>
                                        <option value="">Seleccione un área</option>
                                            <?php
                                                $areasUnicas = [];
                                                foreach ($obtenerActividades as $m) {
                                                    if (!in_array($m['app_Tipo_pract'], $areasUnicas)) {
                                                        $areasUnicas[] = $m['app_Tipo_pract'];
                                                        $selected = (isset($row['app_Tipo_pract']) && $row['app_Tipo_pract'] === $m['app_Tipo_pract']) ? 'selected' : '';
                                                        echo "<option value=\"{$m['app_Tipo_pract']}\" $selected>{$m['app_Tipo_pract']}</option>";
                                                    }
                                                }
                                            ?>
                                    </select> 
                                en el área de  <input type="text" name="Area_desarrollo" id="Area_desarrollo" value="<?php echo $obtenerActividades['app_Area_dep_proyect'] ?? '' ?>"  class="col-md-3"
								placeholder="Ingrese su area que trabajo" required>,  con una duración de 
                                    <select name="Duracion_horas" id="Duracion_horas"
                                        class="" required>
                                        <option value="120"<?= (isset($row['duracion_horas']) && $row['duracion_horas'] == '120') ? 'selected' : '' ?>>120</option>
                                        <option value="240"<?= (isset($row['duracion_horas']) && $row['duracion_horas'] == '240') ? 'selected' : '' ?>>240</option>
                                    </select> Horas.
                                El estudiante asistió a esta institución desde <input type="date" name="Fecha_inicio" id="Fecha_inicio" value="<?php echo isset($obtenerActividades['app_Fecha_ini']) ? date('Y-m-d', strtotime($obtenerActividades['app_Fecha_ini'])) : ''; ?>" class="col-md-3"
								placeholder="Fecha que inicio las practicas" required> hasta  <input type="date" name="Fecha_fin" id="Fecha_fin" value="<?php echo isset($obtenerActividades['app_Fecha_fin']) ? date('Y-m-d', strtotime($obtenerActividades['app_Fecha_fin'])) : ''; ?>"  class="col-md-3"
								placeholder="Fecha que finalizo las practicas" required>
                                sus actividades las realizó de manera satisfactoria en esta institución. Al presente adjunto la evaluación realizada al estudiante. </p>

                            </div>
							<div class="form-group col-md-6">
								<h6>Con sentimientos de consideración y estima, suscribo</h6>
							</div>

                            <div class="form-group col-md-12 text-center d-flex flex-column align-items-center">
                                <h6>Atentamente</h6>
                                <label for="Representante_empresa" class="control-label">Nombres y apellidos del representante legal:</label>
                                <input type="text" name="Representante_empresa" id="Representante_empresa" class="form-control form-control-sm rounded-0 w-50 text-center" placeholder="Ingrese el nombre completo de su represantante en la empresa o institucion" required>
                                <h5>CARGO REPRESENTANTE LEGAL INSTITUCIÓN</h5>
                            </div>


                            
                        </div>
                        
                            <br>
                        
                        <div class="card-header">
                            <h4 class="card-title">1. DATOS DEL ESTUDIANTE</h4>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Est_nombre" class="control-label">Nombres y apellidos:</label>
                                <input type="text"  name="Est_nombre" id="Est_nombre" class="form-control form-control-sm rounded-0"  value="<?php echo $estudiante['fullname'] ?? ''?>" required ></input>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="Est_carrera" class="control-label">Carrera:</label>
                                <input type="text"  name="Est_carrera" id="Est_carrera" class="form-control form-control-sm rounded-0"  value="<?php echo $estudiante['carrera'] ?? ''?>" required ></input>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="Est_ciclo" class="control-label">Ciclo:</label>
                                <input type="text"  name="Est_ciclo" id="Est_ciclo" class="form-control form-control-sm rounded-0" value="<?php echo $estudiante['ciclo'] ?? ''?>" required ></input>
                            </div>
                            
                        </div>
                </fieldset>
                
                
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
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_5" value="5"></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_4" value="4"></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_3" value="3"></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_2" value="2"></td>
                            <td><input type="radio" name="RCAPregunta1" id="RCAPregunta1_1" value="1"></td>
                        </tr>
                        <tr>
                            <td>El cumplimiento del horario acordado en la planificación es</td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_5" value="5"></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_4" value="4"></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_3" value="3"></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_2" value="2"></td>
                            <td><input type="radio" name="RCAPregunta2" id="RCAPregunta2_1" value="1"></td>
                        </tr>
                        <tr>
                            <td>Trata a las personas con igualdad y sin prejuicios o estereotipos</td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_5" value="5"></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_4" value="4"></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_3" value="3"></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_2" value="2"></td>
                            <td><input type="radio" name="RCAPregunta3" id="RCAPregunta3_1" value="1"></td>
                        </tr>
                        <tr>
                            <td>Colabora en otras actividades programadas por la institución</td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_5" value="5"></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_4" value="4"></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_3" value="3"></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_2" value="2"></td>
                            <td><input type="radio" name="RCAPregunta4" id="RCAPregunta4_1" value="1"></td>
                        </tr>
                        <tr>
                            <td>Sobre el uso de terminología, expresión oral y escrita es</td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_5" value="5"></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_4" value="4"></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_3" value="3"></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_2" value="2"></td>
                            <td><input type="radio" name="RCAPregunta5" id="RCAPregunta5_1" value="1"></td>
                        </tr>
                        <tr>
                            <td><strong for="Subtotal1">SUBTOTAL 1:</strong></td>
                            <td colspan="5">
                                <input type="text" name="Subtotal1" id="Subtotal1" readonly>
                                <button type="button" onclick="calcularSubtotal1()">Calcular Subtotal</button>
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
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="5"></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="4"></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="3"></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="2"></td>
                                <td><input type="radio" name="ACPregunta1" id="ACPregunta1" value="1"></td>
                            </tr>
                            <tr>
                                <td>Aplica sus cocimientos para resolver problemas con facilidad</td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="5"></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="4"></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="3"></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="2"></td>
                                <td><input type="radio" name="ACPregunta2" id="ACPregunta2" value="1"></td>
                            </tr>
                            <tr>
                                <td>Capacidad para seleccionar procedimientos válidos</td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="5"></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="4"></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="3"></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="2"></td>
                                <td><input type="radio" name="ACPregunta3" id="ACPregunta3" value="1"></td>
                            </tr>
                            <tr>
                                <td>Capacidad para interpretar y procesar información</td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="5"></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="4"></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="3"></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="2"></td>
                                <td><input type="radio" name="ACPregunta4" id="ACPregunta4" value="1"></td>
                            </tr>
                            <tr>
                                <td>Los conocimientos en el área para el uso de métodos y técnicas es</td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="5"></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="4"></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="3"></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="2"></td>
                                <td><input type="radio" name="ACPregunta5" id="ACPregunta5" value="1"></td>
                            </tr>
                            <tr>
                                <td><strong for="Subtotal2">SUBTOTAL 2:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal2" id="Subtotal2" readonly>
                                <button type="button" onclick="calcularSubtotal2()">Calcular Subtotal</button>
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
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="5"></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="4"></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="3"></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="2"></td>
                                <td><input type="radio" name="HDPregunta1" id="HDPregunta1" value="1"></td>
                            </tr>
                            <tr>
                                <td>La puntualidad en la presentación de trabajos es</td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="5"></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="4"></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="3"></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="2"></td>
                                <td><input type="radio" name="HDPregunta2" id="HDPregunta2" value="1"></td>
                            </tr>
                            <tr>
                                <td>Su capacidad de trabajo en equipo es</td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="5"></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="4"></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="3"></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="2"></td>
                                <td><input type="radio" name="HDPregunta3" id="HDPregunta3" value="1"></td>
                            </tr>
                            <tr>
                                <td>La ética en el desempeño de sus labores es</td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="5"></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="4"></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="3"></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="2"></td>
                                <td><input type="radio" name="HDPregunta4" id="HDPregunta4" value="1"></td>
                            </tr>
                            <tr>
                                <td>La responsabilidad y el cumplimiento de su trabajo es</td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="5"></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="4"></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="3"></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="2"></td>
                                <td><input type="radio" name="HDPregunta5" id="HDPregunta5" value="1"></td>
                            </tr>
                             <tr>
                                <td><strong for="Subtotal3">SUBTOTAL 3:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal3" id="Subtotal3" readonly>
                                <button type="button" onclick="calcularSubtotal3()">Calcular Subtotal</button>
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
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="5"></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="4"></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="3"></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="2"></td>
                                <td><input type="radio" name="AAPregunta1" id="AAPregunta1" value="1"></td>
                            </tr>
                            <tr>
                                <td>Precisión y cumplimiento en las labores designadas</td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="5"></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="4"></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="3"></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="2"></td>
                                <td><input type="radio" name="AAPregunta2" id="AAPregunta2" value="1"></td>
                            </tr>
                            <tr>
                                <td>Planifica y desarrolla las actividades en forma ordenada</td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="5"></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="4"></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="3"></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="2"></td>
                                <td><input type="radio" name="AAPregunta3" id="AAPregunta3" value="1"></td>
                            </tr>
                            <tr>
                                <td>Domina operaciones y procesos tecnológicos</td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="5"></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="4"></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="3"></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="2"></td>
                                <td><input type="radio" name="AAPregunta4" id="AAPregunta4" value="1"></td>
                            </tr>
                            <tr>
                                <td>Es original y creativo en el desarrollo del trabajo</td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="5"></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="4"></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="3"></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="2"></td>
                                <td><input type="radio" name="AAPregunta5" id="AAPregunta5" value="1"></td>
                            </tr>
                            <tr>
                                <td><strong for="Subtotal4">SUBTOTAL 4:</strong></td>
                                <td colspan="5">
                                <input type="text" name="Subtotal4" id="Subtotal4" readonly>
                                <button type="button" onclick="calcularSubtotal4()">Calcular Subtotal</button>
                            </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                           
                            

                            <tr>
                                <td><strong for="Subtotal1">TOTAL (Sobre 100 puntos):</strong></td>
                                <td colspan="5"><input type="text" name="Total" id="Total" readonly>
                                <button type="button" onclick="calcularTotal()">Calcular Total</button>
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
                                <textarea rows="4" name="Observaciones" id="Observaciones" class="form-control form-control-sm rounded-0"  required></textarea>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="Recomendaciones" class="control-label">5. RECOMENDACIONES DEL TUTOR(A) DE LA EMPRESA/INSTITUCIÓN:  </label>
                                <textarea rows="4" name="Recomendaciones" id="Recomendaciones" class="form-control form-control-sm rounded-0" required></textarea>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="Nombre_Tutor_empresa" class="control-label">Nombre y Apellido del tutor: </label>
                                <input type="text" name="Nombre_Tutor_empresa" id="Nombre_Tutor_empresa" value="<?php echo $obtenerActividades['app_Nombre_doc'] ?? '' ?>"  class="form-control form-control-sm rounded-0">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="Nombre_empresa" class="control-label">Nombre de la Empresa o Institución: </label>
                                <input type="text" name="Nombre_empresa" id="Nombre_empresa" value="<?php echo $obtenerActividades['app_Empresa_Institucion'] ?? '' ?>"  class="form-control form-control-sm rounded-0">
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="logo_empresa" class="control-label">Subir logo de la empresa: </label>
                                <input type="file" name="logo_empresa" id="logo_empresa" class="form-control form-control-sm rounded-0" accept="image/*" onchange="previewImage(event)">
                            </div>
                            <div class="form-group col-md-12 text-center mt-3">
                                <img id="logo_preview" src="" alt="Logo de la empresa" style="display:none; max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                        <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">


            </fieldset>
            <br><br>
                        <div class="card-footer text-right">
                            <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Evaluación Final</button>
                            <a href="./?page=EvaluacionFinalCertificado" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                        </div>
            </form>        
            </div>
        <?php endif; ?>
        <?php if ($_settings->userdata('type') == 2): ?>

            <div class="card-header">
                <label>Buscar por estudiante</label>
               
                    <!-- Campo de búsqueda -->
                     <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por estudiante, Número de Cédula, Tutor, Horas practicas etc.">
               
            </div>
            <!-- filtrar por tipo de practica -->
            <div class="card-header">
                <label for="practicaSelect">Filtrar por tipo de práctica:</label>
                <select id="practicaSelect" class="form-control">
                    <option value="">Todas las prácticas</option>
                    <?php foreach ($practicas as $practica): ?>
                        <option value="<?php echo $practica; ?>"><?php echo $practica; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    </div>
    <?php endif; ?>
    <div class="card-body">
    <div class="container-fluid">
    <div class="tabla-scrollable">
                <table class="table table-bordered table-hover table-striped">
                    
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th class="col-15">Tipo Práctica</th>
                            <th class="col-15">Director de Carrera</th>
                            <th class="col-10">Representatnte Empresa</th>
                            <th class="col-6">Estudiante</th>
                            <th class="col-6">Cédula Estudiante</th>
                            <th class="col-6">Carrera</th>
                            <th class="col-15">Fecha inicio</th>
                            <th class="col-15">Fecha supervición</th>
                            <th class="col-15">Total Horas</th>
                            <th class="col-15">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/EvaluacionFinalCertificado/detailsByUser"; 
                        $base_urlDoc = "http://localhost:5170/api/EvaluacionFinalCertificado"; 
                        $evaFinal = new EvaluacionFinalCert($base_url);
                        $evaFinalDoc = new EvaluacionFinalCert($base_urlDoc);
                        $user_type = $_settings->userdata('type');

                         $user_id = $_settings->userdata('id');
                         if ($user_type == 1) {
                            $qry = $evaFinal->obtenerEvaluacionFinalCertPorUser($user_id);
                        } else if ($user_type == 2) {
                            $qry = $evaFinalDoc->obtenerEvaluacionFinalCert();
                        }
                        
                      


                        
                         foreach ($qry as $row) {
                            ?>
                                <tr>
                                  <td class="text-center"><?php echo $i++; ?></td>
                                  <td class="">
                                        <p class=""><?php echo $row['tipo_pract'] ?></p>
                                  </td>
                                  <td class="">
                                        <p class=""><?php echo $row['nom_director_carrera'] ?></p>
                                  </td>
                                    
                                  <td class="">
                                      <p class=""><?php echo $row['representante_empresa'] ?></p>
                                  </td>
                                  <td class="">
                                      <p class=""><?php echo $row['nom_est'] ?></p>
                                  </td>
                                  
                                  <td class="">
                                      <p class=""><?php echo $row['num_cedula'] ?></p>
                                  </td>
                                  <td class="">
                                      <p class=""><?php echo $row['est_carrera'] ?></p>
                                  </td>
                                    <td class="">
                                        <p class="">
                                            <?php
                                            $fecha_inicio = new DateTime($row['fecha_inicio']);
                                            echo $fecha_inicio->format('d/m/Y'); 
                                            ?>
                                        </p>
                                    </td>
                                    <td class="">
                                        <p class="">
                                            <?php
                                            $fecha_fin = new DateTime($row['fecha_fin']);
                                            echo $fecha_fin->format('d/m/Y');
                                            ?>
                                        </p>
                                    </td>
                                    <td class="">
                                      <p class=""><?php echo $row['duracion_horas'] ?></p>
                                    </td>
                                  
                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Acción
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item view_data" href="./?page=EvaluacionFinalCertificado/view_evaluacionFinalCert&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                            <?php if ($_settings->userdata('type') == 1) : ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item edit_data" href="./?page=EvaluacionFinalCertificado/manage_evaluacionFinalCert&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_data" href="./?page=EvaluacionFinalCertificado/delete_evaluacionFinalCert&id=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
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
     document.getElementById('practicaSelect').addEventListener('change', filtrarTabla);

    function filtrarTabla() {
        var practicaSeleccionada = document.getElementById('practicaSelect').value.toLowerCase().trim();
        var rows = document.querySelectorAll('table tbody tr');

        rows.forEach(function (row) {
            var nombrePractica = row.querySelector('td:nth-child(2) p').innerText.toLowerCase().trim();

            if (practicaSeleccionada === '') {
                row.style.display = '';
            } else if (nombrePractica === practicaSeleccionada) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

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