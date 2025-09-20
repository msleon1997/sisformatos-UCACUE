$('#print').click(function () {
    start_loader();

    var _p = $('#outprint').clone();
    var _ph = $('noscript#print-header').html();

    // Reemplaza inputs por spans con el mismo valor
    _p.find('input').each(function () {
        var val = $(this).val();
        $(this).replaceWith('<span>' + val + '</span>');
    });

    var newWindow = window.open('', '', 'width=1000,height=900');

    newWindow.document.write(`
        <html>
        <head>
            <title>Registro de horas</title>
            <style>
                ${$('style').html()}
            </style>
        </head>
        <body>
            ${_ph}
            ${_p.html()}
        </body>
        </html>
        <style>
            @media print {
                body {
                    font-size: 13px;
                    margin: 40px;
                }

                .card-header, .card-title {
                    text-align: center;
                }

                

                .form-control {
                    //border: 1px solid #000 !important;
                    padding: 5px;
                    background: none;
                    font-size: 13px;
                }

                .form-control[readonly], .form-control[disabled] {
                    background: none !important;
                    color: #000 !important;
                    -webkit-print-color-adjust: exact;
                }

                input[type="text"],
                input[type="date"] {
                    border: none;
                    background: transparent;
                    width: 100%;
                    font-size: 13px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }

                table th, table td {
                    border: 1px solid #000;
                    padding: 6px 8px;
                    font-size: 13px;
                    vertical-align: middle;
                }

                .btn, .card-tools, .dataTables_wrapper, .pagination {
                    display: none !important;
                }

                #outprint {
                    padding: 0px 20px;
                }

                .row {
                    display: flex;
                    flex-wrap: wrap;
                }

                .form-group.col-md-6 {
                    width: 48%;
                    margin-right: 4%;
                }

                .form-group.col-md-6:nth-child(2n) {
                    margin-right: 0;
                }
            }
        </style>

    `);

    newWindow.document.close();

    setTimeout(function () {
        newWindow.print();
        newWindow.close();
        end_loader();
    }, 700);
});
