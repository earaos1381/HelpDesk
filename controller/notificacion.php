<?php
    require_once("../config/conexion.php");
    require_once("../models/Notificacion.php");
    
    $notifiacion = new Notificacion();

    switch($_GET["op"]){
        
        case "mostrar";
            $datos=$notifiacion->ObtenerNotificacionPorUsuario($_POST["user_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["not_id"] = $row["not_id"];
                    $output["user_id"] = $row["user_id"];
                    $output["mensaje"] = $row["mensaje"] .' '. $row["ticket_id"];
                    $output["ticket_id"] = $row["ticket_id"];
                    
                }
                echo json_encode($output);
            }
        break;

        case "actualizar";
            $notifiacion->ActualizarNotificacionEstado($_POST["not_id"]);
        break;

        case "listar":
            $datos = $notifiacion->ObtenerNotificacionPorUsuario2($_POST["user_id"]);
            $data = Array();
            foreach ($datos as $row) {
                $sub_array = array();
                $not_id = $row["not_id"];
                $ticket_id = $row["ticket_id"];
                $sub_array[] = $row["mensaje"] . ' ' . $ticket_id;
                $sub_array[] = '<button type="button" onClick="ver(' . $not_id . ',' . $ticket_id . ')" data-not_id="' . $not_id . '" data-ticket_id="' . $ticket_id . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }
        
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
            break;
        

        case "leer";
            $notifiacion->ActualizarNotificacionEstadoLeido($_POST["not_id"]);
        break;
        

    }

?>