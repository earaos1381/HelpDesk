
function init(){

}

$(document).ready(function(){
    var ticket_id = getUrlParameter('id');

    $.post("../../controller/ticket.php?op=listarDetalle",{ticket_id : ticket_id }, function(data){
        $('#lbldetalle').html(data);

        $('#ticket_descripcion').summernote({
            height: 200,
            lang: "es-ES",
            popover: {
                image: [],
                link: [],
                air: []
            },
        });
    });

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

init();