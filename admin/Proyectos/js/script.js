document.addEventListener('DOMContentLoaded', function () {
    const areaSelect = document.getElementById('area');
    const docenteTutorGroup = document.getElementById('docente_tutor_group');
    const docenteSelect = document.getElementById('nombre_docente');

    areaSelect.addEventListener('change', function () {
        const area = this.value;
        let docenteNombre = null;

        if (area === 'Practicas Pre-Profesionales') {
            docenteNombre = 'Diana Ximena  Poma Japón ';
            docenteTutorGroup.style.display = 'none'; 
            document.getElementById('docente_tutor').value = 'No Aplica';
        } else if (area === 'Practicas Internas' || area === 'Practicas Vinculacion con la sociedad') {
            docenteNombre = 'Juan Pablo  Cuenca Tapia';
            docenteTutorGroup.style.display = 'block';
        } else {
            docenteTutorGroup.style.display = 'block';
        }

        if (docenteNombre) {
            docenteSelect.value = docenteNombre;
            if ($(docenteSelect).hasClass('select2')) {
                $(docenteSelect).trigger('change');
            }
        }

        // Buscar el docente en el select y seleccionarlo
        for (let option of docenteSelect.options) {
            if (option.dataset.fullname === docenteNombre) {
                option.selected = true;
                break;
            }
        }

        //actualiza visualmente
        if ($(docenteSelect).hasClass('select2')) {
            $(docenteSelect).trigger('change');
        }
    });
});
