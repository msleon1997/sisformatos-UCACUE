
<?php
require_once '../config.php';
require_once('../classes/CertificadoPract.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $base_url = "http://localhost:5170/api/CertificadoPracticas"; 
    $certpract = new CertificadoPract($base_url);

    $row = $certpract->obtenerCertificadoPractPorId($id);
    
    
$fechaEmision = date("Y-m-d", strtotime($row['fecha_emision']));
$fechaIni = date("Y-m-d", strtotime($row['periodo_fecha_ini']));
$fechaFin = date("Y-m-d", strtotime($row['periodo_fecha_fin']));
?>


<link rel="stylesheet" href="<?php echo base_url ?>admin/CertificadoPract/css/styles.css">
<script src="<?php echo base_url ?>admin/CertificadoPract/js/view.js" defer></script>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=CertificadoPract/manage_certificado_pract&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=CertificadoPract/delete_certificado_pract&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
            <?php endif; ?>
            <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
            <a href="./?page=CertificadoPract" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
        </div>
    </div>
   
    <div class="card-body">
    
        <div class="container-fluid"  id="outprint">
            <form id="Cert_pract_frm" method="post" action="">
                <fieldset class="border-bottom">
                    
                        <div class="row">
                            <div class="form-group col-md-2 end-column">
                                <label for="fecha_emision" class="control-label">Cuenca,  </label>
                                <input type="date" name="fecha_emision" value="<?php echo $fechaEmision ?>" class="form-control form-control-sm rounded-0">
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
                                <strong><?php echo $row['estudiante_nombre']; ?></strong>, 
                                portador/a del documento único de identidad número 
                                <strong><?php echo $row['numero_cedula']; ?></strong>, 
                                ha cumplido con sus horas de 
                                <strong><?php echo $row['tipo_practica']; ?></strong>.
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
                                <textarea name="malla_curricular" id="malla_curricular" class="form-control form-control-sm rounded-0" rows="3" placeholder="Colocar la malla a la que pertenece el estudiante"></textarea>
                                </td>
                                <td>
                                <input type="text" name="ciclo_est" class="form-control form-control-sm rounded-0" readonly value="<?php echo $row['ciclo_est']; ?>">
                                </td>
                                <td>
                                     <input type="text" name="proyecto_empresa_entidad" id="proyecto_empresa_entidad" value="<?php echo($row["proyecto_empresa_entidad"]); ?>" class="form-control form-control-sm rounded-0 select2" required>
                                        
                                 


                                </td>
                                <td>
                                <input type="date" name="periodo_fecha_ini" value="<?=$fechaIni ?>" class="form-control form-control-sm rounded-0"><br>
                                al<br>
                                <input type="date" name="periodo_fecha_fin" value="<?=$fechaFin ?>" class="form-control form-control-sm rounded-0">
                                </td>
                                <td>
                                <select name="cantidad_horas_pract" id="cantidad_horas_pract" class="form-control form-control-sm rounded-0 select2">
                                    <option value="120" <?= (isset($row['cantidad_horas_pract']) && $row['cantidad_horas_pract'] == '120') ? 'selected' : '' ?>>120 Horas</option>
                                    <option value="240" <?= (isset($row['cantidad_horas_pract']) && $row['cantidad_horas_pract'] == '240') ? 'selected' : '' ?>>240 Horas</option>
                                </select>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Total de horas</strong></td>
                                <td>
                                <input type="number" name="total_horas_pract" id="total_horas_pract" value="<?= $row['total_horas_pract'] ?>" class="form-control form-control-sm rounded-0" placeholder="Ingrese el total de horas">
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



        </div>
    </div>

            
</div>
<noscript id="print-header">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <img src="../uploads/f-39.png" class="img-fluid" alt="" style="max-width: 100%;">
        </div>
    </div>
    <br><br><br><br><br>
</noscript>
<?php

        }
?>