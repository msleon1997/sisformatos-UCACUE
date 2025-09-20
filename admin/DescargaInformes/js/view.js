$(function() {
    $('#print').click(function() {
        start_loader();
        
        // Clonar ambas secciones
        var printContentOficio = $('#outprint').clone();
        var printContentPlanificacion = $('#outprint-1').clone();
        var printContentActPract = $('#outprint-2').clone();
        var cronogramaActPract = $('#outprint-3').clone();
        var actaCrompro = $('#outprint-4').clone();
        var cumplimientoHoras = $('#outprint-5').clone();
        var evaluacionPractica = $('#outprint-6').clone();
        var evaluacionesFinales = $('#outprint-7').clone();
        var informesFinales = $('#outprint-8').clone();
        var informeTutorias = $('#outprint-9').clone();
        var certificadoFinal = $('#outprint-10').clone();

        printContentOficio.find('.no-print').remove();
        printContentOficio.find('.btn').remove();

        printContentPlanificacion.find('.no-print').remove();
        printContentPlanificacion.find('.btn').remove();

        printContentActPract.find('.no-print').remove();
        printContentActPract.find('.btn').remove();
        
        cronogramaActPract.find('.no-print').remove();
        cronogramaActPract.find('.btn').remove();

        actaCrompro.find('.no-print').remove();
        actaCrompro.find('.btn').remove();
        
        cumplimientoHoras.find('.no-print').remove();
        cumplimientoHoras.find('.btn').remove();
        
        evaluacionPractica.find('.no-print').remove();
        evaluacionPractica.find('.btn').remove();

        evaluacionesFinales.find('.no-print').remove();
        evaluacionesFinales.find('.btn').remove();

        informesFinales.find('.no-print').remove();
        informesFinales.find('.btn').remove();

        informeTutorias.find('.no-print').remove();
        informeTutorias.find('.btn').remove();

        certificadoFinal.find('.no-print').remove();
        certificadoFinal.find('.btn').remove();


        if (typeof CKEDITOR !== 'undefined') {
    for (var instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

informesFinales.find('textarea').each(function () {
    var textarea = $(this);
    var content = textarea.val();
    var displayDiv = $('<div class="ckeditor-print-content"></div>').html(content);

    textarea.closest('.cke').remove(); 
    textarea.after(displayDiv);        
    textarea.remove();                
});

informesFinales.find('.cke, .cke_reset, .cke_inner').remove();
    informesFinales.find('textarea').each(function () {
        var textarea = $(this);
        var content = textarea.val(); 
        var displayDiv = $('<div class="ckeditor-print-content"></div>').html(content);
        textarea.after(displayDiv); 
        textarea.remove(); 
    });

   

        // Estilos CSS 
        var styles = `
            <style>
                @page {
                    size: A4;
                    margin: 10mm;
                }
                body {
                    font-family: Arial;
                    font-size: 12pt;
                    margin: 0;
                    padding: 0;
                }
                #seccion-oficio, #seccion-planificacion {
                    page-break-after: auto;
                    margin-bottom: 20mm;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 10px;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 8px;
                    text-align: left;
                }
                .img-fluid {
                    max-width: 100%;
                    height: auto;
                }
                .mt-5 {
                    margin-top: 3rem !important;
                }
                .page-break {
                    page-break-after: always;
                }
                    
               .form-control-sm {
                    height: calc(1.8125rem + 2px);
                    padding: 0.25rem 0.5rem;
                    font-size: 0.875rem;
                    line-height: 1.5;
                    border-radius: 0.2rem;
                    border-color: transparent;
                }

                table-crono { 
                border-collapse: collapse; 
                width: 100%; 
                } 
                table-crono th, table td { 
                    border: 1px solid #000; 
                    //text-align: center; 
                    padding: 0; 
                    margin: 0; 
                    
                } 
                .dias-adaptable { 
                    
                    width: 13.6px; 
                    height: 18px; 
                    //text-align: center; 
                    padding: 0; 
                    margin: 0; 
                    border: 1px solid #000; 
                } 

                textarea {
                    height: auto !important;
                    overflow: visible !important;
                    resize: none !important;
                    border: 1px solid #000 !important;
                    white-space: pre-wrap;
                    width: 100%;
                }

               .ckeditor-print-content {
                    white-space: pre-wrap;
                    font-family: inherit;
                    font-size: 12pt;
                    border: 1px solid #000;
                    padding: 0.5rem;
                    margin-top: 0.5rem;
                    text-align: justify;
                }

                 @media print {
                /* Ocultar la estructura del CKEditor */
                .cke, .cke_reset, .cke_inner { display: none !important; }

                /* Ajustar el contenido de CKEditor */
                .ckeditor-content {
                    display: block !important;
                    white-space: pre-wrap;
                    font-family: inherit;
                    font-size: inherit;
                    text-align: justify;
                    margin: 0;
                    padding: 0;
                }
                /* Añadir márgenes y padding entre las tablas si es necesario */
                    .table-block {
                        margin-bottom: 20px !important; /* Espaciado entre tablas */
                    }

                    /* Mejorar el diseño de los campos dentro de la tabla */
                    td {
                        vertical-align: top; /* Alineación de los campos en la parte superior de las celdas */
                    }

                    .img-anexos{
                        margin: auto;
                        display: block;
                    }

                    .img-aprobaciones{
                        margin: auto;
                        display: block;
                    }

                }
            </style>

            
        `;
        
        var printWindow = window.open('', '_blank', 'width=800,height=600');
        
        printWindow.document.open();
        printWindow.document.write(`
            <html>
                <head>
                    <title>Impresión de Documento</title>
                    ${styles}
                </head>
                <body>
                    ${printContentOficio.html()}
                     <div class="page-break"></div>
                    ${printContentPlanificacion.html()}
                    <div class="page-break"></div>
                    ${printContentActPract.html()}

                    ${cronogramaActPract.html()}
                    <div class="page-break"></div>
                    ${actaCrompro.html()}

                    <div class="page-break"></div>
                    ${cumplimientoHoras.html()}

                    <div class="page-break"></div>
                    ${evaluacionPractica.html()}
                    
                    <div class="page-break"></div>
                    ${evaluacionesFinales.html()}

                    <div class="page-break"></div>
                    ${informesFinales.html()}

                    <div class="page-break"></div>
                    ${informeTutorias.html()}
                    
                    <div class="page-break"></div>
                    ${certificadoFinal.html()}

                    <script>
                        setTimeout(function() {
                            window.print();
                            setTimeout(function() {
                                window.close();
                            }, 300);
                        }, 500);
                    </script>
                </body>
            </html>
        `);
        printWindow.document.close();
        
        end_loader();
    });


    
});