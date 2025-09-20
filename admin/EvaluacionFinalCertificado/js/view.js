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
        var _ph = $('noscript#print-header').html();
        var _space = $('<hr class="custom-divider">');
        var _el = $('<div>').addClass('page');
        var _img = $('<img src>');

        _p.find('tr.bg-gradient-dark').removeClass('bg-gradient-dark');
        _p.find('tr>td:last-child,tr>th:last-child,colgroup>col:last-child').addClass();
        _p.find('.badge').css({'border': 'unset'});

        _el.append(_h);
        _el.append(_ph);
        _el.find('title').text('Evaluacion final y certificado - Print View');
        _el.append(_p);

        var nw = window.open('', '_blank', 'width=1024,height=900,top=50,left=200');
        nw.document.write(_el.html());
        nw.document.close();

        setTimeout(() => {
            nw.print();
            setTimeout(() => {
                nw.close();
                end_loader();
                _el.append(_space);
                $('.table').dataTable({
                    columnDefs: [{orderable: false, targets: 6}],
                });
            }, 300);
        }, 750);
    });


});



/* Función para calcular subtotales */
function calcularSubtotal1() {
    let subtotal = 0;
    
    // Itera sobre cada pregunta en la sección RCAPregunta y suma el valor del text button seleccionado
    for (let i = 1; i <= 5; i++) {
        const textSeleccionado = document.querySelector(`div[name="RCAPregunta${i}"]:checked`);
        if (textSeleccionado) {
            subtotal += parseInt(textSeleccionado.value, 10); 
        }
    }
    
    // Asigna el subtotal calculado al campo correspondiente
    document.getElementById('Subtotal1').value = subtotal;
}



function calcularSubtotal2() {
    let subtotal = 0;
    
    // Itera sobre cada pregunta en la sección RCAPregunta y suma el valor del text button seleccionado
    for (let i = 1; i <= 5; i++) {
        const textSeleccionado = document.querySelector(`div[name="ACPregunta${i}"]:checked`);
        if (textSeleccionado) {
            subtotal += parseInt(textSeleccionado.value, 10); 
        }
    }
    
    // Asigna el subtotal calculado al campo correspondiente
    document.getElementById('Subtotal2').value = subtotal;
}


function calcularSubtotal3() {
    let subtotal = 0;
    
    // Itera sobre cada pregunta en la sección RCAPregunta y suma el valor del text button seleccionado
    for (let i = 1; i <= 5; i++) {
        const textSeleccionado = document.querySelector(`div[name="HDPregunta${i}"]:checked`);
        if (textSeleccionado) {
            subtotal += parseInt(textSeleccionado.value, 10);
        }
    }
    
    document.getElementById('Subtotal3').value = subtotal;
}

function calcularSubtotal4() {
    let subtotal = 0;
    
    // Itera sobre cada pregunta en la sección RCAPregunta y suma el valor del text button seleccionado
    for (let i = 1; i <= 5; i++) {
        const textSeleccionado = document.querySelector(`div[name="AAPregunta${i}"]:checked`);
        if (textSeleccionado) {
            subtotal += parseInt(textSeleccionado.value, 10); 
        }
    }
    
    document.getElementById('Subtotal4').value = subtotal;
}

function calcularTotal() {
    let total = 0;

    const subtotal1 = parseInt(document.getElementById('Subtotal1').value, 10) || 0;
    const subtotal2 = parseInt(document.getElementById('Subtotal2').value, 10) || 0;
    const subtotal3 = parseInt(document.getElementById('Subtotal3').value, 10) || 0;
    const subtotal4 = parseInt(document.getElementById('Subtotal4').value, 10) || 0;

    total = subtotal1 + subtotal2 + subtotal3 + subtotal4;
    
    document.getElementById('Total').value = total;
}
