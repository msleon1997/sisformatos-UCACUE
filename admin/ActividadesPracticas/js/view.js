$('#print').click(function() {
    start_loader();
    
    // Clonamos el contenido del documento para la vista de impresión
    var _h = $('head').clone();  
    var _p = $('#outprint').clone();  
    var _ph = $('noscript#print-header').html();  
    var _el = $('<div>'); 
    

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
    _el.append(_h);
    _el.append(_ph);  
    
    // Aseguramos que no se modifiquen las clases de las columnas (para evitar que se cambien en la vista de impresión)
    _el.find('.row').removeClass('row-cols-md-2');
    _el.find('.col-md-6').removeClass('col-md-12').addClass('col-md-6');  
    
    // Apéndice del contenido que se va a imprimir
    _el.append(_p);

    // Creamos una nueva ventana de impresión
    var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200');
    nw.document.write(_el.html()); 
    nw.document.close();
    
    // Estilo para asegurarse de que los datos sean visibles
    setTimeout(() => {
        nw.print();  
        setTimeout(() => {
            nw.close();  
            end_loader();  
        }, 300);
    }, 750);  
});
