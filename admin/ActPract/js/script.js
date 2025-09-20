//JS DE index.php



// Agregar más registros a la tabla
 function addFieldset() {
    // Contenedor principal
    const container = document.getElementById('fieldsets-container');
    // Crear un nuevo elemento div
    const newFieldset = document.createElement('div');
    newFieldset.classList.add('fieldset-container');
    
    // Contenido HTML para los campos (similar al original)
    newFieldset.innerHTML = `
        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Nombres:</th>
                                    <td colspan="2" style="width: 75%;"><input type="text" name="App_Nom_est[]" class="form-control"></td>
                                </tr>
                                <tr>
                                    <th>Nº de cédula</th>
                                    <th>Nº celular</th>
                                    <th>E-mail</th>
                           
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="App_Cedula_est[]" class="form-control"  maxlength="10"  ></td>
                                    <td><input type="text" name="App_Celular_est[]" class="form-control" ></td>
                                    <td><input type="text" name="App_Email_est[]" class="form-control"  ></td>
                                    
                                </tr>
                            </tbody>
                        </table>
        <button class="remove-btn" onclick="removeFieldset(this)">Quitar</button>
    `;
    // Añadir el nuevo conjunto de campos al contenedor
    container.appendChild(newFieldset);
}


function removeFieldset(button) {
    // Eliminar el fieldset que contiene el botón clicado
    button.parentElement.remove();
}



/*
// Filtrar los estudiantes en la tabla al escribir en el campo de búsqueda
document.getElementById('searchInput').addEventListener('keyup', function() {
var input = document.getElementById('searchInput').value.toLowerCase();
var table = document.querySelector('.table tbody');
var rows = table.getElementsByTagName('tr');

for (var i = 0; i < rows.length; i++) {
    var empresa = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
    var nombre = rows[i].getElementsByTagName('td')[6].textContent.toLowerCase();
    var cedula = rows[i].getElementsByTagName('td')[7].textContent.toLowerCase();

    if (empresa.includes(input) || nombre.includes(input) || cedula.includes(input)) {
        rows[i].style.display = '';
    } else {
        rows[i].style.display = 'none';
    }
}
}); 
*/




document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("App_Tipo_pract");
    const institucionInput = document.getElementById("App_Empresa_Institucion");

    function actualizarCampos(areaSeleccionada) {
        const proyecto = docentesPorArea.find(p => p.area === areaSeleccionada);
        if (proyecto) {
            institucionInput.value = proyecto.nombre_institucion || "";
        
        } else {
            institucionInput.value = "";
        }
    }

    areaSelect.addEventListener("change", function () {
        actualizarCampos(this.value);
    });

    if (areaSelect.value) {
        actualizarCampos(areaSelect.value);
    }
});



document.addEventListener("DOMContentLoaded", function () {
    const docenteSelect = document.getElementById("App_Nombre_doc");
    const cedulaInput = document.getElementById("App_Cedula_doc");
    const emailInput = document.getElementById("App_Email_doc");


    function actualizarCamposDocente() {
        const selectedOption = docenteSelect.options[docenteSelect.selectedIndex];
        cedulaInput.value = selectedOption.getAttribute("data-cedula") || "";
        emailInput.value = selectedOption.getAttribute("data-email") || "";
    }

    docenteSelect.addEventListener("change", actualizarCamposDocente);

    if (docenteSelect.value) {
        actualizarCamposDocente();
    }


    docenteSelect.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];

        const cedula = selectedOption.getAttribute("data-cedula");
        const email = selectedOption.getAttribute("data-email");

        cedulaInput.value = cedula || "";
        emailInput.value = email || "";
    });

    // Si ya hay algo seleccionado al cargar
    if (docenteSelect.value) {
        const selectedOption = docenteSelect.options[docenteSelect.selectedIndex];
        cedulaInput.value = selectedOption.getAttribute("data-cedula") || "";
        emailInput.value = selectedOption.getAttribute("data-email") || "";
    }
});












