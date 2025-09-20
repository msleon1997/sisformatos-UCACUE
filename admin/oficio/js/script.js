//JS DE index.php

function displayImg(input, _this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
/* $('#manage-user').submit(function(e) {
    e.preventDefault();
    var _this = $(this)
    start_loader()
    $.ajax({
        url: _base_url_ + 'classes/Users.php?f=save',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                location.reload()
            } else {
                $('#msg').html('<div class="alert alert-danger">Usuario ya existe</div>')
                end_loader()
            }
        }
    })
}) */


// Filtrar los estudiantes en la tabla al escribir en el campo de búsqueda
/* document.getElementById('searchInput').addEventListener('keyup', function() {
var input = document.getElementById('searchInput').value.toLowerCase();
var table = document.querySelector('.table tbody');
var rows = table.getElementsByTagName('tr');

for (var i = 0; i < rows.length; i++) {
    var cedula = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
    var nombre = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
    var carrera = rows[i].getElementsByTagName('td')[3].textContent.toLowerCase();
    var email = rows[i].getElementsByTagName('td')[7].textContent.toLowerCase();

    if (cedula.includes(input) || nombre.includes(input) || carrera.includes(input) || email.includes(input)) {
        rows[i].style.display = '';
    } else {
        rows[i].style.display = 'none';
    }
}
}); */



function cambiarDatosPractica() {
    const tipoPractica = document.getElementById("odc_tipo_pract").value;
    const cicloInput = document.getElementById("odc_ciclo_est");
    const horasSelect = document.getElementById("odc_num_horas");

    const registro = registros.find(item => item.area === tipoPractica);

    if (registro) {
        cicloInput.value = registro.ciclo;

        // Lógica para cambiar las horas según el tipo de práctica
        if (tipoPractica === "Practicas Internas") {
            horasSelect.value = "120";
        } else if (tipoPractica === "Practicas Pre-Profesionales") {
            horasSelect.value = "240";
        } else if (tipoPractica === "Practicas Vinculacion con la sociedad") {
            horasSelect.value = "240";
        }
    }
}
