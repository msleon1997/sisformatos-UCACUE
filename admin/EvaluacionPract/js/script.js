/* Función para calcular subtotales */
function calcularSubtotal1() {
    let subtotal = 0;
    
    // Itera sobre cada pregunta en la sección RCAPregunta y suma el valor del radio button seleccionado
    for (let i = 1; i <= 5; i++) {
        const radioSeleccionado = document.querySelector(`input[name="RCAPregunta${i}"]:checked`);
        if (radioSeleccionado) {
            subtotal += parseInt(radioSeleccionado.value, 10); 
        }
    }
    
    // Asigna el subtotal calculado al campo correspondiente
    document.getElementById('Subtotal1').value = subtotal;
}



function calcularSubtotal2() {
    let subtotal = 0;
    
    for (let i = 1; i <= 5; i++) {
        const radioSeleccionado = document.querySelector(`input[name="ACPregunta${i}"]:checked`);
        if (radioSeleccionado) {
            subtotal += parseInt(radioSeleccionado.value, 10); 
        }
    }
    
    document.getElementById('Subtotal2').value = subtotal;
}


function calcularSubtotal3() {
    let subtotal = 0;
    
    for (let i = 1; i <= 5; i++) {
        const radioSeleccionado = document.querySelector(`input[name="HDPregunta${i}"]:checked`);
        if (radioSeleccionado) {
            subtotal += parseInt(radioSeleccionado.value, 10);
        }
    }
    
    document.getElementById('Subtotal3').value = subtotal;
}

function calcularSubtotal4() {
    let subtotal = 0;
    
    for (let i = 1; i <= 5; i++) {
        const radioSeleccionado = document.querySelector(`input[name="AAPregunta${i}"]:checked`);
        if (radioSeleccionado) {
            subtotal += parseInt(radioSeleccionado.value, 10); 
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


function filterTable() {
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase().trim();
    const table = document.querySelector('.table');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        const name = cells[3].textContent.toLowerCase();

        if (name.includes(filter)) {
            rows[i].style.display = ''; 
        } else {
            rows[i].style.display = 'none'; 
        }
    }
}



document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("Tipo_Practica");
    const institucionInput = document.getElementById("Empresa_institucion_proyecto");
    const docenteTutorInput = document.getElementById("Docente");
    const tutorExternoInput = document.getElementById("Tutor_Empresarial");
    const fechaInicioInput = document.getElementById("Fecha_Inicio");

    function actualizarCampos(areaSeleccionada) {
        const plan = planificacionPorArea.planificaciones.find(p => p.tP_Area === areaSeleccionada);
        const actividad = planificacionPorArea.actividadesPracticas.find(a => a.app_Tipo_pract === areaSeleccionada);

        if (plan) {
            institucionInput.value = plan.tP_Inst_Emp || "";
            docenteTutorInput.value = plan.tP_Docente_tutor || "";

           
            if (areaSeleccionada === "Practicas Pre-Profesionales") {
                tutorExternoInput.value = plan.tP_Docente_tutor || "";
            } else {
                tutorExternoInput.value = "No aplica";
            }

            if (areaSeleccionada === "Practicas Pre-Profesionales") {
                docenteTutorInput.value = "No aplica";
                
            } else {
                docenteTutorInput.value = plan.tP_Docente_tutor || "";
            }

        } else {
            institucionInput.value = "";
            docenteTutorInput.value = "";
            tutorExternoInput.value = "";
        }

        if (actividad && actividad.app_Fecha_ini) {
            const fechaStr = actividad.app_Fecha_ini.split('T')[0]; 
            fechaInicioInput.value = fechaStr;
        } else {
            fechaInicioInput.value = "";
        }
    }

    areaSelect.addEventListener("change", function () {
        actualizarCampos(this.value);
    });

    if (areaSelect.value) {
        actualizarCampos(areaSelect.value);
    }
});

