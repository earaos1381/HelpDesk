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

    }

?>