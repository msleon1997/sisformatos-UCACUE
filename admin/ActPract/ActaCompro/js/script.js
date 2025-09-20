

function filterTable() {
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase().trim();
    const table = document.querySelector('.table');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) { 
        const cells = rows[i].getElementsByTagName('td');
        const name = cells[1].textContent.toLowerCase();

        // Muestra la fila solo si el nombre contiene el texto ingresado
        if (name.includes(filter)) {
            rows[i].style.display = ''; 
        } else {
            rows[i].style.display = 'none';
        }
    }
}



let fieldsetCounter = 0;

function addFieldset() {
    fieldsetCounter++;

    const container = document.getElementById('fieldsets-container');
    const newFieldset = document.createElement('div');
    newFieldset.classList.add('fieldset-container');

    newFieldset.innerHTML = `
        <div class="form-group">
                <p>
                    Yo, 
                    <input type="text" class="form-control form-control-sm rounded-0" required id="Acta_NombresEstudiante_${fieldsetCounter}" name="Acta_NombresEstudiante[]" placeholder="Nombres y apellidos completos del estudiante">, estudiante de la carrera de 
                    <input type="text" class="form-control form-control-sm rounded-0" required id="Acta_Carrera_${fieldsetCounter}" name="Acta_Carrera[]" placeholder="Carrera"> de la Unidad Académica de 
                    <input type="text" class="form-control form-control-sm rounded-0" required id="Acta_UnidadAcademica_${fieldsetCounter}" name="Acta_UnidadAcademica[]" placeholder="Unidad Académica" value="Desarrollo de Software de la Universidad Católica de Cuenca" readonly>, por medio de la presente me comprometo con 
                    <input type="text" class="form-control form-control-sm rounded-0" required id="Acta_NombreEmpresa_${fieldsetCounter}" name="Acta_NombreEmpresa[]" placeholder="nombre completo de la empresa, organización o institución y/o proyecto de servicio comunitario">. A fin de llevar a cabo la 
                    <select name="Acta_TipoPractica[]" id="Acta_TipoPractica_${fieldsetCounter}" class="form-control form-control-sm rounded-0 select2" required>
                    ${selectOptionsHTML}
                           
                    </select>
                    , con responsabilidad y total acatamiento a las disposiciones y normas internas de la entidad auspiciadora y/o Proyecto, del Reglamento e Instructivo de prácticas pre profesionales de la Universidad Católica de Cuenca y dando cumplimiento a la presente planificación.
                </p>
            </div>
            
            <button class="remove-btn" onclick="removeFieldset(this)">Quitar</button>
            <div class="form-group signature-container">
            </div> 
    `;
    container.appendChild(newFieldset);
}



function removeFieldset(button) {
    button.parentElement.remove();
}



document.addEventListener("DOMContentLoaded", function () {

        document.querySelectorAll("select[name='Acta_TipoPractica[]']").forEach((areaSelect, index) => {
            const estudianteNombre = document.getElementsByName("Acta_NombresEstudiante[]")[index];
            const estudianteCarrera = document.getElementsByName("Acta_Carrera[]")[index];
            const estudianteEmpresaInstitucion = document.getElementsByName("Acta_NombreEmpresa[]")[index];

            function actualizarCampos(areaSeleccionada) {
                if (areaSeleccionada !== "") {
                    const datosEst = datosPorArea.find(p => p.area === areaSeleccionada);
                    if (datosEst) {
                        estudianteNombre.value = `${datosEst.firstname_est} ${datosEst.lastname_est}` || "";
                        estudianteCarrera.value = datosEst.carrera || "";
                        estudianteEmpresaInstitucion.value = datosEst.nombre_institucion || "";
                    } else {
                        estudianteNombre.value = "";
                        estudianteCarrera.value = "";
                        estudianteEmpresaInstitucion.value = "";
                    }
                } else {
                    estudianteNombre.value = "";
                    estudianteCarrera.value = "";
                    estudianteEmpresaInstitucion.value = "";
                }
            }

            areaSelect.addEventListener("change", function () {
                actualizarCampos(this.value);
            });

            if (areaSelect.value) {
                actualizarCampos(areaSelect.value);
            }
        });
    });



