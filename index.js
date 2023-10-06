
function init(){

}


$(document).ready(function() {


});


$(document).on("click", "#btnsoporte", function() {
    if ($('#id_rol').val() == '1'){
        $('#lbltitulo').html("Soporte");
        $('#btnsoporte').html("Acceso Usuario");
        $('#id_rol').val(2);
    }else{
        $('#lbltitulo').html("Usuario");
        $('#btnsoporte').html("Acceso Soporte");
        $('#id_rol').val(1);
    }
});


init();