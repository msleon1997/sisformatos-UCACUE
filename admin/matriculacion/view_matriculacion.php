<?php
require_once '../config.php';
require_once('../classes/Matriculacion.php');


// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id de la URL
    $id = $_GET['id'];

   $base_url = "http://localhost:5170/api/Matriculacion";
   $matriculacion = new Matriculacion($base_url);

    // Obtener los detalles del registro por su id
    $row = $matriculacion->obtenerMatriculacionPorId($id);


// Obtener el ID del usuario actualmente logueado
$user_id = $_settings->userdata('id');
$i = 1;

 // Consulta SQL para estudiantes
 $qry = $conn->query("SELECT *, CONCAT(firstname, ' ', lastname) AS fullname 
 FROM users 
 WHERE id = '{$user_id}' 
 ORDER BY fullname ASC");

$estudiante = $qry->fetch_assoc(); 


$obtenerProyectos = $matriculacion->obtenerProyectos();


?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/matriculacion/css/styles.css">
<script src="<?php echo base_url ?>admin/matriculacion/js/script.js" defer></script>
<div class="content py-3">
    <div class="card card-outline card-primary shadow rounded-0">
        <div class="card-header">
        <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=matriculacion/manage_matriculacion&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=matriculacion/delete_matriculacion&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
            <?php endif; ?>
            <a href="./?page=matriculacion" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
        </div>
    </div>
        
        <div class="card-body">
            <div class="container-fluid">
                <h3 class="card-title"> Matriculación Prácticas Pre-profesionales, Internas y Vinculación</h3>
                <br><br><br>
                <form id="matriculacion_frm" method="post" action="">
                    
                    <input type="hidden" name="users_id"
                        value="<?php echo isset($_GET['student_id']) ? $_GET['student_id'] : '' ?>">
                    <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="roll" class="control-label">Ingrese su carrera: </label>
                                <input type="text" name="carrera" id="carrera" autofocus
                                class="form-control form-control-sm rounded-0" value="<?php echo $row['carrera']; ?>" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="area" class="control-label">Área:</label>
                                <select name="area" id="area" class="form-control form-control-sm rounded-0 select2" required>
                                    <option value="">Seleccione un área</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="ciclo" class="control-label">Ciclo:</label>
                                <select name="ciclo" id="ciclo" class="form-control form-control-sm rounded-0 select2">
                                    <option value="1er Ciclo" <?php echo ($row['ciclo'] == '1er Ciclo') ? 'selected' : ''; ?>>1er Ciclo</option>
                                    <option value="2do Ciclo" <?php echo ($row['ciclo'] == '2do Ciclo') ? 'selected' : ''; ?>>2do Ciclo</option>
                                    <option value="3er Ciclo" <?php echo ($row['ciclo'] == '3er Ciclo') ? 'selected' : ''; ?>>3er Ciclo</option>
                                    <option value="4to Ciclo" <?php echo ($row['ciclo'] == '4to Ciclo') ? 'selected' : ''; ?>>4to Ciclo</option>
                                    <option value="5to Ciclo" <?php echo ($row['ciclo'] == '5to Ciclo') ? 'selected' : ''; ?>>5to Ciclo</option>
                                    <option value="6to Ciclo" <?php echo ($row['ciclo'] == '6to Ciclo') ? 'selected' : ''; ?>>6to Ciclo</option>
                                    <option value="7mo Ciclo" <?php echo ($row['ciclo'] == '7mo Ciclo') ? 'selected' : ''; ?>>7mo Ciclo</option>
                                    <option value="8vo Ciclo" <?php echo ($row['ciclo'] == '8vo Ciclo') ? 'selected' : ''; ?>>8vo Ciclo</option>
                                </select>
                            </div>


                            <div class="form-group col-md-4" id="proyecto_select_group">
                                <label for="proyecto_select" class="control-label">Nombre del Proyecto:</label>
                                <select name="nombre_proyecto" id="proyecto_select" class="form-control form-control-sm rounded-0 select2" required>
                                    <option value="">Seleccione un proyecto</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4" id="proyecto_input_group">
                                <label for="proyecto_input" class="control-label">Nombre del Proyecto:</label>
                                <input type="text" name="nombre_proyecto_pract_pro" id="proyecto_input" class="form-control form-control-sm rounded-0">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="email_est" class="control-label">Email estudiante:</label>
                                <input type="text" name="email_est" id="email_est" autofocus readonly
                                    value="<?= $estudiante['email'] ?? '' ?>"
                                    class="form-control form-control-sm rounded-0" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="firstname_est" class="control-label">Nombre estudiante:</label>
                                <input type="text" name="firstname_est" id="firstname_est"
                                    value="<?= $estudiante['firstname'] ?? '' ?>"
                                    class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lastname_est" class="control-label">Apellido estudiante:</label>
                                <input type="text" name="lastname_est" id="lastname_est"
                                    value="<?= $estudiante['lastname'] ?? '' ?>"
                                    class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cedula_est" class="control-label">Cédula estudiante:</label>
                                <input type="text" name="cedula_est" id="cedula_est"
                                    value="<?= $estudiante['cedula'] ?? '' ?>"
                                    class="form-control form-control-sm rounded-0" required readonly>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="telefono" class="control-label">Teléfono/Celular:</label>
                                <input type="text" name="telefono" id="telefono"
                                  value="<?php echo $row['telefono']; ?>"  class="form-control form-control-sm rounded-0" required>
                            </div>
                           

                            <div class="form-group col-md-4">
                                <label for="nombre_institucion" class="control-label">Institución y/o Empresa:</label>
                                <input type="text" name="nombre_institucion" id="nombre_institucion"
                                    value="<?php echo $row['nombre_institucion']; ?>"
                                    class="form-control form-control-sm rounded-0" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="propuesta" class="control-label">Propuesta</label>
                                <textarea rows="3" name="propuesta" id="propuesta"
                                    class="form-control form-control-sm rounded-0"
                                    required><?php echo $row['propuesta']; ?></textarea>
                            </div>
                            <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id') ?>">
                        </div>


                    </fieldset>
                    
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const proyectos = <?php echo json_encode($obtenerProyectos); ?>;

    const selectedArea = <?php echo json_encode($row['area'] ?? ''); ?>;
    const selectedProyecto = <?php echo json_encode($row['nombre_proyecto'] ?? ''); ?>;
    const selectedProyectoPract = <?php echo json_encode($row['nombre_proyecto_pract_pro'] ?? ''); ?>;

    const areaSelect = document.getElementById("area");
    const proyectoSelect = document.getElementById("proyecto_select");
    const proyectoInput = document.getElementById("proyecto_input");

    const proyectoSelectGroup = document.getElementById("proyecto_select_group");
    const proyectoInputGroup = document.getElementById("proyecto_input_group");

    const areasAgregadas = new Set();
    const proyectosAgregados = new Set();

    let proyectoEnLista = false;

    proyectos.forEach(p => {
        // Área
        if (p.area && !areasAgregadas.has(p.area)) {
            const option = document.createElement("option");
            option.value = p.area;
            option.textContent = p.area;
            if (p.area === selectedArea) {
                option.selected = true;
            }
            areaSelect.appendChild(option);
            areasAgregadas.add(p.area);
        }

        // Proyecto
        if (p.nombre_proyecto && !proyectosAgregados.has(p.nombre_proyecto)) {
            const option = document.createElement("option");
            option.value = p.nombre_proyecto;
            option.textContent = p.nombre_proyecto;
            if (p.nombre_proyecto === selectedProyecto || p.nombre_proyecto === selectedProyectoPract) {
                option.selected = true;
                proyectoEnLista = true;
            }
            proyectoSelect.appendChild(option);
            proyectosAgregados.add(p.nombre_proyecto);
        }
    });

    if (proyectoEnLista) {
        proyectoSelectGroup.style.display = "block";
        proyectoInputGroup.style.display = "none";
    } else {
        proyectoSelectGroup.style.display = "none";
        proyectoInputGroup.style.display = "block";
        proyectoInput.value = selectedProyectoPract || selectedProyecto || '';
    }
});
</script>



<?php
}
?>