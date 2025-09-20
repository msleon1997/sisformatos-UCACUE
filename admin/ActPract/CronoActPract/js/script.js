//js de index.php

function filterTable() {
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase().trim().split(' ');
    const table = document.getElementById('cronogramaTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        const name = cells[1].textContent.toLowerCase(); 
        const lastname = cells[2].textContent.toLowerCase();
      
        // Verifica si ambos términos están presentes en el nombre o apellido
        const nameMatch = filter.length > 0 ? name.includes(filter[0]) : true;
        const lastnameMatch = filter.length > 1 ? lastname.includes(filter[1]) : true;

        // Muestra la fila solo si ambos términos coinciden
        if (nameMatch && lastnameMatch || name.includes(filter) || lastname.includes(filter)) {
            rows[i].style.display = ''; 
        } else {
            rows[i].style.display = 'none'; 
        }
    }
} 



if (!document.getElementById('add-row-btn').dataset.eventAdded) {
    document.getElementById('add-row-btn').addEventListener('click', function () {
        var table = document.getElementById('Crono_acti_frm').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();

        // Celda 1: Actividad
        var cellActividad = newRow.insertCell(0);
        cellActividad.innerHTML = '<input type="text" name="CA_Actividad[]" id="CA_Actividad" required>';

        // Celda 2: Tarea
        var cellTarea = newRow.insertCell(1);
        cellTarea.innerHTML = '<input type="text" name="CA_Tarea[]" id="CA_Tarea" required>';

        // Celda 3: 1ra Semana
        var cell1raSemana = newRow.insertCell(2);
        cell1raSemana.innerHTML = `
            <input type="text" name="CA1raSem_Lunes[]" id="CA1raSem_Lunes"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
            <input type="text" name="CA1raSem_Martes[]" id="CA1raSem_Martes"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
            <input type="text" name="CA1raSem_Miercoles[]" id="CA1raSem_Miercoles" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
            <input type="text" name="CA1raSem_Jueves[]" id="CA1raSem_Jueves"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
        `;

        // Celda 4: 2da Semana
        var cell2daSemana = newRow.insertCell(3);
        cell2daSemana.innerHTML = `
            <input type="text" name="CA2raSem_Lunes[]" id="CA2raSem_Lunes"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
            <input type="text" name="CA2raSem_Martes[]" id="CA2raSem_Martes"  class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
            <input type="text" name="CA2raSem_Miercoles[]" id="CA2raSem_Miercoles" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
            <input type="text" name="CA2raSem_Jueves[]" id="CA2raSem_Jueves" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;
        `;

        // Celda 5: 3ra Semana
        var cell3raSemana = newRow.insertCell(4);
        cell3raSemana.innerHTML = `
            <input type="text" name="CA3raSem_Lunes[]" id="CA3raSem_Lunes" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;
            <input type="text" name="CA3raSem_Martes[]" id="CA3raSem_Martes" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;
            <input type="text" name="CA3raSem_Miercoles[]" id="CA3raSem_Miercoles" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;
            <input type="text" name="CA3raSem_Jueves[]" id="CA3raSem_Jueves" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;
        `;

        // Celda 6: 4ta Semana
        var cell4taSemana = newRow.insertCell(5);
        cell4taSemana.innerHTML = `
            <input type="text" name="CA4taSem_Lunes[]" id="CA4taSem_Lunes" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="CA4taSem_Martes[]" id="CA4taSem_Martes" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="CA4taSem_Miercoles[]" id="CA4taSem_Miercoles" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="CA4taSem_Jueves[]" id="CA4taSem_Jueves" class="dias-adaptable" onclick="this.value = 'X';">&nbsp;&nbsp;&nbsp;&nbsp;
        `;
    });

    // Marca que el evento fue añadido
    document.getElementById('add-row-btn').dataset.eventAdded = 'true';
}


    document.getElementById('removeRowBtn').addEventListener('click', function() {
        var table = document.getElementById('cronogramaTable').getElementsByTagName('tbody')[0];
        var rowCount = table.rows.length;

        if (rowCount > 1) {
            table.deleteRow(rowCount - 1);
        }
    });




    
    document.getElementById('removeRowBtn').addEventListener('click', function () {
        const table = document.getElementById('cronogramaTable').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
    
        if (rowCount > 1) {
            table.deleteRow(rowCount - 1);
        }
    });




document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("CA_Tipo_Practica");
    const estudianteNombre = document.getElementById("CA_Estudiante");
    const estudianteCedula = document.getElementById("CA_Cedula");
    const datosEstudianteDiv = document.getElementById("datosEstudiante");

    function actualizarCampos(areaSeleccionada) {
        if (areaSeleccionada !== "") {
            datosEstudianteDiv.style.display = "block"; 
            const datosEst = datosPorArea.find(p => p.area === areaSeleccionada);
            if (datosEst) {
                estudianteNombre.value = datosEst.firstname_est + " " + datosEst.lastname_est || "";
                estudianteCedula.value = datosEst.cedula_est || "";
            } else {
                estudianteNombre.value = "";
                estudianteCedula.value = "";
            }
        } else {
            datosEstudianteDiv.style.display = "none"; 
            estudianteNombre.value = "";
            estudianteCedula.value = "";
        }
    }

    areaSelect.addEventListener("change", function () {
        actualizarCampos(this.value);
    });

    if (areaSelect.value) {
        actualizarCampos(areaSelect.value);
    } else {
        datosEstudianteDiv.style.display = "none"; 
    }
});

    

