function init() {

    var currentRole = 1;

    $(document).on("click", "#btnsoporte", function() {

        currentRole = (currentRole % 3) + 1;


        if (currentRole === 1) {
            $('#lbltitulo').html("Usuario");
            $('#btnsoporte').html("Acceso Soporte");
            $('#imgtipo').attr("src", "public/img/1.jpg");
        } else if (currentRole === 2) {
            $('#lbltitulo').html("Soporte");
            $('#btnsoporte').html("Acceso Administrador");
            $('#imgtipo').attr("src", "public/img/2.jpg");
        } else if (currentRole === 3) {
            $('#lbltitulo').html("Administrador");
            $('#btnsoporte').html("Acceso Usuario");
            $('#imgtipo').attr("src", "public/img/3.jpg");
        }

        $('#id_rol').val(currentRole);
    });
}

$(document).ready(function() {
    init();
});
