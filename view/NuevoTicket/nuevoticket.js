
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

    $.post("../../controller/prioridad.php?op=combo",function(data, status){
        $('#id_prioridad').html(data);
    });

    $.post("../../controller/unidadAdmin.php?op=combo",function(data, status){
        $('#id_uniadmin').html(data);
    });

    $("#id_uniadmin").change(function(){
        id_uniadmin = $(this).val();
        
        $.post("../../controller/subunidadadmin.php?op=combo",{id_uniadmin : id_uniadmin}, function(data, status){
            $('#subUni_id').html(data);

            if (data.indexOf('No hay subcategorías disponibles') !== -1) {
                $('#subUni_id').prop('disabled', true);
            } else {
                $('#subUni_id').prop('disabled', false);
            }
        });

    });

    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#id_categoria').html(data);
    });
    
});

function guardarEditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);

    if ($('#ticket_descripcion').summernote('isEmpty') || 
        $('#id_uniadmin').val()== 0 || 
        $('#titulo_ticket').val()=='' || 
        $('#id_prioridad').val() == 0 ||  
        $('#id_categoria').val()== 0 ||
        $('#subUni_id').val()== -1
        
        ){
        swal({
            title: "Advertencia",
            text: "Favor de llenar todos los campos",
            type: "warning",
            confirmButtonClass: "btn-succcess"
        });
        } else {

            var totalfiles = $('#fileElem').val().length;
            for (var i = 0; i < totalfiles; i++){
                formData.append("files[]", $('#fileElem')[0].files[i]);
            }

            $.ajax({
                url: "../../controller/ticket.php?op=guardar",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function(data){
                    data = JSON.parse(data);
                    
                    $.post("../../controller/email.php?op=ticket_abierto", {ticket_id : data[0].ticket_id}, function(data){ 


                    });
                    $('#id_prioridad').val('');
                    $('#id_uniadmin').val('');
                    $('#subUni_id').val('');
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