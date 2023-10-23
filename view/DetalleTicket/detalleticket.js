
function init(){

}

$(document).ready(function(){
    var ticket_id = getUrlParameter('id');

    listardetalle(ticket_id);

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

    $('#descripcion_usu').summernote({
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

    $('#descripcion_usu').summernote('disable');

    tabla=$('#documentos_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/documento.php?op=listar',
            type : "post",
            data : {ticket_id:ticket_id},
            dataType : "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();
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

    if ($('#ticket_descripcion').summernote('isEmpty')){
        
        swal({
            title: "Error",
            text: "Favor de llenar la descripción del ticket",
            type: "warning",
            confirmButtonClass: "btn-warning"
        });
    } else {
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
    }
});

$(document).on("click", "#btcerrarticket", function(){
    swal({
        title: "¿Estás seguro de cerrar el Ticket?",
        text: "Cuando se cierre el Ticket no podrá ser abierto de nuevo",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false,
    }, 
    function(isConfirm) {
        if (isConfirm) {
            var ticket_id = getUrlParameter('id'); 
            var user_id = $('#usuario_id').val(); 
            $.post("../../controller/ticket.php?op=actualizar",{ticket_id : ticket_id, user_id : user_id }, function(data){ 

            });

            $.post("../../controller/email.php?op=ticket_cerrado", {ticket_id : ticket_id}, function(data){ 


            });

            listardetalle(ticket_id);

            swal({
                title: "¡Ticket Cerrado!",
                text: "El Ticket se ha cerrado exitosamente",
                type: "success",
                confirmButtonClass: "btn-success"  
            });
        }
    });
});

function listardetalle(ticket_id){
    $.post("../../controller/ticket.php?op=listarDetalle",{ticket_id : ticket_id }, function(data){
        $('#lbldetalle').html(data);

    });

    $.post("../../controller/ticket.php?op=mostrar",{ticket_id : ticket_id }, function(data){
        data = JSON.parse(data);
        $('#lblestado').html(data.estado_ticket);
        $('#lblnomusuario').html(data.user_nom+' '+data.user_ap);
        $('#lblfechacreacion').html(data.fecha_create);

        $('#lblnoticket').html("Detalle Ticket - #"+data.ticket_id);

        $('#id_uniadmin').val(data.uni_descripcion)
        $('#id_categoria').val(data.cat_descripcion); 
        $('#titulo_ticket').val(data.titulo_ticket);
        $('#descripcion_usu').summernote('code', data.descripcion);

        
        if(data.estado_ticket_texto == 'Cerrado'){
            $('#pnldetalle').hide();
        } else {
            
        } 
    });
}

init();