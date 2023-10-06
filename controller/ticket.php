<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    
    $ticket = new Ticket();

    switch($_GET["op"]){
        case "guardar":
            $ticket->CrearTicket($_POST["user_id"],$_POST["id_categoria"],$_POST["titulo_ticket"],$_POST["descripcion"]);
        break;
    }

?>