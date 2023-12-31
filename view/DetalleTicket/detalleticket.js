
function init(){

}

$(document).ready(function(){
    var ticket_id = getUrlParameter('id');

    listardetalle(ticket_id);

    $.post("../../controller/ticket.php?op=mostrar",{ticket_id : ticket_id }, function(data){
        data = JSON.parse(data);
        $('#lblestado').html(data.estado_ticket);
        $('#lblnomusuario').html(data.user_nom+' '+data.user_ap);
        $('#lblfechacreacion').html(data.fecha_create);
        $('#lblnoticket').html("Detalle Ticket - #"+data.ticket_id);
        $('#id_categoria').val(data.cat_descripcion); 
        $('#titulo_ticket').val(data.titulo_ticket);
        $('#descripcion_usu').summernote('code', data.descripcion);
    });

    $('#ticket_descripcion').summernote({
        height: 400,
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
        }
        
    });

    $('#descripcion_usu').summernote({
        height: 400,
        lang: "es-ES",
    });

    $('#descripcion_usu').summernote('disable');
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        SParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        SParameterName = sURLVariables[i].split('=');

        if(SParameterName[0] === sParam){
            return SParameterName[1] === undefined ? true : SParameterName[1];
        }
    }
};

$(document).on("click", "#btnenviar", function(){
    var ticket_id = getUrlParameter('id');
    var user_id = $('#usuario_id').val(); 
    var descripcion = $('#ticket_descripcion').val(); 

    $.post("../../controller/ticket.php?op=guardarDetalle",{ticket_id : ticket_id, user_id : user_id, descripcion : descripcion}, function(data){
        listardetalle(ticket_id);
        $('#ticket_descripcion').summernote('reset');
        swal({
            title: "Correcto",
            text: "Registro agregado correctamente",
            type: "success",
            confirmButtonClass: "btn-succcess"
        });

    });
});

$(document).on("click", "#btcerrarticket", function(){

});

function listardetalle(ticket_id){
    $.post("../../controller/ticket.php?op=listarDetalle",{ticket_id : ticket_id }, function(data){
        $('#lbldetalle').html(data);

    });
}

init();