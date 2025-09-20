<?php 
require_once '../config.php';
require_once('../classes/OficioCarrera.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $base_url = "http://localhost:5170/api/OficioDireccionCarrera"; 

    $oficioCarrera = new OficioCarrera($base_url);

    $row = $oficioCarrera->obtenerOficioCarreraPorId($id);

    if (isset($row['odc_fecha'])) $odc_fecha = explode('T', $row['odc_fecha'])[0];
?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/oficio/css/styles.css">
<script src="<?php echo base_url ?>admin/oficio/js/view.js" defer></script>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): // Usuario tipo 1 (Estudiante) ?>                <a class="btn btn-sm btn-primary btn-flat" href="./?page=oficio/manage_oficio&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=oficio/delete_oficio&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
            <?php endif; ?>   
                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=oficio" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            
            </div>
            <h5 class="card-title">OFICIO DIRECCIÓN DE CARRERA</h5>
            <br>
        </div>

        <div class="card-body">
            <div class="container-fluid" id="outprint">
                
                <fieldset class="border-bottom">
                    <div class="row">  
                        <div class="form-group col-md-6"> 
                            <label for="odc_fecha" class="control-label">Cuenca:</label>
                            <span><?php echo $odc_fecha; ?></span>
                        </div>
                        <div class="form-group col -ml-auto justify-content-end">
                            <input type="text" name="odc_numero" id="odc_numero" value="<?php echo $row['odc_numero']; ?>" class="form-control form-control-sm rounded-0" required>
                        </div>
                    </div>
                    <br> <br> <br>
                    <div class="row">
                        <div class="form-group">
                            <label for="odc_repre_legal" class="control-label">CARGO DEL REPRESENTANTE LEGAL:</label>
                            <h6>Su despacho.-</h6>
                            <span><?php echo $row['odc_repre_legal']; ?></span>
                        </div>

                        <div class="form-group">
                            <p>Con un atento saludo me dirijo a usted para solicitarle de la manera más comedida autorice a 
                            <span><?php echo $row['odc_nom_est']; ?></span>, con documento de identidad Nº 
                            <span><?php echo $row['odc_cedula_est']; ?></span>, estudiante del <span><?php echo $row['odc_ciclo_est']; ?></span>, de la carrera de <span><?php echo $row['odc_carrera_est']; ?></span>, de la Unidad Académica de <span><?php echo $row['odc_unidad_acade']; ?></span> de la Universidad Católica de Cuenca, para que realice <span><?php echo $row['odc_num_horas']; ?></span> horas correspondientes a las <span><?php echo $row['odc_tipo_pract']; ?></span> en el área <span><?php echo $row['odc_area']; ?></span> de su dependencia; siendo este requisito indispensable para cumplir con el Plan de Estudios de la Carrera. 
                            Pido de favor consignar su aceptación en el casillero del cuadro que se indica a continuación con firma y sello de la institución, e indicar el nombre del profesional que asignarán como tutor para el seguimiento de la práctica pre profesional por parte de su institución.</p>
                        </div>
                        <div class="form-group">
                            <h6>Con sentimientos de consideración y estima, suscribo</h6>
                        </div>
                    </div>

                    <hr class="custom-divider">
                    <br>
                    <div class="row justify-content-center">  
                        <div class="form-group text-center">  
                            <h5>Atentamente, <br> DIOS, PATRIA, CULTURA Y DESARROLLO</h5>
                            <br>
                        </div>
                    </div>    
                    <div class="row justify-content-center">
                        <div class="form-group text-center">  
                            <label for="odc_director_carrera" class="control-label">DIRECTOR DE CARRERA:</label>
                            <span><?php echo $row['odc_director_carrera']; ?></span>
                        </div>
                    </div>    
                    <div class="row justify-content-center">  
                        <div class="form-group text-center">  
                            <label for="odc_unidad_acade" class="control-label">UNIDAD ACADÉMICA DE:</label>
                            <span><?php echo $row['odc_unidad_acade']; ?></span>
                        </div>
                    </div>
                        
                   
                    <br>

                    <div class="row">
                        <table>
                            <tr>
                                <th colspan="2">NOMBRE Y CARGO DE LA PERSONA QUE AUTORIZA</th>
                                <th>AUTORIZACIÓN</th>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    <div class="form-group">
                                        <span><?php echo $row['odc_autorizacion']; ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="odc_nombre_per_aut" class="control-label">Nombre:</label></td>
                                <td><span><?php echo $row['odc_nombre_per_aut']; ?></span></td>
                                <td colspan="2" rowspan="2">f.</td>
                            </tr>
                            <tr>
                                <td><label for="odc_per_aut_cargo" class="control-label">Cargo:</label></td>
                                <td><span><?php echo $row['odc_per_aut_cargo']; ?></span></td>
                            </tr>
                            <tr>
                                <td colspan="4"><label for="odc_nombre_tutor" class="control-label">Nombre del tutor que asigna la institución: </label>
                                <span><?php echo $row['odc_nombre_tutor']; ?></span></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
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
            <img src="../uploads/f-32.png" class="img-fluid" alt="" style="max-width: 100%;">
        </div>
    </div>
    <br><br><br><br><br>
</noscript>

