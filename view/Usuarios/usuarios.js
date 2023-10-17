var tabla;

function init(){
    $('#usuario_form').on("submit", function(e){
        guardaryEditar(e);
    });
}

function guardaryEditar(e){
    e.preventDefault();
	var formData = new FormData($("#usuario_form")[0]);
    $.ajax({
        url: "../../controller/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){    
            console.log(datos);
            $('#usuario_form')[0].reset();

            $("#modalmantenimiento").modal('hide');
            $('#usuario_data').DataTable().ajax.reload();

            swal({
                title: "Usuario Actualizado!",
                text: "Completado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    }); 
}

$(document).ready(function(){
    tabla = $('#usuario_data').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [                
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                    ],
            "ajax":{
                url: '../../controller/usuario.php?op=listar',
                type : "post",
                dataType : "json",                     
                error: function(e){
                    console.log(e.responseText);    
                }
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo":true,
            "iDisplayLength": 10,
            "autoWidth": false,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
    }).DataTable();  
    
});

function editar(user_id){
    $('#mdltitulo').html('Editar Usuario');

    $.post("../../controller/usuario.php?op=mostrar",{user_id : user_id}, function(data){ 
        data = JSON.parse(data);
        $('#user_id').val(data.user_id);
        $('#user_nom').val(data.user_nom);
        $('#user_ap').val(data.user_ap);
        $('#user_correo').val(data.user_correo);
        $('#user_password').val(data.user_password);
        $('#id_rol').val(data.id_rol).trigger('change');
    });

    $('#modalmantenimiento').modal('show');
}

function eliminar(user_id){
    swal({
        title: "¿Estás seguro de eliminar el Usuario?",
        text: "No podra acceder de nuevo al sistema",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false,
    }, 
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/usuario.php?op=eliminar",{user_id : user_id}, function(data){ 

            });

            $('#usuario_data').DataTable().ajax.reload();

            swal({
                title: "¡Usuario Eliminado!",
                text: "El Usuario ha sido eliminado exitosamente",
                type: "success",
                confirmButtonClass: "btn-success"  
            });
        }
    });
}
 
$(document).on("click", "#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Usuario');
    $('#usuario_form')[0].reset();
    $('#modalmantenimiento').modal('show');
});

init();