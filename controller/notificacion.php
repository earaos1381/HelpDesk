<?php
    require_once("../config/conexion.php");
    require_once("../models/Notificacion.php");
    
    $notifiacion = new Notificacion();

/*     $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher)); */

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
            $datos=$notifiacion->ObtenerNotificacionPorUsuario2($_POST["user_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["mensaje"] . ' ' . $row["ticket_id"];

                /* $cifrado = openssl_encrypt($row["ticket_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado); */

                /* $sub_array[] = '<button type="button" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>'; */
                $sub_array[] = '<button type="button" onClick="ver('.$row["ticket_id"].')" id="'.$row["ticket_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

    }

?>