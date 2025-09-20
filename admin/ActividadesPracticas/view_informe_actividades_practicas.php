


<?php
require_once '../config.php';
require_once('../classes/InformeActividadesPracticas.php');


// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id de la URL
    $id = $_GET['id'];

    // URL base de la API
    $base_url = "http://localhost:5170/api/InformeActividadesPracticas"; 

    $infoactpract = new InformeActividadesPracticas($base_url);
    
    $row = $infoactpract->obtenerInformeActividadesPracticasPorId($id);

     // Convertir la fecha al formato dd-mm-yy
     $fechaFormateada = date("d-m-y", strtotime($row['fecha_horas']));

    //actividades
    $fechaIni = date("d-m-y", strtotime($row['fecha_inicio_practica']));
    $fechaFin = date("d-m-y", strtotime($row['fecha_fin_practica']));
    $fechaConvenio = date("d-m-y", strtotime($row['fecha_firma_convenio']));
    $fechaTermino = date("d-m-y", strtotime($row['fecha_termino_convenio']));

    $nombreEstArray = explode(",", $row['estudiante']);
    $cedulaEstArray = explode(",", $row['cedula_estudiante']);
    $celularEstArray = explode(",", $row['celular_estudiante']);   
    $emailEstArray = explode(",", $row['email_estudiante']);

    //cronograma

    $actividadArray = explode("|", $row['actividad_cronograma']);
    $tareaArray = explode("|", $row['tarea_cronograma']);

    $cA1raSem_Lunes = explode(",", $row['primera_semana_lunes']);
    $cA1raSem_Martes = explode(",", $row['primera_semana_martes']);
    $cA1raSem_Miercoles = explode(",", $row['primera_semana_miercoles']);
    $cA1raSem_Jueves = explode(",", $row['primera_semana_jueves']);
   


    $cA2raSem_Lunes = explode(",", $row['segunda_semana_lunes']);
    $cA2raSem_Martes = explode(",", $row['segunda_semana_martes']);
    $cA2raSem_Miercoles = explode(",", $row['segunda_semana_miercoles']);
    $cA2raSem_Jueves = explode(",", $row['segunda_semana_jueves']);
  


    $cA3raSem_Lunes = explode(",", $row['tercera_semana_lunes']);
    $cA3raSem_Martes = explode(",", $row['tercera_semana_martes']);
    $cA3raSem_Miercoles = explode(",", $row['tercera_semana_miercoles']);
    $cA3raSem_Jueves = explode(",", $row['tercera_semana_jueves']);
    


    $cA4taSem_Lunes = explode(",", $row['cuarta_semana_lunes']);
    $cA4taSem_Martes = explode(",", $row['cuarta_semana_martes']);
    $cA4taSem_Miercoles = explode(",", $row['cuarta_semana_miercoles']);
    $cA4taSem_Jueves = explode(",", $row['cuarta_semana_jueves']);
    

    // cumplimiento horas
     $fechaArray = explode(", ", $row['fecha_horas']);
     $hora_EntradaArray = explode(", ", $row['hora_entrada']);
     $hora_SalidaArray = explode(", ", $row['hora_salida']);
     $actividades_RealizadasArray = explode(", ", $row['actividades_realizadas']);



    
?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/ActividadesPracticas/css/styles.css">
<script src="<?php echo base_url ?>admin/ActividadesPracticas/js/view.js" defer></script>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
        <div class="card-tools">
                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=ActividadesPracticas" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
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
                        <td><?php echo $row['empresa_institucion'] ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td><?php echo $row['direccion_empresa'] ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td><?php echo $row['telefono_empresa'] ?></td>
                    </tr>
                    <tr>
                        <th>E-mail:</th>
                        <td><?php echo $row['email_empresa'] ?></td>
                    </tr>
                </table>
            </fieldset>

            <fieldset class="border-bottom">
                <table class="table table-bordered">
                    <tr>
                        <th>Área/Departamento y/o Proyecto:</th>
                        <td><?php echo $row['area_departamento_proyecto'] ?></td>
                    </tr>
                    <tr>
                        <th>Asignaturas y/o Cátedra Integradora:</th>
                        <td><?php echo $row['asignatura_catedra'] ?></td>
                    </tr>
                    <tr>
                        <th>Tutor/a Externo:</th>
                        <td><?php echo $row['tutor_externo'] ?></td>
                    </tr>
                    <tr>
                        <th>Cargo:</th>
                        <td><?php echo $row['cargo_tutor'] ?></td>
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
                                    <td><?php echo $row['convenio'] ?></td>
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
                                echo "<td colspan='2' style='width: 75%;'><input type='text' name='estudiante[]' value='" . htmlspecialchars($nombreEstArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<th style='width: 33%;'>Nº de cédula:</th>";
                                echo "<th style='width: 33%;'>Nº celular:</th>";
                                echo "<th style='width: 33%;'>E-mail:</th>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><input type='text' name='cedula_estudiante[]' value='" . htmlspecialchars($cedulaEstArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                echo "<td><input type='text' name='celular_estudiante[]' value='" . htmlspecialchars($celularEstArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                echo "<td><input type='text' name='email_estudiante[]' value='" . htmlspecialchars($emailEstArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
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
                                    <td><?php echo $row['docente'] ?></td>
                                    <td><?php echo $row['cedula_docente'] ?></td>
                                    <td><?php echo $row['email_docente'] ?></td>
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
        
     
        
        <br><br>
            <form id="Crono_acti_frm" method="post" action="">
            <fieldset class="border-bottom">
                <h5 class="card-title">6. PLANIFICACIÓN Y CRONOGRAMA DE ACTIVIDADES</h5>
                <br><br>
                <div class="container">
                    <table class="table" id="cronogramaTable" style="width:100%">
                        <colgroup>
                            <col width="18%">
                            <col width="18%">
                            <col width="15%">
                            <col width="15%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ACTIVIDAD</th>
                                <th>TAREAS</th>
                                <th>1ra Semana</th>
                                <th>2da Semana</th>
                                <th>3era Semana</th>
                                <th>4ta Semana</th>
                            </tr>
                            <tr>
                                    <th><p for="actividad_cronograma" class="notificacion">(de acuerdo a lo establecido <br>en la planificación de prácticas<br> de la carrera)</p></th>
                                    <th><p for="tarea_cronograma" class="notificacion">(detalle de las <br>actividades a realizar)</p></th>
                                    <th class="dias-semanas"><p>Semanas</p>1 &nbsp; 2 &nbsp; 3 &nbsp; 4 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>5 &nbsp; 6 &nbsp; 7 &nbsp; 8 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>9 &nbsp; 10 &nbsp; 11 &nbsp; 12 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>13 &nbsp; 14 &nbsp; 15 &nbsp; 16 &nbsp; </th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Determinamos el tamaño máximo de los arreglos
                                $totalRegistros = max(
                                    count($actividadArray ?? []),
                                    count($tareaArray ?? []),
                                    count($cA1raSem_Lunes ?? []),
                                    count($cA2raSem_Lunes ?? []),
                                    count($cA3raSem_Lunes ?? []),
                                    count($cA4taSem_Lunes ?? [])
                                );

                                // Iteramos para mostrar los registros
                                for ($i = 0; $i < $totalRegistros; $i++) {
                                    // Validamos y asignamos valores usando el operador ternario
                                    $actividad = isset($actividadArray[$i]) ? htmlspecialchars($actividadArray[$i]) : '';
                                    $tarea = isset($tareaArray[$i]) ? htmlspecialchars($tareaArray[$i]) : '';

                                    $cA1raSem_Lunes_val = isset($cA1raSem_Lunes[$i]) ? htmlspecialchars($cA1raSem_Lunes[$i]) : '';
                                    $cA1raSem_Martes_val = isset($cA1raSem_Martes[$i]) ? htmlspecialchars($cA1raSem_Martes[$i]) : '';
                                    $cA1raSem_Miercoles_val = isset($cA1raSem_Miercoles[$i]) ? htmlspecialchars($cA1raSem_Miercoles[$i]) : '';
                                    $cA1raSem_Jueves_val = isset($cA1raSem_Jueves[$i]) ? htmlspecialchars($cA1raSem_Jueves[$i]) : '';

                                    $cA2raSem_Lunes_val = isset($cA2raSem_Lunes[$i]) ? htmlspecialchars($cA2raSem_Lunes[$i]) : '';
                                    $cA2raSem_Martes_val = isset($cA2raSem_Martes[$i]) ? htmlspecialchars($cA2raSem_Martes[$i]) : '';
                                    $cA2raSem_Miercoles_val = isset($cA2raSem_Miercoles[$i]) ? htmlspecialchars($cA2raSem_Miercoles[$i]) : '';
                                    $cA2raSem_Jueves_val = isset($cA2raSem_Jueves[$i]) ? htmlspecialchars($cA2raSem_Jueves[$i]) : '';

                                    $cA3raSem_Lunes_val = isset($cA3raSem_Lunes[$i]) ? htmlspecialchars($cA3raSem_Lunes[$i]) : '';
                                    $cA3raSem_Martes_val = isset($cA3raSem_Martes[$i]) ? htmlspecialchars($cA3raSem_Martes[$i]) : '';
                                    $cA3raSem_Miercoles_val = isset($cA3raSem_Miercoles[$i]) ? htmlspecialchars($cA3raSem_Miercoles[$i]) : '';
                                    $cA3raSem_Jueves_val = isset($cA3raSem_Jueves[$i]) ? htmlspecialchars($cA3raSem_Jueves[$i]) : '';

                                    $cA4taSem_Lunes_val = isset($cA4taSem_Lunes[$i]) ? htmlspecialchars($cA4taSem_Lunes[$i]) : '';
                                    $cA4taSem_Martes_val = isset($cA4taSem_Martes[$i]) ? htmlspecialchars($cA4taSem_Martes[$i]) : '';
                                    $cA4taSem_Miercoles_val = isset($cA4taSem_Miercoles[$i]) ? htmlspecialchars($cA4taSem_Miercoles[$i]) : '';
                                    $cA4taSem_Jueves_val = isset($cA4taSem_Jueves[$i]) ? htmlspecialchars($cA4taSem_Jueves[$i]) : '';


                                    echo "<tr>";
                                    echo "<td><input type='text' name='actividad_cronograma[]' value='$actividad' class='form-control form-control-sm rounded-0'></td>";
                                    echo "<td><input type='text' name='tarea_cronograma[]' value='$tarea' class='form-control form-control-sm rounded-0'></td>";

                                    echo "<td>";
                                    echo "<input type='text' name='primera_semana_lunes[]' value='$cA1raSem_Lunes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='primera_semana_martes[]' value='$cA1raSem_Martes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='primera_semana_miercoles[]' value='$cA1raSem_Miercoles_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='primera_semana_jueves[]' value='$cA1raSem_Jueves_val' class='dias-adaptable'>&nbsp;";
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<input type='text' name='segunda_semana_lunes[]' value='$cA2raSem_Lunes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='segunda_semana_martes[]' value='$cA2raSem_Martes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='segunda_semana_miercoles[]' value='$cA2raSem_Miercoles_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='segunda_semana_jueves[]' value='$cA2raSem_Jueves_val' class='dias-adaptable'>&nbsp;";
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<input type='text' name='tercera_semana_lunes[]' value='$cA3raSem_Lunes_val' class='dias-adaptable'>&nbsp;&nbsp;&nbsp;";
                                    echo "<input type='text' name='tercera_semana_martes[]' value='$cA3raSem_Martes_val' class='dias-adaptable'>&nbsp;&nbsp;&nbsp;";
                                    echo "<input type='text' name='tercera_semana_miercoles[]' value='$cA3raSem_Miercoles_val' class='dias-adaptable'>&nbsp;&nbsp;&nbsp;";
                                    echo "<input type='text' name='tercera_semana_jueves[]' value='$cA3raSem_Jueves_val' class='dias-adaptable'>&nbsp;&nbsp;&nbsp;";
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<input type='text' name='cuarta_semana_lunes[]' value='$cA4taSem_Lunes_val' class='dias-adaptable'>&nbsp;&nbsp;&nbsp;&nbsp;";
                                    echo "<input type='text' name='cuarta_semana_martes[]' value='$cA4taSem_Martes_val' class='dias-adaptable'>&nbsp;&nbsp;&nbsp;&nbsp;";
                                    echo "<input type='text' name='cuarta_semana_miercoles[]' value='$cA4taSem_Miercoles_val' class='dias-adaptable'>&nbsp;&nbsp;&nbsp;&nbsp;";
                                    echo "<input type='text' name='cuarta_semana_jueves[]' value='$cA4taSem_Jueves_val' class='dias-adaptable'>&nbsp;&nbsp;&nbsp;&nbsp;";
                                    echo "</td>";

                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>

                <br><br>
               
            </form>


        
           
            

        <div class="card-body">
            <h5 class="card-title">7. REGISTRO DE HORAS DE PRÁCTICA PRE PROFESIONAL Y/O DE SERVICIO COMUNITARIO</h5>
            <br>
                <fieldset class="border-bottom">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="proyecto_empresa" class="control-label">Empresa/Institución de Contraparte y/o Proyecto:</label>
                            <div class="form-control form-control-sm rounded-0"><?= $row['proyecto_empresa'] ?></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tutor_externo_horas" class="control-label">Tutor Externo:</label>
                            <div class="form-control form-control-sm rounded-0"><?= $row['tutor_externo_horas'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="docente_tutor" class="control-label">Docente-Tutor:</label>
                            <div class="form-control form-control-sm rounded-0"><?= $row['docente_tutor'] ?></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="estudiante_horas" class="control-label">Estudiante:</label>
                            <div class="form-control form-control-sm rounded-0"><?= $row['estudiante_horas'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered" id="activity-table">
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
                                        echo "<td><input type='date' name='fecha_horas[]' value='" . htmlspecialchars($fechaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='hora_entrada[]' value='" . htmlspecialchars($hora_EntradaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='hora_salida[]' value='" . htmlspecialchars($hora_SalidaArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "<td><input type='text' name='actividades_realizadas[]' value='" . htmlspecialchars($actividades_RealizadasArray[$i]) . "' class='form-control form-control-sm rounded-0' required></td>";
                                        echo "</tr>";
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                    <br><br><br>
                 
                </fieldset>
        </div>

        <div class="card-body">
        <h5 class="card-title">8. ACTA DE COMPROMISO</h5>
            <div class="container mt-5" id="outprint">
            <div id="ActaCompromiso_frm">
                    <div class="form-group">
                        <?php
                               $estudiantes = explode("; ", $row['acta_NombresEstudiante']);  
                               $carreras = explode("; ", $row['acta_Carrera']);
                               $unidadAcademica = explode("; ", $row['acta_UnidadAcademica']);
                               $empresas = explode("; ", $row['acta_NombreEmpresa']);

                               $count = max(count($estudiantes), count($carreras), count($unidadAcademica), count($empresas));

                               for ($i = 0; $i < $count; $i++) {
                                echo "<p>"; 
                                echo "Yo, ";
                                echo "<strong>" . htmlspecialchars($estudiantes[$i] ?? '') . "</strong>, estudiante de la carrera de ";      
                                echo "<strong>" . htmlspecialchars($carreras[$i] ?? '') . "</strong> de la Unidad Académica de ";      
                                echo "<strong>" . htmlspecialchars($unidadAcademica[$i] ?? '') . "</strong>, por medio de la presente me comprometo con ";      
                                echo "<strong>" . htmlspecialchars($empresas[$i] ?? '') . "</strong>. A fin de llevar a cabo la práctica pre profesional, con responsabilidad y total acatamiento a las disposiciones y normas internas de la entidad auspiciadora y/o Proyecto, del Reglamento e Instructivo de prácticas pre profesionales de la Universidad Católica de Cuenca y dando cumplimiento a la presente planificación.";      
                                echo "</p>";  
                                echo "<br><br><br><br>";
                            }
                            
                        ?>
                    </div>
            </div>
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


