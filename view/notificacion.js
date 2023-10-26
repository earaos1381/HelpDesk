$(document).ready(function(){

    mostrar_notificacion();

});

function mostrar_notificacion(){

    var formData = new FormData();
    formData.append('user_id',$('#usuario_id').val());

    $.ajax({
        url: "../../controller/notificacion.php?op=mostrar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){

            if (data==''){
            }else{

                data = JSON.parse(data);
                $.notify({
                    icon: 'glyphicon glyphicon-exclamation-sign',
                    message: data.mensaje,
                    url: "http://localhost/mesaayuda/view/DetalleTicket/?id="+data.ticket_id
                });

                $.post("../../controller/notificacion.php?op=actualizar", {not_id : data.not_id}, function (data) {

                });
            }
        }
    });

}

setInterval(function(){
    mostrar_notificacion();
}, 5000);


