var tabla;

function init(){
    $("#usuario_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#usuario_form")[0]);
    $.ajax({
        url: "../../controller/unidadAdmin.php?op=guardaryeditar",
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
                title: "Registro Completado!",
                text: "Unidad Administrativa agregada.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    }); 
}

$(document).ready(function(){
    tabla=$('#usuario_data').dataTable({
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
            url: '../../controller/unidadAdmin.php?op=listar',
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

function editar(id_uniadmin){
    $('#mdltitulo').html('Editar Unidad Administrativa');

    $.post("../../controller/unidadAdmin.php?op=mostrar", {id_uniadmin : id_uniadmin}, function (data) {
        data = JSON.parse(data);
        $('#id_uniadmin').val(data.id_uniadmin);
        $('#uni_descripcion').val(data.uni_descripcion);
    }); 

    $('#modalmantenimiento').modal('show');
}

function eliminar(id_uniadmin){
    swal({
        title: "Desea eliminar el registro?",
        text: "No es posible revertir este cambio",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/unidadAdmin.php?op=eliminar", {id_uniadmin : id_uniadmin}, function (data) {

            }); 

            $('#usuario_data').DataTable().ajax.reload();	

            swal({
                title: "Registro Eliminado!",
                text: "Se ha eliminado correctamente.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}


$(document).on("click","#btnnuevo", function(){
    $('#id_prioridad').val('');
    $('#mdltitulo').html('Nueva Unidad Administrativa');
    $('#usuario_form')[0].reset();

    $('#modalmantenimiento').modal('show');
});

init();