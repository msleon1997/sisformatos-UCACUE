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








/*editor enriquecido*/ 

CKEDITOR.replace('Introduccion'); 
CKEDITOR.replace('Obj_general');
CKEDITOR.replace('Obj_especifico');
CKEDITOR.replace('Justificacion');
CKEDITOR.replace('Antecedentes');
CKEDITOR.replace('Mision_inst');
CKEDITOR.replace('Vision_inst');
CKEDITOR.replace('Obj_inst');
CKEDITOR.replace('Valores_inst');
CKEDITOR.replace('Bene_directos');
CKEDITOR.replace('Bene_indirectos');
CKEDITOR.replace('Evaluacion_impacto');
CKEDITOR.replace('Detalle_actividades');
CKEDITOR.replace('Conclusiones');
CKEDITOR.replace('Recomendaciones');
CKEDITOR.replace('Recomendaciones-1');
CKEDITOR.replace('Biografia');

for (var instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
}


//agregar mas resultados de aprendizaje
function addFieldset() {
    // Contenedor principal
    const container = document.getElementById('fieldsets-container');
    // Crear un nuevo elemento div
    const newFieldset = document.createElement('div');
    newFieldset.classList.add('fieldset-container');
    
    // Contenido HTML para los campos (similar al original)
    newFieldset.innerHTML = `
        <table>
            <tr><th>Asignatura:</th></tr>
            <tr>
                <td><input type="text" name="RA_asignatura[]" class="form-control" required></td>
            </tr>
            <tr><th>Resultado de aprendizaje:</th></tr>
            <tr>
                <td><input type="text" name="RA_resultado_aprendizaje[]" class="form-control" required></td>
            </tr>
            <tr><th>Perfil de egreso:</th></tr>
            <tr>
                <td><input type="text" name="RA_perfil_egreso[]" class="form-control" required></td>
            </tr>
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


function previsualizarAprobacionesImagenes() {
    var input = document.getElementById('Aprobaciones');
    var previsualizacionAprobaciones = document.getElementById('previsualizacionAprobaciones');
    var rutasImagenes = [];
    //var imagenesGuardadas = document.getElementById('imagenesAprobacionesGuardadas');
    
   // imagenesGuardadas.style.display = 'none';

    previsualizacionAprobaciones.innerHTML = '';

    // Recorrer todos los archivos seleccionados
    for (var i = 0; i < input.files.length; i++) {
        var archivo = input.files[i];
        var reader = new FileReader();

        // Función que se ejecuta cuando la imagen se carga
        reader.onload = function(e) {
            var img = document.createElement('img');
            img.src = e.target.result; 
            img.style.maxWidth = '790px';
            img.style.maxHeight = '790px';
            img.style.margin = '10px auto';
            img.style.display = 'block';
            
            previsualizacionAprobaciones.appendChild(img);
            
            rutasImagenes.push(e.target.result);
        };

        reader.readAsDataURL(archivo);
    }

    // Actualizar el campo hidden con las rutas de las nuevas imágenes
    document.getElementById('rutasImagenes').value = rutasImagenes.join(',');
}




function previsualizarAnexosImagenes() {
    var input = document.getElementById('Anexos');
    var previsualizacion = document.getElementById('previsualizacion');
    var rutasImagenes = [];

    previsualizacion.innerHTML = '';

    for (var i = 0; i < input.files.length; i++) {
        var archivo = input.files[i];
        var reader = new FileReader();

        reader.onload = function(e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '790px';
            img.style.maxHeight = '790px';
            img.style.margin = '10px';
            img.style.objectFit = 'cover';

            previsualizacion.appendChild(img);
            rutasImagenes.push(e.target.result);
        };

        reader.readAsDataURL(archivo);
    }

    document.getElementById('rutasImagenes').value = rutasImagenes.join(',');
}


//funcion para crear el periodo de practicas
    const mesNombre = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    function actualizarPeriodoPracticas() {
        const inicio = document.getElementById("fecha_inicio").value;
        const fin = document.getElementById("fecha_fin").value;
        const campoPeriodo = document.getElementById("Periodo_practicas");

        if (inicio && fin) {
            const [anioInicio, mesInicio] = inicio.split("-");
            const [anioFin, mesFin] = fin.split("-");
            const texto = `${mesNombre[parseInt(mesInicio) - 1]} ${anioInicio} – ${mesNombre[parseInt(mesFin) - 1]} ${anioFin}`;
            campoPeriodo.value = texto;
        } else {
            campoPeriodo.value = "";
        }
    }

    document.getElementById("fecha_inicio").addEventListener("change", actualizarPeriodoPracticas);
    document.getElementById("fecha_fin").addEventListener("change", actualizarPeriodoPracticas);





document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("Tipo_pract");
    const institucionInput = document.getElementById("Empresa_Institucion_Proyecto");
    const tutorExternoInput = document.getElementById("Tutor_externo");
    const docenteTutorInput = document.getElementById("Docente_tutor");

    function actualizarCampos(areaSeleccionada) {
        const plan = planificacionPorArea.find(p => p.tP_Area === areaSeleccionada);


        if (plan) {
            institucionInput.value = plan.tP_Inst_Emp || "";
            docenteTutorInput.value = plan.tP_Docente || "";
            tutorExternoInput.value = plan.tP_Docente_tutor || "";
        } else {
            institucionInput.value = "";
            docenteTutorInput.value = "";
            tutorExternoInput.value = "";
        }

       

    }

    areaSelect.addEventListener("change", function () {
        actualizarCampos(this.value);
    });

    if (areaSelect.value) {
        actualizarCampos(areaSelect.value);
    }
});