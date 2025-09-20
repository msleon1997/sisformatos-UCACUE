<?php

require_once '../config.php';
require_once('../classes/DescargaInforme.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'] ?? null;
    $tipo_practica = $_GET['tipo'] ?? null;

    $base_url = "http://localhost:5170/api/DescargaFormatos";
    $DescargaInformes = new DescargaInforme($base_url);
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($user_id);
    
    

   
    $oficio = null;
     if(isset($row['oficios']) && is_array($row['oficios'])) {
        foreach($row['oficios'] as $item) {
            if(isset($item['odc_tipo_pract']) && $item['odc_tipo_pract'] == $tipo_practica) {
                $oficio = $item;
                break;
            }
        }
    }

 //var_dump($row)
?>


<link rel="stylesheet" href="<?php echo base_url ?>admin/oficio/css/styles.css">
<script src="<?php echo base_url ?>admin/DescargaInformes/js/view.js" defer></script>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header" style="position: sticky; top: 48px; z-index: 999; background-color: white;">
            <div class="card-tools">
                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=DescargaInformes" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
            <h5 class="card-title">VISTA FORMATOS</h5>
            <br>
        </div>

        <div class="card-body">            
            <div class="container-fluid" id="outprint">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <img src="../uploads/f-32.png" class="img-fluid" alt="" style="width: 100%;">
                    </div>
                </div>
                <br><br>
                <?php if ($oficio) { ?>
                <fieldset class="border-bottom">
                    <div class="row">  
                        <div class="form-group col-md-6"> 
                            <label for="odc_fecha" class="control-label">Cuenca:</label>
                            <span><?php echo date('d/m/Y', strtotime($oficio['odc_fecha'])) ?? ''; ?></span>
                        </div>
                        <div class="form-group col -ml-auto justify-content-end">
                            <span><?php echo $oficio['odc_numero'] ?? ''; ?></span>
                        </div>
                    </div>
                    <br> <br> <br>
                    <div class="row">
                        <div class="form-group">
                            <label for="odc_repre_legal" class="control-label">CARGO DEL REPRESENTANTE LEGAL:</label>
                            <h6>Su despacho.-</h6>
                            <span><?php echo $oficio['odc_repre_legal'] ?? ''; ?></span>
                        </div>

                        <div class="form-group">
                            <p>Con un atento saludo me dirijo a usted para solicitarle de la manera más comedida autorice a 
                            <span><?php echo $oficio['odc_nom_est'] ?? ''; ?></span>, con documento de identidad Nº 
                            <span><?php echo $oficio['odc_cedula_est'] ?? ''; ?></span>, estudiante del <span><?php echo $oficio['odc_ciclo_est'] ?? ''; ?></span>, de la carrera de <span><?php echo $oficio['odc_carrera_est'] ?? ''; ?>
                            </span>, de la Unidad Académica de <span><?php echo $oficio['odc_unidad_acade'] ?? ''; ?></span> de la Universidad Católica de Cuenca, para que realice <span><?php echo $oficio['odc_num_horas'] ?? ''; ?>
                            </span> horas correspondientes a las <?php echo $oficio['odc_tipo_pract'] ?? ''; ?> en el área de <span><?php echo $oficio['odc_area'] ?? ''; ?></span> de su dependencia; siendo este requisito indispensable para cumplir con el Plan de Estudios de la Carrera. 
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
                            <span><?php echo $oficio['odc_director_carrera'] ?? ''; ?></span>
                        </div>
                    </div>    
                    <div class="row justify-content-center">  
                        <div class="form-group text-center">  
                            <label for="odc_unidad_acade" class="control-label">UNIDAD ACADÉMICA DE:</label>
                            <span><?php echo $oficio['odc_unidad_acade'] ?? ''; ?></span>
                        </div>
                    </div>
                        
                    <br>

                    <div class="row">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="2">NOMBRE Y CARGO DE LA PERSONA QUE AUTORIZA</th>
                                <th>AUTORIZACIÓN</th>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    <div class="form-group">
                                        <span><?php echo $oficio['odc_autorizacion'] ?? ''; ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="odc_nombre_per_aut" class="control-label">Nombre:</label></td>
                                <td><span><?php echo $oficio['odc_nombre_per_aut'] ?? ''; ?></span></td>
                                <td colspan="2" rowspan="2">f.</td>
                            </tr>
                            <tr>
                                <td><label for="odc_per_aut_cargo" class="control-label">Cargo:</label></td>
                                <td><span><?php echo $oficio['odc_per_aut_cargo'] ?? ''; ?></span></td>
                            </tr>
                            <tr>
                                <td colspan="4"><label for="odc_nombre_tutor" class="control-label">Nombre del tutor que asigna la institución: </label>
                                <span><?php echo $oficio['odc_nombre_tutor'] ?? ''; ?></span></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
                <?php } else {?>
                    <div class="container mt-5">
                        <div class="alert alert-danger text-center" role="alert">
                            No se encontraron registros para la práctica seleccionada.
                        </div>
                    </div>
              
                <?php }?>
                
                
            </div>
        </div>
        <?php 
        include_once('view_planificacion.php');
        ?>
        <?php 
        include_once('view_actividadesPract.php');
        ?>
        <?php 
        include_once('view_cronoActPract.php');
        ?>
        <?php 
        include_once('view_actaCompro.php');
        ?>
        <?php 
        include_once('view_cumplimientoHoras.php');
        ?>
        <?php 
        include_once('view_evaluacionPractica.php');
        ?>
        <?php 
        include_once('view_evaluacionesFinales.php');
        ?>
        <?php 
        include_once('view_informesFinales.php');
        ?>
        <?php 
        include_once('view_informeTutorias.php');
        ?>
        <?php 
        include_once('view_certificadoFinal.php');
        ?>

    </div>
</div>

<?php 
}
?>