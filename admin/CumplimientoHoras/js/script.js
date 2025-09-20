// Verifica si el evento ya está asignado
if (!document.getElementById('add-row-btn').dataset.eventAdded) {
    document.getElementById('add-row-btn').addEventListener('click', function () {
        var table = document.getElementById('activity-table').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);

        cell1.innerHTML = '<input type="date" name="Fecha[]" class="form-control form-control-sm rounded-0" required>';
        cell2.innerHTML = '<input type="time" name="Hora_Entrada[]" class="form-control form-control-sm rounded-0" required>';
        cell3.innerHTML = '<input type="time" name="Hora_Salida[]" class="form-control form-control-sm rounded-0" required>';
        cell4.innerHTML = '<input type="text" name="Actividades_Realizadas[]" class="form-control form-control-sm rounded-0" required>';
    });

    // Marca que el evento fue añadido
    document.getElementById('add-row-btn').dataset.eventAdded = 'true';
}

// Remove row logic remains the same
document.getElementById('remove-row-btn').addEventListener('click', function () {
    var table = document.getElementById('activity-table').getElementsByTagName('tbody')[0];
    if (table.rows.length > 1) {
        table.deleteRow(table.rows.length - 1);
    }
});



document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("Tipo_area");
    const institucionInput = document.getElementById("Empresa_institucion_proyecto");
    const docenteTutorInput = document.getElementById("Docente_tutor");
    const tutorExternoInput = document.getElementById("Tutor_Externo");
    const grupoDocenteTutor = document.getElementById("grupoDocenteTutor");

    function actualizarCampos(areaSeleccionada) {
        const plan = planificacionPorArea.find(p => p.tP_Area === areaSeleccionada);

        if (plan) {
            institucionInput.value = plan.tP_Inst_Emp || "";
        } else {
            institucionInput.value = "";
        }

        if (areaSeleccionada === "Practicas Pre-Profesionales") {
            grupoDocenteTutor.style.display = "block";
            tutorExternoInput.value = plan.tP_Docente_tutor || "";
            docenteTutorInput.value = "No aplica"; 
        } else {
            grupoDocenteTutor.style.display = "block";
            docenteTutorInput.value = plan.tP_Docente_tutor || "";
            tutorExternoInput.value = "No aplica";
        }
    }

    areaSelect.addEventListener("change", function () {
        actualizarCampos(this.value);
    });
    if (areaSelect.value) {
        actualizarCampos(areaSelect.value);
    }
});
