
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
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });


    $.post("../../controller/unidadAdmin.php?op=combo",function(data, status){
        $('#id_uniadmin').html(data);
    });

    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#id_categoria').html(data);
    });
    
});

function guardarEditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);

    if ($('#ticket_descripcion').summernote('isEmpty') || $('#id_uniadmin').val()=='' || $('#titulo_ticket').val()=='' || $('#id_categoria').val() == ''){
        swal({
            title: "Advertencia",
            text: "Favor de llenar todos los campos",
            type: "warning",
            confirmButtonClass: "btn-succcess"
        });
        } else {
        $.ajax({
            url: "../../controller/ticket.php?op=guardar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos){
                $('#id_uniadmin').val('');
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
}

init();