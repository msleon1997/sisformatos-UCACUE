<?php

require_once '../config.php';
require_once('../classes/CronoActi.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$base_url = "http://localhost:5170/api/CronoActividades"; 
$cronoAct = new CronoActi($base_url);

$user_id = $_settings->userdata('id');
$i = 1;
$user_type = $_settings->userdata('type');

$obtenerMatriculas = $cronoAct->obtenerMatriculaciones($user_id);

$datosEst = $obtenerMatriculas[0] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = [
        "CA_Tipo_Practica" => $_POST["CA_Tipo_Practica"] ?? '',
        "CA_Estudiante" => $_POST["CA_Estudiante"] ?? '',
        "CA_Cedula" => $_POST["CA_Cedula"] ?? '',
        "CA_Actividad" => isset($_POST["CA_Actividad"]) ? implode("| ", $_POST["CA_Actividad"]) : '',
        "CA_Tarea" => isset($_POST["CA_Tarea"]) ? implode("| ", $_POST["CA_Tarea"]) : '',

        "CA_1raSemana" => $_POST["CA_1raSemana"] ?? '',
        "CA1raSem_Lunes" => isset($_POST["CA1raSem_Lunes"]) ? implode(", ", $_POST["CA1raSem_Lunes"]) : '',
        "CA1raSem_Martes" => isset($_POST["CA1raSem_Martes"]) ? implode(", ", $_POST["CA1raSem_Martes"]) : '',
        "CA1raSem_Miercoles" => isset($_POST["CA1raSem_Miercoles"]) ? implode(", ", $_POST["CA1raSem_Miercoles"]) : '',
        "CA1raSem_Jueves" => isset($_POST["CA1raSem_Jueves"]) ? implode(", ", $_POST["CA1raSem_Jueves"]) : '',

        "CA_2raSemana" => $_POST["CA_2raSemana"] ?? '',
        "CA2raSem_Lunes" => isset($_POST["CA2raSem_Lunes"]) ? implode(", ", $_POST["CA2raSem_Lunes"]) : '',
        "CA2raSem_Martes" => isset($_POST["CA2raSem_Martes"]) ? implode(", ", $_POST["CA2raSem_Martes"]) : '',
        "CA2raSem_Miercoles" => isset($_POST["CA2raSem_Miercoles"]) ? implode(", ", $_POST["CA2raSem_Miercoles"]) : '',
        "CA2raSem_Jueves" => isset($_POST["CA2raSem_Jueves"]) ? implode(", ", $_POST["CA2raSem_Jueves"]) : '',

        "CA_3raSemana" => $_POST["CA_3raSemana"] ?? '',
        "CA3raSem_Lunes" => isset($_POST["CA3raSem_Lunes"]) ? implode(", ", $_POST["CA3raSem_Lunes"]) : '',
        "CA3raSem_Martes" => isset($_POST["CA3raSem_Martes"]) ? implode(", ", $_POST["CA3raSem_Martes"]) : '',
        "CA3raSem_Miercoles" => isset($_POST["CA3raSem_Miercoles"]) ? implode(", ", $_POST["CA3raSem_Miercoles"]) : '',
        "CA3raSem_Jueves" => isset($_POST["CA3raSem_Jueves"]) ? implode(", ", $_POST["CA3raSem_Jueves"]) : '',

        "CA_4raSemana" => $_POST["CA_4raSemana"] ?? '',
        "CA4taSem_Lunes" => isset($_POST["CA4taSem_Lunes"]) ? implode(", ", $_POST["CA4taSem_Lunes"]) : '',
        "CA4taSem_Martes" => isset($_POST["CA4taSem_Martes"]) ? implode(", ", $_POST["CA4taSem_Martes"]) : '',
        "CA4taSem_Miercoles" => isset($_POST["CA4taSem_Miercoles"]) ? implode(", ", $_POST["CA4taSem_Miercoles"]) : '',
        "CA4taSem_Jueves" => isset($_POST["CA4taSem_Jueves"]) ? implode(", ", $_POST["CA4taSem_Jueves"]) : '',

        "users_id" => $_POST["users_id"] ?? ''
    ];

    // Crear la nueva planificación para cada actividad
    $respuesta = $cronoAct->crearCronoActi($datos);

    
    //var_dump($datos);
}


?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/CronoActPract/css/styles.css">
<script src="<?php echo base_url ?>admin/ActPract/CronoActPract/js/script.js" defer></script>
<script>
    const datosPorArea = <?= json_encode($cronoAct->obtenerMatriculaciones($user_id)) ?>;
</script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">CRONOGRAMA DE ACTIVIDADES DE LA PRÁCTICA PRE PROFESIONAL DE LOS ESTUDIANTES</h3>
        <br>
    </div>
    <div class="card-body">
    <?php if ($_settings->userdata('type') == 1): ?>
        <div class="container-fluid">
            <form id="Crono_acti_frm" method="post" action="">
            <input type="hidden" name="CA_1raSemana" id="CA_1raSemana"  value="1ra Semana" >
            <input type="hidden" name="CA_2raSemana" id="CA_2raSemana"  value="2ra Semana">
            <input type="hidden" name="CA_3raSemana" id="CA_3raSemana"  value="3ra Semana">
            <input type="hidden" name="CA_4raSemana" id="CA_4raSemana"  value="4ra Semana">


                <fieldset class="border-bottom">
                    <h5 class="card-title">9. PLANIFICACIÓN Y CRONOGRAMA DE ACTIVIDADES</h5>
                    <br><br>
                    <div class="form-group col-md-12">
                        <label for="CA_Tipo_Practica" class="control-label">Tipo de Practica:</label>
                        <select name="CA_Tipo_Practica" id="CA_Tipo_Practica" class="form-control form-control-sm rounded-0 select2" required>
                            <option value="">Seleccione un área</option>
                            <?php
                                $matriculas = $cronoAct->obtenerMatriculaciones($user_id);
                                $areasUnicas = [];
                                foreach ($matriculas as $m) {
                                    if (!in_array($m['area'], $areasUnicas)) {
                                        $areasUnicas[] = $m['area'];
                                        $selected = (isset($row['area']) && $row['area'] === $m['area']) ? 'selected' : '';
                                        echo "<option value=\"{$m['area']}\" $selected>{$m['area']}</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div id="datosEstudiante" style="display: none;">
                        <label for="CA_Estudiante">Nombres del Estudiante</label>
                        <input type="text" name="CA_Estudiante" id="CA_Estudiante" class="form-control" value="<?php echo $datosEst['firstname_est'] . " " . $datosEst['lastname_est'] ?? ''; ?>" readonly>
                        
                        <label for="CA_Cedula">Cédula del Estudiante</label>
                        <input type="text" name="CA_Cedula" id="CA_Cedula" class="form-control" value="<?php echo $datosEst['cedula_est'] ?? ''; ?>" readonly>
                    </div>

                    <div class="container">
                        <table class="table" id="cronogramaTable">
                            <thead>
                                <tr>
                                    
                                    <th>ACTIVIDAD</th>
                                    <th>TAREAS</th>
                                    <th>1er Mes</th>
                                    <th>2do Mes</th>
                                    <th>3er Mes</th>
                                    <th>4to Mes</th>
                                </tr>
                                <tr>
                                    
                                    <th><p for="CA_Actividad" class="notificacion">(de acuerdo a lo establecido <br>en la planificación de prácticas<br> de la carrera)</p></th>
                                    <th><p for="CA_Tarea" class="notificacion">(detalle de las <br>actividades a realizar)</p></th>
                                    <th class="dias-semanas"><p>Semanas</p>1 &nbsp; 2 &nbsp; 3 &nbsp; 4 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>5 &nbsp; 6 &nbsp; 7 &nbsp; 8 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>9 &nbsp; 10 &nbsp; 11 &nbsp; 12 &nbsp;  </th>
                                    <th class="dias-semanas"><p>Semanas</p>13 &nbsp; 14 &nbsp; 15 &nbsp; 16 &nbsp; </th>
                                </tr>
                            </thead>
                            <tbody>
                           
                                <tr>
                                   
                                    <td><input type="text" name="CA_Actividad[]" id="CA_Actividad" required></td>
                                    <td><input type="text" name="CA_Tarea[]" id="CA_Tarea" required></td>
                                    <td>
                                        <input type="text" name="CA1raSem_Lunes[]" id="CA1raSem_Lunes"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
                                        <input type="text" name="CA1raSem_Martes[]" id="CA1raSem_Martes"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
                                        <input type="text" name="CA1raSem_Miercoles[]" id="CA1raSem_Miercoles" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
                                        <input type="text" name="CA1raSem_Jueves[]" id="CA1raSem_Jueves"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
                                  
                                    </td>
                                    <td>
                                        <input type="text" name="CA2raSem_Lunes[]" id="CA2raSem_Lunes"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
                                        <input type="text" name="CA2raSem_Martes[]" id="CA2raSem_Martes"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
                                        <input type="text" name="CA2raSem_Miercoles[]" id="CA2raSem_Miercoles" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
                                        <input type="text" name="CA2raSem_Jueves[]" id="CA2raSem_Jueves" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
                                    
                                    </td>
                                    <td>
                                        <input type="text" name="CA3raSem_Lunes[]" id="CA3raSem_Lunes" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;
                                        <input type="text" name="CA3raSem_Martes[]" id="CA3raSem_Martes" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;
                                        <input type="text" name="CA3raSem_Miercoles[]" id="CA3raSem_Miercoles" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;
                                        <input type="text" name="CA3raSem_Jueves[]" id="CA3raSem_Jueves" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;
                                       
                                    </td>
                                    <td>
                                        <input type="text" name="CA4taSem_Lunes[]" id="CA4taSem_Lunes" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="text" name="CA4taSem_Martes[]" id="CA4taSem_Martes" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="text" name="CA4taSem_Miercoles[]" id="CA4taSem_Miercoles" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="text" name="CA4taSem_Jueves[]" id="CA4taSem_Jueves" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>

                                

                                <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">

                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success" id="add-row-btn">Agregar Fila</button>
                        <button type="button" class="btn btn-danger" id="removeRowBtn">Quitar Fila</button>
                    </div>
                        <br>
                    
                </fieldset>
                <br><br>
                <div class="card-footer text-right">
                        <button class="btn btn-flat btn-primary btn-sm" type="submit">Guardar Cronograma</button>
                        <a href="./?page=ActPract/CronoActPract" class="btn btn-flat btn-default border btn-sm">Cancelar</a>
                </div>
            </form>
        </div>
        <?php endif; ?>
                <?php if ($_settings->userdata('type') == 2): ?>
            <div class="card-header">
                <label>Buscar por estudiante</label>
                
                    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por estudiante o numero de cedula.">
                <?php endif; ?>
            </div>


    <div class="card-body">
    <div class="container-fluid">  
    <div class="tabla-scrollable">
        <table id="cronogramaTable" class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="bg-gradient-dark text-light">
                    <th>#</th>
                    <th>TIPO PRÁCTICA</th>
                    <th>CEDULA</th>
                    <th>ESTUDIANTE</th>
                    <th>ACTIVIDADES</th>
                    <th>TAREAS</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $base_url = "http://localhost:5170/api/CronoActividades/detailsByUser"; 
                        $base_urlDoc = "http://localhost:5170/api/CronoActividades"; 
                        $cronoActi = new CronoActi($base_url);
                        $cronoActiDoc = new CronoActi($base_urlDoc);
                        
                        // Obtener el tipo de usuario
                        $user_type = $_settings->userdata('type');
                        $user_id = $_settings->userdata('id');

                        // Si el usuario es estudiante (type = 1)
                        if ($user_type == 1) {
                            $qry = $cronoActi->obtenerCronoActiPorUser($user_id);

                            foreach ($qry as $row) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td class="">
                                    <p class=""><?php echo $row['cA_Tipo_Practica'] ?? ''; ?></p>
                                </td>
                                <td class="">
                                    <p class=""><?php echo $row['cA_Cedula'] ?? ''; ?></p>
                                </td>
                                <td class="">
                                    <p class=""><?php echo $row['cA_Estudiante']; ?></p>
                                </td>
                                
                                <td class="">
                                    <p class="">
                                            <?php 
                                            $actividades = explode('|', $row['cA_Actividad']);
                                            echo isset($actividades[0]) ? htmlspecialchars($actividades[0]): 'N/A'; 
                                            ?>
                                        </ul>
                                    </p>
                                </td>
                                <td class="">
                                    <p class="">
                                       
                                            <?php 
                                            $tareas = explode('|', $row['cA_Tarea']);
                                            echo isset($tareas[0]) ? htmlspecialchars($tareas[0]): 'N/A';
                                            ?>
                                       
                                    </p>
                                </td>


                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Acción
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="./?page=ActPract/CronoActPract/view_crono&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                        <?php if ($_settings->userdata('type') == 1) : ?>
                                            
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_data" href="./?page=ActPract/CronoActPract/delete_crono&id=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        }elseif ($user_type == 2) {
                            $cronogramas = $cronoActiDoc->obtenerCronoActi();
                            foreach ($cronogramas as $row) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td class="">
                                    <p class=""><?php echo $row['cA_Tipo_Practica'] ?? ''; ?></p>
                                </td>
                                
                                <td class="">
                                <p class=""><?php echo $row['cA_Cedula']; ?></p>
                                </td>
                                
                                <td class="">
                                <p class=""><?php echo $row['cA_Estudiante']; ?></p>
                                </td>
                                
                                <td class="">
                                    <p class="">
                                            <?php 
                                            $actividades = isset($row['cA_Actividad']) ? explode('|', $row['cA_Actividad']) : [];
                                            echo !empty($actividades) ? htmlspecialchars($actividades[0]) : 'N/A';
                                           
                                            ?>
                                        </ul>
                                    </p>
                                </td>
                                <td class="">
                                    <p class="">
                                       
                                            <?php 
                                            $tareas = isset($row['cA_Tarea']) ? explode('|', $row['cA_Tarea']) : [];
                                            echo !empty($tareas) ? htmlspecialchars($tareas[0]) : 'N/A';
                                            ?>
                                       
                                    </p>
                                </td>


                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Acción
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="./?page=ActPract/CronoActPract/view_crono&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
                                        <?php if ($_settings->userdata('type') == 1) : ?>
                                            
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_data" href="./?page=ActPract/CronoActPract/delete_crono&id=<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>

                </table>
        </div>
    </div>
    </div>
  </div>
</div>
<script>
    
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