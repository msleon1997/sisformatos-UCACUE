<?php

require_once '../config.php';
require_once('../classes/DescargaInforme.php');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $tipo_practica = $_GET['tipo'] ?? ''; 

    $base_url = "http://localhost:5170/api/DescargaFormatos"; 
    $DescargaInformes = new DescargaInforme($base_url);
    $row = $DescargaInformes->obtenerFormatosCompletosPorUser($id);

    $actaCompro = null;
    if(isset($row['actaCompromiso']) && is_array($row['actaCompromiso'])) {
        foreach($row['actaCompromiso'] as $item) {
            if(isset($item['acta_TipoPractica']) && $item['acta_TipoPractica'] == $tipo_practica) {
                $actaCompro = $item;
                break;
            }
        }
    }
    


  
?>

<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/ActaCompro/css/styles.css">
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-body">
        <div class="container-fluid" id="outprint-4">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <img src="../uploads/f-33.png" class="img-fluid" alt="" style="width: 100%;">
                    </div>
                </div>
                <br><br>
                <div class="form-group text-center">
                    <h3 class="card-title">7. ANEXOS</h3>
                    <br>
                    <h5 class="card-title">1. ACTA DE COMPROMISO</h5>
                </div>
                <br>

             <?php if($actaCompro): ?>
            <div id="ActaCompromiso_frm">

                    <div class="form-group">
                        <?php
                               $estudiantes = explode("; ", $actaCompro['acta_NombresEstudiante'] ?? ''); 
                               $carreras = explode("; ", $actaCompro['acta_Carrera'] ?? '');
                               $unidadAcademica = explode("; ", $actaCompro['acta_UnidadAcademica'] ?? '');
                               $empresas = explode("; ", $actaCompro['acta_NombreEmpresa'] ?? '');
                               $tipoPracticas = explode("; ", $actaCompro['acta_TipoPractica']);

                               $count = max(count($estudiantes), count($carreras), count($unidadAcademica), count($empresas), count($tipoPracticas));

                               for ($i = 0; $i < $count; $i++) {
                                echo "<p>"; 
                                echo "Yo, ";
                                echo "<strong>" . htmlspecialchars($estudiantes[$i] ?? '') . "</strong>, estudiante de la carrera de ";      
                                echo "<strong>" . htmlspecialchars($carreras[$i] ?? '') . "</strong> de la Unidad Académica de ";      
                                echo "<strong>" . htmlspecialchars($unidadAcademica[$i] ?? '') . "</strong>, por medio de la presente me comprometo con ";      
                                echo "<strong>" . htmlspecialchars($empresas[$i] ?? '') . "</strong>. A fin de llevar a cabo las ";
                                echo "<strong>" . htmlspecialchars($tipoPracticas[$i] ?? '') . "</strong>, con responsabilidad y total acatamiento a las disposiciones y normas internas de la entidad auspiciadora y/o Proyecto, del Reglamento e Instructivo de prácticas de la Universidad Católica de Cuenca y dando cumplimiento a la presente planificación.";      
                                echo "</p>";  
                                echo "<br><br><br><br>";
                            }
                            
                        ?>
                        
                    </div>
                <td>
                                    
                <p class="firma-est" style="
                    margin: auto;
                    display: block;
                    text-align: center;
                ">
                _________________________________________________________________________
                    <br>
                     Firma Estudiante</p>
                
                </td>

                </div>
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