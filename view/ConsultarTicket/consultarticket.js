var tabla;
var user_id = $('#usuario_id').val();
var rolID = $('#id_roluser').val();

function init(){
    $("#ticket_form").on("submit", function(e){
        guardar(e);
    });

}

$(document).ready(function(){

    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#id_categoria').html(data);
    });

    $.post("../../controller/prioridad.php?op=combo",function(data, status){
        $('#id_prioridad').html(data);
    });


    $.post("../../controller/usuario.php?op=combo", function(data) { 
        $('#user_asig').html(data);
    });


    if(rolID == 1){
        tabla = $('#ticket_data').dataTable({
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
                url: '../../controller/ticket.php?op=listarUser',
                type : "post",
                dataType : "json",  
                data:{ user_id : user_id },                        
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

    } else {

        var titulo_ticket = $('#titulo_ticket').val();
        var id_categoria = $('#id_categoria').val();
        var id_prioridad = $('#id_prioridad').val();

        listardatatable(titulo_ticket,id_categoria,id_prioridad, user_id);
        /* tabla = $('#ticket_data').dataTable({
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
                url: '../../controller/ticket.php?op=listar_filtro',
                type : "post",
                dataType : "json",
                data:{ titulo_ticket : titulo_ticket, id_categoria : id_categoria, id_prioridad : id_prioridad},                    
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
        }).DataTable();   */
    }
});

function ver(ticket_id){ //modificaciones
        var nuevaVentana = window.open('http://localhost/mesaayuda/view/DetalleTicket/?id='+ ticket_id +'');

        window.close();
}

function asignar (ticket_id){
    $.post("../../controller/ticket.php?op=mostrar",{ticket_id : ticket_id}, function(data) { 
        data = JSON.parse(data);
        $('#ticket_id').val(data.ticket_id);

        $('#mdltitulo').html('Asignar Soporte');
        $('#modalasignar').modal('show');
    });
    
}

function guardar(e){
    e.preventDefault();
	var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticket.php?op=asignar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){

            var ticket_id = $('#ticket_id').val();
            $.post("../../controller/email.php?op=ticket_asignado", {ticket_id : ticket_id}, function(data){ 

            });

            swal({
                title: "Ticket Asignado!",
                text: "Completado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });

            $("#modalasignar").modal('hide');
            $('#ticket_data').DataTable().ajax.reload();

        }
    }); 
}

function CambiarEstado (ticket_id){

    swal({
        title: "Reabrir Ticket",
        text: "Esta seguro de realizar esta acción?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/ticket.php?op=reabrir", {ticket_id : ticket_id, user_id : user_id}, function (data) {

            });

            $('#ticket_data').DataTable().ajax.reload();	

            swal({
                title: "Cambio Realizado!",
                text: "Ticket Abierto.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
    
}

$(document).on("click","#btnfiltrar", function(){
    limpiar();

    var titulo_ticket = $('#titulo_ticket').val();
    var id_categoria = $('#id_categoria').val();
    var id_prioridad = $('#id_prioridad').val();

    listardatatable(titulo_ticket,id_categoria,id_prioridad);
});

$(document).on("click","#btntodo", function(){
    limpiar();
    $('#titulo_ticket').val('');
    $('#id_categoria').val('').trigger('change');
    $('#id_prioridad').val('').trigger('change');

    listardatatable('','','');
});


function listardatatable(titulo_ticket,id_categoria,id_prioridad){
    tabla = $('#ticket_data').dataTable({
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
            url: '../../controller/ticket.php?op=listar_filtro',
            type : "post",
            dataType : "json",
            data:{ titulo_ticket : titulo_ticket, id_categoria : id_categoria, id_prioridad : id_prioridad},                    
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
}

function limpiar(){
    $('#table').html(
        "<table id='ticket_data' class='table table-bordered table-striped table-vcenter js-dataTable-full'>"+
            "<thead>"+
                "<tr>"+
                    "<th style='width: 5%;'>#</th>"+
                    "<th style='width: 15%;'>Unidad Administrativa</th>"+
                    "<th style='width: 15%;'>Categoria</th>"+
                    "<th style='width: 40%;'>Asunto</th>"+
					"<th style='width: 5%;'>Prioridad</th>"+
					"<th style='width: 5%;'>Estado</th>"+
					"<th style='width: 5%;'>Fecha de Creación</th>"+
					"<th style='width: 5%;'>Fecha de Asignación</th>"+
					"<th style='width: 5%;'>Fecha de Cierre</th>"+
					"<th style='width: 10%;'>Soporte</th>"+
					"<th style='width: 5%;'></th>"+
                "</tr>"+
            "</thead>"+
            "<tbody>"+

            "</tbody>"+
        "</table>"
    );
}

init();