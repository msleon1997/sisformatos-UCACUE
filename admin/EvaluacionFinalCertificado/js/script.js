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
    
    // Itera sobre cada pregunta en la sección RCAPregunta y suma el valor del radio button seleccionado
    for (let i = 1; i <= 5; i++) {
        const radioSeleccionado = document.querySelector(`input[name="ACPregunta${i}"]:checked`);
        if (radioSeleccionado) {
            subtotal += parseInt(radioSeleccionado.value, 10);
        }
    }
    
    // Asigna el subtotal calculado al campo correspondiente
    document.getElementById('Subtotal2').value = subtotal;
}


function calcularSubtotal3() {
    let subtotal = 0;
    
    // Itera sobre cada pregunta en la sección RCAPregunta y suma el valor del radio button seleccionado
    for (let i = 1; i <= 5; i++) {
        const radioSeleccionado = document.querySelector(`input[name="HDPregunta${i}"]:checked`);
        if (radioSeleccionado) {
            subtotal += parseInt(radioSeleccionado.value, 10); 
        }
    }
    
    // Asigna el subtotal calculado al campo correspondiente
    document.getElementById('Subtotal3').value = subtotal;
}

function calcularSubtotal4() {
    let subtotal = 0;
    
    // Itera sobre cada pregunta en la sección RCAPregunta y suma el valor del radio button seleccionado
    for (let i = 1; i <= 5; i++) {
        const radioSeleccionado = document.querySelector(`input[name="AAPregunta${i}"]:checked`);
        if (radioSeleccionado) {
            subtotal += parseInt(radioSeleccionado.value, 10); 
        }
    }
    
    // Asigna el subtotal calculado al campo correspondiente
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
        const cedula = cells[4].textContent.toLowerCase();

        // Muestra la fila solo si el nombre contiene el texto ingresado
        if (name.includes(filter) || cedula.includes(filter)) {
            rows[i].style.display = ''; 
        } else {
            rows[i].style.display = 'none'; 
        }
    }
}

/*cargar el logo*/ 

function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();
    
    reader.onload = function(){
        var img = document.getElementById('logo_preview');
        img.src = reader.result;
        img.style.display = 'block';
    };
    
    reader.readAsDataURL(input.files[0]); 
}



document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("Tipo_pract");
    const areaDesarrolloInput = document.getElementById("Area_desarrollo");
    const cicloInput = document.getElementById("Duracion_horas");
    const fechaIniInput = document.getElementById("Fecha_inicio");
    const fechaFinInput = document.getElementById("Fecha_fin");
    const tutorEmpresaInput = document.getElementById("Nombre_Tutor_empresa");
    const empresaNombreInput = document.getElementById("Nombre_empresa");
    function actualizarCampos(areaSeleccionada) {
        const plan = actividadesPorArea.find(p => p.app_Tipo_pract === areaSeleccionada);

        if (plan) {
            areaDesarrolloInput.value = plan.app_Area_dep_proyect || "";

        if (areaSeleccionada === "Practicas Pre-Profesionales") {
            cicloInput.value = "240";
        } else if (
            areaSeleccionada === "Practicas Internas" ||
            areaSeleccionada === "Practicas Vinculacion con la sociedad"
        ) {
            cicloInput.value = "120";
        } else {
            cicloInput.value = "";
        }
            fechaIniInput.value = plan.app_Fecha_ini.split('T')[0];
            fechaFinInput.value = plan.app_Fecha_fin.split('T')[0];
            tutorEmpresaInput.value = plan.app_Nombre_doc || "";
            empresaNombreInput.value = plan.app_Empresa_Institucion || "";
        } else {
            areaDesarrolloInput.value = "";
            cicloInput.value = "";
            fechaIniInput.value = "";
            fechaFinInput.value = "";
            tutorEmpresaInput.value = "";
            empresaNombreInput.value = "";
        }

        
    }

    areaSelect.addEventListener("change", function () {
        actualizarCampos(this.value);
    });
    if (areaSelect.value) {
        actualizarCampos(areaSelect.value);
    }
});