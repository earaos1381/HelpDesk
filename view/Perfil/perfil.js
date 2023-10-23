
$(document).on("click","#btnactualizar", function(){

    var pass = $("#txtpassword").val();
    var newpass = $("#txtpasswordnew").val();
 
     if (pass.length == 0 || newpass.length == 0) {
         swal("Error!", "Campos Vacios", "error");
     }else{
         if (pass == newpass){
 
             var user_id = $('#usuario_id').val();

             $.post("../../controller/usuario.php?op=password", {user_id : user_id, user_password : newpass}, function (data) {
                 swal("Correcto!", "Contraseña Actualizada Correctamente", "success");
             });
 
         }else{
             swal("Error!", "Las contraseñas no coinciden", "error");
         }
     }
 });