$(function() {
    $('.view_data').click(function() {
        uni_modal("Reporte", "students/view_report.php?id=" + $(this).attr('data-id'), "mid-large")
    });

    $('.table td, .table th').addClass('py-1 px-2 align-middle');
    $('.table').dataTable({
        columnDefs: [{
            orderable: false,
            targets: 5
        }]
    });

    $('#print').click(function() {
        start_loader();
        
        // Guardar el estado actual de DataTables (si es necesario)
        var table = $('.table').DataTable();
        table.destroy();
        
        // Clonar los elementos necesarios
        var _h = $('head').clone();
        var _p = $('#outprint').clone();
        var _ph = $('noscript#print-header').html();
        var _el = $('<div>');
        
        // Modificar estilos para impresión
        _p.find('.btn').remove(); // Eliminar botones
        _p.find('input, textarea, select').attr('readonly', 'readonly').css({
            'border': 'none',
            'background': 'transparent',
            'box-shadow': 'none'
        });
        
        // Asegurar que la tabla se muestre correctamente
        _p.find('table').css({
            'width': '100%',
            'border-collapse': 'collapse'
        });
        
        _p.find('table th, table td').css({
            'border': '1px solid #000',
            'padding': '5px'
        });
        
        // Construir el documento de impresión
        _el.append(_h);
        _el.append(_ph);
        _el.append('<style>' +
           '@page { size: A4; margin: 10mm; }' +
           'body { font-family: Arial; font-size: 12pt; }' +
           '.card-body { padding: 20px; }' +
           'table { page-break-inside: avoid; }' +
           'hr.custom-divider { border-top: 1px solid #000; }' +
           '.justify-content-end { justify-content: flex-end !important; }' +
           '.text-right { text-align: right !important; }' +
           '.justify-content-center { justify-content: center !important; }' +
           '.text-center { text-align: center !important; }' +
           '</style>');
        _el.append(_p);
        
        // Abrir ventana de impresión
        var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200');
        nw.document.write(_el.html());
        nw.document.close();
        
        // Esperar a que se cargue el contenido antes de imprimir
        setTimeout(() => {
            nw.print();
            setTimeout(() => {
                nw.close();
                end_loader();
                
                // Restaurar DataTables si es necesario
                $('.table').dataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 5
                    }]
                });
            }, 300);
        }, 750);
    });
});