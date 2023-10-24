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
        url: "../../controller/subunidadadmin.php?op=guardaryeditar",
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
                text: "Subcategoria Agregada.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    }); 
}

$(document).ready(function(){

    $.post("../../controller/subunidadadmin.php?op=combo",function(data, status){
        console.log(data);
        $('#id_uniadmin').html(data);
    });

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
            url: '../../controller/subunidadadmin.php?op=listar',
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


function editar(subUni_id){
    $('#mdltitulo').html('Editar Registro');


    $.post("../../controller/subunidadadmin.php?op=mostrar", {subUni_id : subUni_id}, function (data) {
        data = JSON.parse(data);
        $('#subUni_id').val(data.subUni_id);
        $('#id_uniadmin').val(data.id_uniadmin).trigger('change');
        $('#subDescripcion').val(data.subDescripcion);
    });

    $('#modalmantenimiento').modal('show');
}


function eliminar(subUni_id){
    swal({
        title: "Desea eliminar el Registro",
        text: "No podra recuperar el registro?",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/subunidadadmin.php?op=eliminar", {subUni_id : subUni_id}, function (data) {

            }); 

            $('#usuario_data').DataTable().ajax.reload();	

            swal({
                title: "Registro Eliminado!",
                text: "Subcategoria Eliminada.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

$(document).on("click","#btnnuevo", function(){
    $('#subUni_id').val('');
    $('#id_uniadmin').val('').trigger('change');
    $('#mdltitulo').html('Nueva Sub Unidad Admin');
    $('#usuario_form')[0].reset();

    $('#modalmantenimiento').modal('show');
});

init();