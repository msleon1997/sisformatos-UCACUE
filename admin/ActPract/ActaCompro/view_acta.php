<?php
require_once '../config.php';
require_once('../classes/ActaCompro.php');
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Verificar si se proporcionó un id válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el id de la URL
    $id = $_GET['id'];

    // URL base de la API
    $base_url = "http://localhost:5170/api/ActaCompromiso"; 

    $actaCompro = new ActaCompro($base_url);
    
    $row = $actaCompro->obtenerActaComproPorId($id);

    // Verificar si se obtuvieron datos
    
?>
<link rel="stylesheet" href="<?php echo base_url ?>admin/ActPract/ActaCompro/css/styles.css">

<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
        
            <div class="card-tools">
            <?php if ($_settings->userdata('type') == 1): // Usuario tipo 1 (Estudiante) ?>
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=ActPract/ActaCompro/manage_acta&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Editar</a>
                <a class="btn btn-sm btn-danger btn-flat" href="./?page=ActPract/ActaCompro/delete_acta&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-trash"></i> Eliminar</a>
            <?php endif; ?>    
                <button class="btn btn-sm btn-success bg-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                <a href="./?page=ActPract/ActaCompro" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Volver</a>
            </div>
            
                <h3 class="card-title">ANEXOS</h3>
                <br>
                <h5 class="card-title">1. ACTA DE COMPROMISO</h5>
            
        </div>

        <div class="card-body">

            <div class="container-fluid" id="outprint">
                <div id="ActaCompromiso_frm">
                    <input type="hidden" name="id" value="<?php echo $row["id"] ?>">

                    <div class="form-group">
                        <?php
                               $estudiantes = explode("; ", $row['acta_NombresEstudiante'] ?? '');  
                               $carreras = explode("; ", $row['acta_Carrera'] ?? '');
                               $unidadAcademica = explode("; ", $row['acta_UnidadAcademica'] ?? '');
                               $empresas = explode("; ", $row['acta_NombreEmpresa'] ?? '');
                               $tipoPracticas = explode("; ", $row['acta_TipoPractica'] ?? '');

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
                    <input type="hidden" name="users_id" value="<?php echo $_settings->userdata('id')?>">

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


<script>
    $('#print').click(function() {
    start_loader();

    // Clonar contenido para imprimir
    var _head = $('head').clone();
    var _content = $('#outprint').clone();
    var _header = $('noscript#print-header').html();

    // Crear ventana de impresión
    var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200');
    nw.document.write(`
        <html>
        <head>
            ${_head.html()}
            <style>
                /* Ajustes específicos para impresión */
                body { font-family: Arial, sans-serif; margin: 20px; }
                .custom-divider { margin: 20px 0; border-top: 2px solid #000; }
                .img-firma { display: block; margin: auto; }
            </style>
        </head>
        <body>
            ${_header}
            ${_content.html()}
        </body>
        </html>
    `);
    nw.document.close();

    // Esperar y luego imprimir
    nw.onload = function() {
        nw.print();
        nw.close();
        end_loader();
    };
});

</script>