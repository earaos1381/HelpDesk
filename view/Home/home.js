function init(){

}

$(document).ready(function(){

    var user_id = $('#usuario_id').val();

    if ($('#id_roluser').val() == 1){
        $.post("../../controller/usuario.php?op=total",{user_id : user_id}, function(data){
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });
    
        $.post("../../controller/usuario.php?op=totalabierto",{user_id : user_id}, function(data){
            data = JSON.parse(data);
            $('#lbltotalabiertos').html(data.TOTAL);
        });
    
        $.post("../../controller/usuario.php?op=totalcerrado",{user_id : user_id}, function(data){
            data = JSON.parse(data);
            $('#lbltotalcerrados').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=grafico",{user_id : user_id}, function (data) {
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['No. Tickets'],
                barColors: ["#435EB4"]
            });
        });
    

    } else {
        $.post("../../controller/ticket.php?op=total", function(data){
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });
    
        $.post("../../controller/ticket.php?op=totalabierto", function(data){
            data = JSON.parse(data);
            $('#lbltotalabiertos').html(data.TOTAL);
        });
    
        $.post("../../controller/ticket.php?op=totalcerrado", function(data){
            data = JSON.parse(data);
            $('#lbltotalcerrados').html(data.TOTAL);
        });

        $.post("../../controller/ticket.php?op=grafico",function (data) {
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['No. Tickets']
            });
        });
    
    }

    
});



init();