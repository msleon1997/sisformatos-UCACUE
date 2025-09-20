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
                .firma-est {
                    margin: auto;
                    display: block;
                    text-align: center;
                }
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
