<?php

require_once '../config.php';
require_once('../classes/DescargaInforme.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $tipo_practica = $_GET['tipo'] ?? ''; 

    $base_url = "http://localhost:5170/api/DescargaFormatos"; 
    $DescargaInformes = new DescargaInforme($base_url);
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($id);

    $cronoActPract = null;
    if(isset($row['cronogramaActividades']) && is_array($row['cronogramaActividades'])) {
        foreach($row['cronogramaActividades'] as $item) {
             if(isset($item['cA_Tipo_Practica']) && $item['cA_Tipo_Practica'] == $tipo_practica) {
                $cronoActPract = $item;
                break;
            }
        }
    }
    

    $actividadArray = explode("|", $cronoActPract['cA_Actividad'] ?? '') ;
    $tareaArray = explode("|", $cronoActPract['cA_Tarea'] ?? '');

    $cA1raSem_Lunes = explode(",", $cronoActPract['cA1raSem_Lunes'] ?? '');
    $cA1raSem_Martes = explode(",", $cronoActPract['cA1raSem_Martes'] ?? '');
    $cA1raSem_Miercoles = explode(",", $cronoActPract['cA1raSem_Miercoles'] ?? '');
    $cA1raSem_Jueves = explode(",", $cronoActPract['cA1raSem_Jueves'] ?? '');
   


    $cA2raSem_Lunes = explode(",", $cronoActPract['cA2raSem_Lunes'] ?? '');
    $cA2raSem_Martes = explode(",", $cronoActPract['cA2raSem_Martes'] ?? '');
    $cA2raSem_Miercoles = explode(",", $cronoActPract['cA2raSem_Miercoles'] ?? '');
    $cA2raSem_Jueves = explode(",", $cronoActPract['cA2raSem_Jueves'] ?? '');
  


    $cA3raSem_Lunes = explode(",", $cronoActPract['cA3raSem_Lunes'] ?? '');
    $cA3raSem_Martes = explode(",", $cronoActPract['cA3raSem_Martes'] ?? '');
    $cA3raSem_Miercoles = explode(",", $cronoActPract['cA3raSem_Miercoles'] ?? '');
    $cA3raSem_Jueves = explode(",", $cronoActPract['cA3raSem_Jueves'] ?? '');
    


    $cA4taSem_Lunes = explode(",", $cronoActPract['cA4taSem_Lunes'] ?? '');
    $cA4taSem_Martes = explode(",", $cronoActPract['cA4taSem_Martes'] ?? '');
    $cA4taSem_Miercoles = explode(",", $cronoActPract['cA4taSem_Miercoles'] ?? '');
    $cA4taSem_Jueves = explode(",", $cronoActPract['cA4taSem_Jueves'] ?? '');
?>

<!-- PAGINA PLANIFICACION -->
       
<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/CronoActPract/css/styles.css">
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-body">
        <div class="container-fluid" id="outprint-3">
                
                <br><br>
                <div class="form-group text-center">
                    <h3 class="card-title">CRONOGRAMA DE ACTIVIDADES DE LA PRÁCTICAS DE LOS ESTUDIANTES</h3>
                </div>
                <br>

             <?php if($cronoActPract): ?>
            <form id="Crono_acti_frm" method="post" action="">
            <fieldset class="border-bottom">
                <h5 class="card-title">6. PLANIFICACIÓN Y CRONOGRAMA DE ACTIVIDADES</h5>
                <br><br>
                <label for="App_Nom_est">Nombres del Estudiante</label>
                <input type="text" name="App_Nom_est" class="form-control"  value="<?php echo $cronoActPract['cA_Estudiante']; ?>" readonly>
                <label for="CA_Cedula">Cédula del Estudiante</label>
                <input type="text" name="CA_Cedula" class="form-control"  value="<?php echo $cronoActPract['cA_Cedula'] ?? ''; ?>" readonly>
                <div class="container">
                    <table class="table-crono" id="cronogramaTable" style="width:100%">
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
                                    <th><p for="CA_Actividad" class="notificacion">(de acuerdo a lo establecido <br>en la planificación de prácticas<br> de la carrera)</p></th>
                                    <th><p for="CA_Tarea" class="notificacion">(detalle de las <br>actividades a realizar)</p></th>
                                    <th class="dias-semanas"><p>Semanas</p>1 &nbsp; 2 &nbsp; 3 &nbsp; 4 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>5 &nbsp; 6 &nbsp; 7 &nbsp; 8 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>9  10  11  12   </th>
                                    <th class="dias-semanas"><p>Semanas</p>13  14  15  16  </th>
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

                                for ($i = 0; $i < $totalRegistros; $i++) {
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
                                    echo "<td><input type='text' name='cA_Actividad[]' value='$actividad' class='form-control form-control-sm rounded-0'></td>";
                                    echo "<td><input type='text' name='cA_Tarea[]' value='$tarea' class='form-control form-control-sm rounded-0'></td>";

                                    echo "<td>";
                                    echo "<input type='text' name='cA1raSem_Lunes[]' value='$cA1raSem_Lunes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA1raSem_Martes[]' value='$cA1raSem_Martes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA1raSem_Miercoles[]' value='$cA1raSem_Miercoles_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA1raSem_Jueves[]' value='$cA1raSem_Jueves_val' class='dias-adaptable'>&nbsp;";
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<input type='text' name='cA2raSem_Lunes[]' value='$cA2raSem_Lunes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA2raSem_Martes[]' value='$cA2raSem_Martes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA2raSem_Miercoles[]' value='$cA2raSem_Miercoles_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA2raSem_Jueves[]' value='$cA2raSem_Jueves_val' class='dias-adaptable'>&nbsp;";
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<input type='text' name='cA3raSem_Lunes[]' value='$cA3raSem_Lunes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA3raSem_Martes[]' value='$cA3raSem_Martes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA3raSem_Miercoles[]' value='$cA3raSem_Miercoles_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA3raSem_Jueves[]' value='$cA3raSem_Jueves_val' class='dias-adaptable'>&nbsp;";
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<input type='text' name='cA4taSem_Lunes[]' value='$cA4taSem_Lunes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA4taSem_Martes[]' value='$cA4taSem_Martes_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA4taSem_Miercoles[]' value='$cA4taSem_Miercoles_val' class='dias-adaptable'>&nbsp;";
                                    echo "<input type='text' name='cA4taSem_Jueves[]' value='$cA4taSem_Jueves_val' class='dias-adaptable'>&nbsp;";
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