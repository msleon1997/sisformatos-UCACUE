<?php

require_once '../config.php';
require_once('../classes/DescargaInforme.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'] ?? null;
    $tipo_practica = $_GET['tipo'] ?? null;

    $base_url = "http://localhost:5170/api/DescargaFormatos";
    $DescargaInformes = new DescargaInforme($base_url);
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($user_id);

    $certificadoFinal = null;
     if(isset($row['certificadoFinal']) && is_array($row['certificadoFinal'])) {
        foreach($row['certificadoFinal'] as $item) {
            if(isset($item['tipo_practica']) && $item['tipo_practica'] == $tipo_practica) {
                $certificadoFinal = $item;
                break;
            }
        }
    }
    $fechaEmision = date("d-m-Y", strtotime($certificadoFinal['fecha_emision'] ?? ''));
    $fechaIni = date("Y-m-d", strtotime($certificadoFinal['periodo_fecha_ini'] ?? ''));
    $fechaFin = date("Y-m-d", strtotime($certificadoFinal['periodo_fecha_fin'] ?? ''));
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<link rel="stylesheet" href="<?php echo base_url ?>admin/InformeTutorias/css/styles.css">
<script src="<?php echo base_url ?>admin/InformeTutorias/js/script.js" defer></script>

<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-body">
        <div class="container-fluid" id="outprint-10">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <img src="../uploads/f-38.png" class="img-fluid" alt="" style="width: 100%;">
                    </div>
                </div>
                

             <?php if($certificadoFinal): ?>

            <form id="Cert_pract_frm" method="post" action="">
                <fieldset class="border-bottom">
                    
                        <div class="row">
                            <div class="form-group col-md-2 end-column">
                                <label for="fecha_emision" class="control-label">Cuenca, <span name="fecha_emision"><?php echo $fechaEmision ?></span> </label>
                            </div>
                        </div>

                        <div style="font-family: Arial, sans-serif; text-align: justify; margin-top: 20px;">
                            <p>
                                La Jefatura de Vinculación con la Sociedad de la Universidad Católica de Cuenca, a través del 
                                Docente Responsable de Prácticas Laborales de la Carrera de Ingeniería de Software Modalidad Nocturna 
                                de la Unidad Académica de Desarrollo de Software de la Universidad Católica de Cuenca – (matriz, sedes o extensiones); 
                                a petición verbal de la parte interesada:
                            </p>

                            <p style="text-align: center; font-weight: bold; margin-top: 30px;">CERTIFICA:</p>

                            <p>
                                Que el/la estudiante 
                                <strong><?php echo $certificadoFinal['estudiante_nombre']; ?></strong>, 
                                portador/a del documento único de identidad número 
                                <strong><?php echo $certificadoFinal['numero_cedula']; ?></strong>, 
                                ha cumplido con sus horas de 
                                <strong><?php echo $certificadoFinal['tipo_practica']; ?></strong>.
                            </p>
                        </div>


                       <div class="row">
                        <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
                            <thead>
                            <tr>
                                <th>Malla</th>
                                <th>Ciclo</th>
                                <th>Proyecto/<br>Empresa/Entidad</th>
                                <th>Período</th>
                                <th>Horas</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                <span name="malla_curricular" id="malla_curricular">Colocar la malla a la que pertenece el estudiante</span>
                                </td>
                                <td>
                                <input type="text" name="ciclo_est" class="form-control form-control-sm rounded-0" readonly value="<?php echo $certificadoFinal['ciclo_est']; ?>">
                                </td>
                                <td>
                                     <input type="text" name="proyecto_empresa_entidad" id="proyecto_empresa_entidad" value="<?php echo($certificadoFinal["proyecto_empresa_entidad"]); ?>" class="form-control form-control-sm rounded-0 select2" required>
                                        
                                 


                                </td>
                                <td>
                                <input type="date" name="periodo_fecha_ini" value="<?=$fechaIni ?>" class="form-control form-control-sm rounded-0"><br>
                                al<br>
                                <input type="date" name="periodo_fecha_fin" value="<?=$fechaFin ?>" class="form-control form-control-sm rounded-0">
                                </td>
                                <td>
                                <select name="cantidad_horas_pract" id="cantidad_horas_pract" class="form-control form-control-sm rounded-0 select2">
                                    <option value="120" <?= (isset($certificadoFinal['cantidad_horas_pract']) && $certificadoFinal['cantidad_horas_pract'] == '120') ? 'selected' : '' ?>>120 Horas</option>
                                    <option value="240" <?= (isset($certificadoFinal['cantidad_horas_pract']) && $certificadoFinal['cantidad_horas_pract'] == '240') ? 'selected' : '' ?>>240 Horas</option>
                                </select>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Total de horas</strong></td>
                                <td>
                                <input type="number" name="total_horas_pract" id="total_horas_pract" value="<?= $certificadoFinal['total_horas_pract'] ?>" class="form-control form-control-sm rounded-0" placeholder="Ingrese el total de horas">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                        <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">
                        </fieldset>
                        <br><br>
                       
            </form>
            <div style="text-align: center; font-family: Arial, sans-serif; margin-top: 40px;">
                <p style="margin-bottom: 10px;">Atentamente,</p>
                <p style="margin-bottom: 40px;">DIOS, PATRIA, CULTURA Y DESARROLLO</p>
                <br><br>

                <div style="display: flex; justify-content: center; gap: 100px; margin-top: 40px;">
                    <!-- Columna izquierda -->
                    <div style="text-align: center;">
                        <strong>Ing. Diana Ximena<br>Poma Japón</strong><br><br><br><br>
                        Docente Responsable de Prácticas Laborales<br>
                        / Docente Responsable de Prácticas de Servicio Comunitario<br>
                        Desarrollo de Software
                    </div>

                    <!-- Columna derecha -->
                    <div style="text-align: center;">
                        <strong>Ing. Jaime Rodrigo Segarra Escandón,<br>(PHD).</strong><br><br><br><br>
                        Director de Carrera<br>
                        Desarrollo de Software
                    </div>
                </div>
                <br><br>
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
</div>

<?php
}
?>