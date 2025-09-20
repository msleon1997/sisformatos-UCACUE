//CSS PARA view_planificacion.php

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
        $('#academic-history').dataTable().fnDestroy();
        var _h = $('head').clone();
        var _p = $('#outprint').clone();
        var _ph = $('noscript#print-header').html(); // Revertido a html()
        var _space = $('<hr class="custom-divider">');
        var _el = $('<div>');

        _p.find('tr.bg-gradient-dark').removeClass('bg-gradient-dark');
        _p.find('tr>td:last-child,tr>th:last-child,colgroup>col:last-child').remove();
        _p.find('.badge').css({
            'border': 'unset'
        });

        _el.append(_h);
        _el.append(_ph);
        _el.find('title').text('Planificacion Marzo 2024-Agosto 2024 - Print View');
        _el.append(_p);

        var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200');
        nw.document.write(_el.html());
        nw.document.close();

        setTimeout(() => {
            nw.print();
            setTimeout(() => {
                nw.close();
                end_loader();
                _el.append(_space);
                $('.table').dataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 5
                    }],
                });
            }, 300);
        }, (750));
    });
});