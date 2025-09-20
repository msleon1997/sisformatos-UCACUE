<?php
require_once '../config.php';
require_once('../classes/CronoActi.php');


// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id de la URL
    $id = $_GET['id'];

    // URL base de la API
    $base_url = "http://localhost:5170/api/CronoActividades"; 

    $cronoActi = new CronoActi($base_url);
    
    $row = $cronoActi->obtenerCronoActiPorId($id);

    $actividadArray = explode("|", $row['cA_Actividad']);
    $tareaArray = explode("|", $row['cA_Tarea']);

    $cA1raSem_Lunes = explode(",", $row['cA1raSem_Lunes']);
    $cA1raSem_Martes = explode(",", $row['cA1raSem_Martes']);
    $cA1raSem_Miercoles = explode(",", $row['cA1raSem_Miercoles']);
    $cA1raSem_Jueves = explode(",", $row['cA1raSem_Jueves']);
   


    $cA2raSem_Lunes = explode(",", $row['cA2raSem_Lunes']);
    $cA2raSem_Martes = explode(",", $row['cA2raSem_Martes']);
    $cA2raSem_Miercoles = explode(",", $row['cA2raSem_Miercoles']);
    $cA2raSem_Jueves = explode(",", $row['cA2raSem_Jueves']);
  


    $cA3raSem_Lunes = explode(",", $row['cA3raSem_Lunes']);
    $cA3raSem_Martes = explode(",", $row['cA3raSem_Martes']);
    $cA3raSem_Miercoles = explode(",", $row['cA3raSem_Miercoles']);
    $cA3raSem_Jueves = explode(",", $row['cA3raSem_Jueves']);
    


    $cA4taSem_Lunes = explode(",", $row['cA4taSem_Lunes']);
    $cA4taSem_Martes = explode(",", $row['cA4taSem_Martes']);
    $cA4taSem_Miercoles = explode(",", $row['cA4taSem_Miercoles']);
    $cA4taSem_Jueves = explode(",", $row['cA4taSem_Jueves']);
    
?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/CronoActPract/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/CronoActPract/js/view.js" defer></script>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): // Usuario tipo 1 (Estudiante) ?>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=ActPract/CronoActPract/delete_crono&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
                <?php endif; ?>
                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=ActPract/CronoActPract" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
            <br>
        </div>

        <div class="card-body">
        <div class="container-fluid" id="outprint">
        <h3 class="card-title">CRONOGRAMA DE ACTIVIDADES DE LA PRÁCTICA PRE PROFESIONAL DE LOS ESTUDIANTES</h3>
        <br><br>
            <form id="Crono_acti_frm" method="post" action="">
            <fieldset class="border-bottom">
                <h5 class="card-title">9. PLANIFICACIÓN Y CRONOGRAMA DE ACTIVIDADES</h5>
                <br><br>
                <label for="CA_Tipo_Practica">Tipo de Práctica</label>
                <input type="text" name="CA_Tipo_Practica" class="form-control"  value="<?php echo $row['cA_Tipo_Practica']; ?>" readonly>
                <br>
                <label for="App_Nom_est">Nombres del Estudiante</label>
                <input type="text" name="App_Nom_est" class="form-control"  value="<?php echo $row['cA_Estudiante']; ?>" readonly>
                <label for="CA_Cedula">Cédula del Estudiante</label>
                <input type="text" name="CA_Cedula" class="form-control"  value="<?php echo $row['cA_Cedula'] ?? ''; ?>" readonly>
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


