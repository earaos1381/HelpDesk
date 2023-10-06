<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    
    $ticket = new Ticket();

    switch($_GET["op"]){
        case "guardar":
            $ticket->CrearTicket($_POST["user_id"],$_POST["id_categoria"],$_POST["titulo_ticket"],$_POST["descripcion"]);
        break;

        case "listarUser";
            $datos = $ticket->ListarTicketPorUser($_POST["user_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id_ticket"];
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = $row["titulo_ticket"];
                $sub_array[] ='<button type="button" onClick="ver('.$row["id_ticket"].');" id="'.$row["id_ticket"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "itotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);    
        break;
    }

?>