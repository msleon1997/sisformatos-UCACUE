function filterTable() {
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase().trim();
    const table = document.querySelector('.table');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        const name = cells[2].textContent.toLowerCase();
        const cedula = cells[1].textContent.toLowerCase();

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
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('Firma1Preview');
        var output = document.getElementById('Firma2Preview');
        var output = document.getElementById('Firma3Preview');

        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}


/*editor enriquecido*/ 

CKEDITOR.replace('Introduccion-tutorias');
CKEDITOR.replace('Introduccion');
CKEDITOR.replace('Descripcion_actividades');
CKEDITOR.replace('Conclusion');
CKEDITOR.replace('Observaciones-tutorias');
CKEDITOR.replace('Observaciones');




for (var instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
}


//listar estudiantes
function agregarFila() {
    var table = document.querySelector('.table tbody');
    var newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="text" name="Est_cedula[]" class="form-control form-control-sm rounded-0" required></td>
        <td><input type="text" name="Est_apellidos[]" class="form-control form-control-sm rounded-0" required></td>
        <td><input type="text" name="Est_nombres[]" class="form-control form-control-sm rounded-0" required></td>
        <td><input type="text" name="Est_ciclo[]" class="form-control form-control-sm rounded-0" required></td>
    `;
    table.appendChild(newRow);
}

function eliminarFila() {
    var table = document.querySelector('.table tbody');
    if (table.rows.length > 1) { 
        table.deleteRow(-1);
    }
}


function agregarRegistro() {
    var table = document.querySelector('.registro-tutorias tbody');
    var rowCount = table.rows.length + 1; 

    var newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${rowCount}</td>
        <td>
            <input type="number" name="Dia[]" placeholder="Día" class="form-control form-control-sm rounded-0" style="width: 30%; display: inline;">
            <input type="number" name="Mes[]" placeholder="Mes" class="form-control form-control-sm rounded-0" style="width: 30%; display: inline;">
            <input type="number" name="Ano[]" placeholder="Año" class="form-control form-control-sm rounded-0" style="width: 30%; display: inline;">
        </td>
        <td><input type="text" name="Tema_consulta[]" class="form-control form-control-sm rounded-0"></td>
        <td>
            <select name="RT_Ciclo[]" class="form-control form-control-sm rounded-0">
                <option value="1er Ciclo">1er Ciclo</option>
                <option value="2do Ciclo">2do Ciclo</option>
                <option value="3er Ciclo">3er Ciclo</option>
                <option value="4to Ciclo">4to Ciclo</option>
                <option value="5to Ciclo">5to Ciclo</option>
                <option value="6to Ciclo">6to Ciclo</option>
                <option value="7mo Ciclo">7mo Ciclo</option>
                <option value="8vo Ciclo">8vo Ciclo</option>
            </select>
        </td>
        <td>
            <select name="Modalidad[]" class="form-control form-control-sm rounded-0" required>
                <option value="Individual">Individual</option>
                <option value="Grupal">Grupal</option>
                <option value="Externa">Externa</option>
            </select>
        </td>
        <td><input type="text" name="RT_Estudiante[]" class="form-control form-control-sm rounded-0"></td>
        <td><input type="text" name="RT_Cedula_est[]" class="form-control form-control-sm rounded-0"></td>
    `;
    table.appendChild(newRow);
    actualizarNumeracion(); 
}

function eliminarRegistro() {
    var table = document.querySelector('.registro-tutorias tbody');
    if (table.rows.length > 1) {
        table.deleteRow(-1);
        actualizarNumeracion(); 
    }
}

function actualizarNumeracion() {
    var rows = document.querySelectorAll('.registro-tutorias tbody tr');
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1; 
    });
}


function previsualizarAnexosImagenes() {
    var input = document.getElementById('Anexos');
    var previsualizacion = document.getElementById('previsualizacion');
    var rutasImagenes = [];
    var imagenesGuardadas = document.getElementById('imagenesGuardadas');
    
    imagenesGuardadas.style.display = 'none';

    previsualizacion.innerHTML = '';

    // Recorrer todos los archivos seleccionados
    for (var i = 0; i < input.files.length; i++) {
        var archivo = input.files[i];
        var reader = new FileReader();

        // Función que se ejecuta cuando la imagen se carga
        reader.onload = function(e) {
            var img = document.createElement('img');
            img.src = e.target.result; 
            img.style.maxWidth = '1125px';
            img.style.margin = '10px auto';
            img.style.display = 'block';
            
            previsualizacion.appendChild(img);
            
            rutasImagenes.push(e.target.result);
        };

        reader.readAsDataURL(archivo);
    }

    // Actualizar el campo hidden con las rutas de las nuevas imágenes
    document.getElementById('rutasImagenes').value = rutasImagenes.join(',');
}



//para cargar los datos automaticamente

document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("Area_desarrollo");
    const institucionInput = document.getElementById("Empresa_proyecto");
    const docenteTutorInput = document.getElementById("Docente_tutor");
    const tutorExternoInput = document.getElementById("Docente_tutor_est");
    const periodoPractInput = document.getElementById("Periodo_practicas");
    const carreraInput = document.getElementById("Carrera_est");
    const fechaIniInput = document.getElementById("Fecha_inicio");
    const fechaFinInput = document.getElementById("Fecha_fin");
    const docenteResponInput = document.getElementById("Responsable_docente_tutor");
    const responsablePttInput = document.getElementById("Responsable_ptt");
    const cedulaEstInput = document.getElementById("Est_cedula");
    const apellidosEstInput = document.getElementById("Est_apellidos");
    const nombresEstInput = document.getElementById("Est_nombres");
    const cicloEstInput = document.getElementById("Est_ciclo");


    function actualizarCampos(areaSeleccionada) {
        const plan = datosPorArea.planificaciones.find(p => p.tP_Area === areaSeleccionada);
        const actividad = datosPorArea.actividadesPracticas.find(a => a.app_Tipo_pract === areaSeleccionada);
        const informeFinal = datosPorArea.informeFinal.find(i => i.tipo_pract === areaSeleccionada);
        const matriculacion = datosPorArea.matriculacion.find(m => m.area === areaSeleccionada);

        if (plan) {
            carreraInput.value = plan.tP_Carrera || "";
            institucionInput.value = plan.tP_Inst_Emp || "";
        } else {
            carreraInput.value = "";
            institucionInput.value = "";
        }

       if (actividad && actividad.app_Fecha_ini && actividad.app_Fecha_fin) {
            const fechaStrIni = actividad.app_Fecha_ini.split('T')[0];
            const fechaStrFIn = actividad.app_Fecha_fin.split('T')[0];
            fechaIniInput.value = fechaStrIni;
            fechaFinInput.value = fechaStrFIn;
        } else {
            fechaIniInput.value = "";
            fechaFinInput.value = "";
        }


        if (informeFinal) {
            docenteTutorInput.value = informeFinal.docente_tutor || "";
            tutorExternoInput.value = informeFinal.tutor_externo || "";
            periodoPractInput.value = informeFinal.periodo_practicas || "";
            docenteResponInput.value = informeFinal.docente_tutor || "";
            responsablePttInput.value = informeFinal.docente_tutor || "";
            
        } else {
            docenteTutorInput.value = "";
            tutorExternoInput.value = "";
            periodoPractInput.value = "";
            docenteResponInput.value = "";
            responsablePttInput.value = "";
        }

        if (matriculacion) {
            cedulaEstInput.value = matriculacion.cedula_est || "";
            apellidosEstInput.value = matriculacion.lastname_est || "";
            nombresEstInput.value = matriculacion.firstname_est || "";
            cicloEstInput.value = matriculacion.ciclo || "";
        } else {
            cedulaEstInput.value = "";
            apellidosEstInput.value = "";
            nombresEstInput.value = "";
            cicloEstInput.value = "";
        }

    }

    areaSelect.addEventListener("change", function () {
        actualizarCampos(this.value);
    });

    if (areaSelect.value) {
        actualizarCampos(areaSelect.value);
    }
});