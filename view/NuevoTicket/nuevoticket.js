
function init(){
    $('#ticket_form').on("submit", function(e){
        guardarEditar(e);
    })
}


$(document).ready(function() {
	$('#ticket_descripcion').summernote({
        height: 200,
        lang: "es-ES",
        popover: {
            image: [],
            link: [],
            air: []
        },
    });

    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#id_categoria').html(data);
    });
});

function guardarEditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticket.php?op=guardar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
            $('#id_categoria').val('');
            $('#titulo_ticket').val('');
            $('#ticket_descripcion').summernote('reset');
            swal({
                title: "Correcto",
                text: "Ticket agregado exitosamente",
                type: "success",
                confirmButtonClass: "btn-succcess"
            });
        }
    });
}

init();