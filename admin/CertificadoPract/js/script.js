/* $(document).ready(function() {
    $('#tipo_practica').select2();
    $('#cantidad_horas_pract').select2();

    $('#tipo_practica').on('change', function() {
        const horas = $(this).find(':selected').data('horas');
        console.log('Horas detectadas:', horas); // Para debug

        if (horas) {
            $('#cantidad_horas_pract').val(horas).trigger('change');
        } else {
            $('#cantidad_horas_pract').val('').trigger('change');
        }
    });
});

$(document).ready(function() {
    $('#tipo_practica').select2();
    $('#cantidad_horas_pract').select2();

    function actualizarHoras() {
        const horas = $('#tipo_practica').find(':selected').data('horas');
        if (horas) {
            $('#cantidad_horas_pract').val(horas).trigger('change');
        } else {
            $('#cantidad_horas_pract').val('').trigger('change');
        }
    }

    $('#tipo_practica').on('change', actualizarHoras);
    actualizarHoras();
}); */



document.addEventListener("DOMContentLoaded", function () {
    const areaSelect = document.getElementById("tipo_practica");
    const estudianteInput = document.getElementById("estudiante_nombre");
    const cedulaEstInput = document.getElementById("numero_cedula");
    const cicloInput = document.getElementById("ciclo_est");
    const empresaInput = document.getElementById("proyecto_empresa_entidad");
    const fechaInicioInput = document.getElementById("periodo_fecha_ini");
    const fechaFinInput = document.getElementById("periodo_fecha_fin");
    const horasInput = document.getElementById("cantidad_horas_pract");
    function actualizarCampos(areaSeleccionada) {
        const matriculacion = datosPorArea.matriculaciones.find(p => p.area === areaSeleccionada);

        const actividad = datosPorArea.actividadesPracticas.find(a => a.app_Tipo_pract === areaSeleccionada);

        if (matriculacion) {
            estudianteInput.value = `${matriculacion.firstname_est || ""} ${matriculacion.lastname_est || ""}`;
            cedulaEstInput.value = matriculacion.cedula_est || "";
            cicloInput.value = matriculacion.ciclo || "";
            empresaInput.value = matriculacion.nombre_institucion || "";
            horasInput.value = matriculacion.cantidad_horas_pract || "";
        } else {
            estudianteInput.value = "";
            cedulaEstInput.value = "";
            cicloInput.value = "";
            empresaInput.value = "";
            horasInput.value = "";
        }
        if (areaSeleccionada === "Practicas Pre-Profesionales") {
            horasInput.value = "240";
        } else if (
            areaSeleccionada === "Practicas Internas" ||
            areaSeleccionada === "Practicas Vinculacion con la sociedad"
        ) {
            horasInput.value = "120";
        } else {
            horasInput.value = "";
        }

       if (actividad && actividad.app_Fecha_ini && actividad.app_Fecha_fin) {
            const fechaIni = actividad.app_Fecha_ini.split('T')[0];
            const fechaFin = actividad.app_Fecha_fin.split('T')[0];
            fechaInicioInput.value = fechaIni;
            fechaFinInput.value = fechaFin;
        } else {
            fechaInicioInput.value = "";
            fechaFinInput.value = "";
        }

    }

    areaSelect.addEventListener("change", function () {
        actualizarCampos(this.value);
    });

    if (areaSelect.value) {
        actualizarCampos(areaSelect.value);
    }
});