$('#print').click(function() {
    start_loader();

    // **1. Actualizar el contenido de CKEditor y obtener el HTML limpio**
    if (typeof CKEDITOR !== 'undefined') {
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();  // Sincroniza con textarea
        }
    }

    // **2. Destruir DataTables temporalmente**
    $('#academic-history').dataTable().fnDestroy();

    // **3. Clonar el contenido para impresión**
    var _h = $('<head>').html($('head').html());
    var _p = $('#outprint').clone();  // Clona el contenedor de impresión
    var _ph = $('noscript#print-header').html();
    var _el = $('<div>');
    
    // **4. Reemplazar el textarea con contenido CKEditor renderizado**
    _p.find('textarea').each(function() {
        var editorId = $(this).attr('id');
        var editorContent = CKEDITOR.instances[editorId].getData();  // Obtener HTML del editor
        var newDiv = $('<div class="ckeditor-content">').html(editorContent);
        $(this).after(newDiv);  // Inserta el contenido después del textarea sin reemplazarlo
    });
    

    // **5. Construir el documento de impresión**
    _el.append(_h);
    _el.append(_ph);
    _el.find('title').text('INFORME DE TUTORIAS DE LAS ACTIVIDADES PRÁCTICA LABORAL Y/O DE SERVICIO COMUNITARIO - Print View');
    _el.append(_p);

    // **6. Abrir una nueva ventana para la vista de impresión**
    var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200');
    nw.document.write(_el.html());
    nw.document.close();

    // **7. Imprimir y cerrar la ventana emergente**
    nw.onload = function() {
        nw.print();
        setTimeout(() => {
            nw.close();
            end_loader();
        }, 300);
    };
});
var printStyles = `
    <style>
        @media print {
            /* Ocultar la estructura del CKEditor */
            .cke, .cke_reset, .cke_inner { display: none !important; }

            /* Mostrar solo el contenido */
            .ckeditor-content {
                display: block !important;
                white-space: pre-wrap;
                font-family: inherit;
                font-size: inherit;
                text-align: justify;
                margin: 0;
                padding: 0;
            }

            /* Asegurar que no haya márgenes adicionales */
            textarea {
                display: none !important;  /* Ocultar textarea */
            }
        }
    </style>`
;

$('head').append(printStyles);  // Agrega los estilos para impresión