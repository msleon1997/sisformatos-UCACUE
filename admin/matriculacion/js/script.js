
// document.addEventListener('DOMContentLoaded', function() {
//     var selectArea = document.getElementById('area');
//     var docenteTutorSelect = document.getElementById('docente_tutor');
//     var nombreProyectoDiv = document.getElementById('nombre_proyecto_div');
//     var nombreProyectoInput = document.getElementById('nombre_proyecto_text');
//     var nombreProyectoSelectDiv = document.getElementById('nombre_proyecto_select_div');
//     var nombreProyectoSelect = document.getElementById('nombre_proyecto_select');

//     // Campo oculto para enviar el valor final
//     var hiddenInput = document.createElement('input');
//     hiddenInput.type = 'hidden';
//     hiddenInput.name = 'nombre_proyecto';
//     document.getElementById('matriculacion_frm').appendChild(hiddenInput);

//     function updateFields() {
//         if (selectArea.value === 'Práctica Laboral') {
//             nombreProyectoDiv.style.display = 'block';
//             nombreProyectoSelectDiv.style.display = 'none';
//             hiddenInput.value = nombreProyectoInput.value; 
//             docenteTutorSelect.innerHTML = `<option value="Ing. Diana Poma">Ing. Diana Poma</option>`;
//         } else {
//             nombreProyectoDiv.style.display = 'none';
//             nombreProyectoSelectDiv.style.display = 'block';
//             hiddenInput.value = nombreProyectoSelect.value; 
//             docenteTutorSelect.innerHTML = `
//             <option value="Ing. Isael Sañay">Ing. Isael Sañay</option>
//             <option value="Ing. Antonio Cajamarca">Ing. Antonio Cajamarca</option>
//             <option value="Ing. Juan Pablo Cuenca">Ing. Juan Pablo Cuenca</option>
//             <option value="Ing. Blanca Ávila">Ing. Blanca Ávila</option>`;
//         }
//     }

//     // Actualiza el valor del campo oculto al cambiar el área
//     selectArea.addEventListener('change', updateFields);

//     // Actualiza el valor del campo oculto al cambiar los inputs de nombre_proyecto
//     nombreProyectoInput.addEventListener('input', function() {
//         if (selectArea.value === 'Práctica Laboral') {
//             hiddenInput.value = nombreProyectoInput.value;
//         }
//     });

//     nombreProyectoSelect.addEventListener('change', function() {
//         if (selectArea.value !== 'Práctica Laboral') {
//             hiddenInput.value = nombreProyectoSelect.value;
//         }
//     });

//     updateFields(); // Llama a la función al cargar la página
// });


// //JS para view_matriculacion
// $(function() {
//     $('#update_status').click(function() {
//         uni_modal("Actualizar estado de <b><?= isset($roll) ? $roll : '' ?></b>", "students/update_status.php?student_id=<?= isset($id) ? $id : '' ?>");
//     })
//     $('#add_academic').click(function() {
//         uni_modal("Agregar registro académico <b><?= isset($roll) ? $roll . ' - ' . $fullname : '' ?></b>", "students/manage_academic.php?student_id=<?= isset($id) ? $id : '' ?>", 'mid-large')
//     })
//     $('.edit_academic').click(function() {
//         uni_modal("Editar Registro Académico <b><?= isset($roll) ? $roll . ' - ' . $fullname : '' ?></b>", "students/manage_academic.php?student_id=<?= isset($id) ? $id : '' ?>&id=" + $(this).attr('data-id'), 'mid-large')
//     })
//     $('.delete_academic').click(function() {
//         _conf("¿Estás seguro de borrar el Expediente Académico de este Estudiante?", "delete_academic", [$(this).attr('data-id')])
//     })
//     $('#delete_student').click(function() {
//         _conf("¿Está seguro de eliminar esta información del estudiante?", "delete_student", ['<?= isset($id) ? $id : "" ?>'])
//     })
//     $('.view_data').click(function() {
//         uni_modal("Reporte", "students/view_report.php?id=" + $(this).attr('data-id'), "mid-large")
//     })
//     $('.table td, .table th').addClass('py-1 px-2 align-middle')
//     $('.table').dataTable({
//         columnDefs: [{
//             orderable: false,
//             targets: 5
//         }]
//     });
    
//     $('#print').click(function() {
//         start_loader()
//         $('#academic-history').dataTable().fnDestroy()
//         var _h = $('head').clone()
//         var _p = $('#outprint').clone()
//         var _ph = $($('noscript#print-header').html()).clone()
//         var _el = $('<div>')
//         _p.find('tr.bg-gradient-dark').removeClass('bg-gradient-dark')
//         _p.find('tr>td:last-child,tr>th:last-child,colgroup>col:last-child').remove()
//         _p.find('.badge').css({
//             'border': 'unset'
//         })
//         _el.append(_h)
//         _el.append(_ph)
//         _el.find('title').text('Registros Estudiante - Print View')
//         _el.append(_p)


//         var nw = window.open('', '_blank', 'width=1000,height=900,top=50,left=200')
//         nw.document.write(_el.html())
//         nw.document.close()
//         setTimeout(() => {
//             nw.print()
//             setTimeout(() => {
//                 nw.close()
//                 end_loader()
//                 $('.table').dataTable({
//                     columnDefs: [{
//                         orderable: false,
//                         targets: 5
//                     }],
//                 });
//             }, 300);
//         }, (750));


//     })
// })

// function delete_academic($id) {
//     start_loader();
//     $.ajax({
//         url: _base_url_ + "classes/Master.php?f=delete_academic",
//         method: "POST",
//         data: {
//             id: $id
//         },
//         dataType: "json",
//         error: err => {
//             console.log(err)
//             alert_toast("Ocurrió un error.", 'error');
//             end_loader();
//         },
//         success: function(resp) {
//             if (typeof resp == 'object' && resp.status == 'success') {
//                 location.reload();
//             } else {
//                 alert_toast("Ocurrió un error.", 'error');
//                 end_loader();
//             }
//         }
//     })
// }



// function delete_student($id) {
//     start_loader();
//     $.ajax({
//         url: _base_url_ + "classes/Master.php?f=delete_student",
//         method: "POST",
//         data: {
//             id: $id
//         },
//         dataType: "json",
//         error: err => {
//             console.log(err)
//             alert_toast("Ocurrió un error.", 'error');
//             end_loader();
//         },
//         success: function(resp) {
//             if (typeof resp == 'object' && resp.status == 'success') {
//                 location.href = "./?page=students";
//             } else {
//                 alert_toast("Ocurrió un error.", 'error');
//                 end_loader();
//             }
//         }
//     })
// }

function actualizarVisibilidadCampos() {
    const area = document.getElementById("area").value;
    const inputGroup = document.getElementById("proyecto_input_group");
    const selectGroup = document.getElementById("proyecto_select_group");
    const input = document.getElementById("nombre_proyecto_pract_pro");
    const select = document.getElementById("proyecto_select");

    if (area === "Practicas Internas" || area === "Practicas Vinculacion con la sociedad") {
        // Mostrar solo el SELECT
        selectGroup.style.display = "block";
        inputGroup.style.display = "none";
        select.required = true;
        input.required = false;
    } else if (area === "Practicas Pre-Profesionales") {
        // Mostrar solo el INPUT
        selectGroup.style.display = "none";
        inputGroup.style.display = "block";
        input.required = true;
        select.required = false;
    } else {
        // Ninguno
        selectGroup.style.display = "none";
        inputGroup.style.display = "none";
        input.required = false;
        select.required = false;
    }
}

