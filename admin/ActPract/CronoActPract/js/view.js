$('#print').click(function() {
    start_loader();

    // Clonar contenido
    var _h = $('head').clone();
    var _p = $('#outprint').clone();
    var _ph = $('noscript#print-header').html();
    var _el = $('<div>');

    // Añadir hoja de estilo de impresión
    _el.append('<style>@media print { \
        table { \
            border-collapse: collapse; \
            width: 100%; \
        } \
        table th, table td { \
            border: 1px solid #000; \
            text-align: center; \
            padding: 0; \
            margin: 0; \
        } \
        .dias-adaptable { \
            width: 13.6px; \
            height: 18px; \
            text-align: center; \
            padding: 0; \
            margin: 0; \
            border: 1px solid #000; \
        } \
        \
        \
        \
    }</style>');
    
    _el.append(_ph);
    _el.append(_p);

    // Crear nueva ventana de impresión
    var nw = window.open('', '_blank', 'width=1000,height=800,top=50,left=200');
    nw.document.write('<html><head>' + _el.find('head').html() + '</head><body>' + _el.html() + '</body></html>');
    nw.document.close();

    // Imprimir
    setTimeout(() => {
        nw.print();
        setTimeout(() => {
            nw.close();
            end_loader();
        }, 300);
    }, 750);
});
