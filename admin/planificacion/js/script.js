


document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("TP_Area");
    const cicloInput = document.getElementById("TP_Ciclo");
    const docenteInput = document.getElementById("TP_Docente");
    const carreraInput = document.getElementById("TP_Carrera");
    const proyectoIntegradorInput = document.getElementById("TP_Proyecto_Serv_Com_text");
    const proyectoSelect = document.getElementById("TP_Proyecto_Serv_Com");
    const horaInput = document.getElementById("TP_Horas_Pract");
    const inputGroup = document.getElementById("proyecto_input_group");
    const selectGroup = document.getElementById("proyecto_select_group");
    const propuestaTextArea = document.getElementById("TP_Propuesta");
    const institucionInput = document.getElementById("TP_Inst_Emp");

    function actualizarCampos(areaSeleccionada) {
    const proyecto = proyectosPorArea.find(p => p.area === areaSeleccionada);
        
    if (proyecto) {
        cicloInput.value = proyecto.ciclo || "";
        carreraInput.value = proyecto.carrera || "";
        propuestaTextArea.value = proyecto.propuesta || "";
        institucionInput.value = proyecto.nombre_institucion || "";

        if (proyecto.docente) {
            docenteInput.value = proyecto.nombre_docente;
            $(docenteInput).trigger('change');
        }

        if (areaSeleccionada === "Practicas Internas") {
            horaInput.value = "120";
        } else if (
            areaSeleccionada === "Practicas Pre-Profesionales" ||
            areaSeleccionada === "Practicas Vinculacion con la sociedad"
        ) {
            horaInput.value = "240";
        } else {
            horaInput.value = "";
        }

        if (areaSeleccionada === "Practicas Internas") {
            inputGroup.style.display = "none";
            selectGroup.style.display = "block";
            proyectoSelect.value = proyecto.nombre_proyecto || "";
            proyectoIntegradorInput.value = "";
           // docenteInput.value = proyecto.nombre_docente;

        } else if (areaSeleccionada === "Practicas Pre-Profesionales") {
            inputGroup.style.display = "block";
            selectGroup.style.display = "none";
            proyectoIntegradorInput.value = proyecto.nombre_proyecto_pract_pro || "";
            proyectoSelect.value = "";
          //  docenteInput.value = proyecto.nombre_docente;

        } else if (areaSeleccionada === "Practicas Vinculacion con la sociedad") {
            inputGroup.style.display = "none";
            selectGroup.style.display = "block";
            proyectoSelect.value = proyecto.nombre_proyecto || "";
            proyectoIntegradorInput.value = "";
            //docenteInput.value = proyecto.docente;

        } else {
            inputGroup.style.display = "none";
            selectGroup.style.display = "none";
            proyectoSelect.value = "";
            proyectoIntegradorInput.value = "";
        }
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
    const selectDocente = document.getElementById("TP_Docente_tutor");
    const otroInputGroup = document.getElementById("otro_docente_input_group");
    const otroInput = document.getElementById("otro_docente_input");

    selectDocente.addEventListener("change", function () {
        if (this.value === "otro") {
            otroInputGroup.style.display = "block";
        } else {
            otroInputGroup.style.display = "none";
            otroInput.value = "";
        }
    });

    const formulario = document.querySelector("form");
    formulario.addEventListener("submit", function () {
        if (selectDocente.value === "otro" && otroInput.value.trim() !== "") {
            const inputNombre = otroInput.value.trim();
            const nuevaOpcion = new Option(inputNombre, inputNombre, true, true);
            selectDocente.appendChild(nuevaOpcion);
            selectDocente.value = inputNombre;
        }
    });
});












