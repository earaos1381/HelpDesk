
$(document).on("click","#btnenviar", function(){
    
    var user_correo = $("#user_correo").val();

    if (user_correo.length == 0){
        swal("Advertencia!", "Favor de ingresar un correo electrónico", "warning");
    }else{
        $.post("../../controller/usuario.php?op=correo", {user_correo : user_correo}, function (data) {
            
            if(data=="Existe"){
                $.post("../../controller/email.php?op=recuperar_contra", {user_correo : user_correo}, function (data) {
                });

                swal("Contraseña Restablecida!", "Se le ha enviado un correo electronico", "success");
            }else{
                swal("Usuario no encontrado!", "El correo proporcionado no se encuentra registrado", "error");
            }
        });
    }
});