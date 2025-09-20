$(document).ready(function () {
    $('#print').click(function () {
        start_loader();

        var _h = $('head').clone();
        var _p = $('<div>').append($('#outprint').clone());
        var _ph = $('noscript#print-header').html();

        _p.find('input, select, textarea').each(function () {
            const type = $(this).attr('type');
            if (type === 'hidden') return;

            const value = $(this).val();
            const tag = $(this)[0].tagName.toLowerCase();

            let text = value;
            if (tag === 'select') {
                text = $(this).find('option:selected').text();
            }

            const span = $('<span>').text(text);
            $(this).replaceWith(span);
        });


        var _el = $('<div>');
        _el.append(_h); 
        _el.append('<title>F-VS-34 Cumplimiento de horas - Print View</title>');
        _el.append(_ph); 
        _el.append(_p);  

        // Abrir nueva ventana e imprimir
        var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200');
        nw.document.write('<!DOCTYPE html>');
        nw.document.write('<html>');
        nw.document.write('<head>' + _h.html() + '</head>');
        nw.document.write('<body onload="window.print()">');
        nw.document.write(_ph); 
        nw.document.write(_p.html());
        nw.document.write('</body></html>');
        nw.document.close();

        end_loader();
    });
});
