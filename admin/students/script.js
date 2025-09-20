
// JS de eliminar matricula
$(function() {
    // Eliminar la función clic anterior del botón eliminar
    $('#btn-eliminar').off('click');
    
    // Adjuntar una nueva función clic al botón eliminar
    $('#btn-eliminar').click(function(event) {
        // Prevenir el envío del formulario y manejarlo manualmente
        event.preventDefault();
        
        // Enviar el formulario con la acción de eliminación
        $('#matriculacion_frm_delete').submit();
        
        
    });
    
       

});

$(function() {
   

    $('.view_data').click(function() {
        uni_modal("Reporte", "students/view_report.php?id=" + $(this).attr('data-id'), "mid-large")
    })
    $('.table td, .table th').addClass('py-1 px-2 align-middle')
    $('.table').dataTable({
        columnDefs: [{
            orderable: false,
            targets: 5
        }],
    });


    $('#print').click(function() {
        start_loader()
        $('#academic-history').dataTable().fnDestroy()
        var _h = $('head').clone()
        var _p = $('#outprint').clone()
        var _ph = $($('noscript#print-header').html()).clone()
        var _el = $('<div>')
        _p.find('tr.bg-gradient-dark').removeClass('bg-gradient-dark')
        _p.find('tr>td:last-child,tr>th:last-child,colgroup>col:last-child').remove()
        _p.find('.badge').css({
            'border': 'unset'
        })
        _el.append(_h)
        _el.append(_ph)
        _el.find('title').text('Registros Estudiante - Print View')
        _el.append(_p)


        var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200')
        nw.document.write(_el.html())
        nw.document.close()
        setTimeout(() => {
            nw.print()
            setTimeout(() => {
                nw.close()
                end_loader()
                $('.table').dataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 5
                    }],
                });
            }, 300);
        }, (750));


    })
})














