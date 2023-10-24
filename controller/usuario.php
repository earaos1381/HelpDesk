<?php
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    
    $usuario = new Usuario();

    switch($_GET["op"]){
        case "guardaryeditar":
            if(empty($_POST["user_id"])){

                    $usuario->crearUsuario($_POST["user_nom"],$_POST["user_ap"],$_POST["user_correo"],$_POST["user_password"],$_POST["id_rol"]);

            } else {
                $usuario->actualizarUsuario($_POST["user_id"],$_POST["user_nom"],$_POST["user_ap"],$_POST["user_correo"],$_POST["user_password"],$_POST["id_rol"]);
            }
        break;

        case "listar":
            $datos = $usuario->obtenerUsuario();
            $data = Array();
            foreach ($datos as $row) {
                $sub_array = array(); // Columnas
                $sub_array[] = $row["user_nom"];
                $sub_array[] = $row["user_ap"];
                $sub_array[] = $row["user_correo"];
                /* $sub_array[] = $row["user_password"]; */
        
                if ($row["id_rol"] == "1") {
                    $sub_array[] = '<span class="label label-pill label-success">Usuario</span>';
                } elseif ($row["id_rol"] == "2") {
                    $sub_array[] = '<span class="label label-pill label-info">Soporte</span>';
                } elseif ($row["id_rol"] == "3") {
                    $sub_array[] = '<span class="label label-pill label-warning">Administrador</span>';
                } else {
                    $sub_array[] = '<span class="label label-pill label-default">Rol Desconocido</span>';
                }
        
                $sub_array[] = '<button type="button" onClick="editar(' . $row["user_id"] . ');" id="' . $row["user_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar(' . $row["user_id"] . ');" id="' . $row["user_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }
        
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "itotalDisplayRecords" => count($data),
                "aaData" => $data,
            );
            echo json_encode($results);

        break;
            

        case "eliminar":
            $usuario->eliminarUsuario($_POST["user_id"]);
        break;

        case "mostrar":
            $datos = $usuario->obtenerUsuarioId($_POST["user_id"]);
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["user_id"] = $row["user_id"];
                    $output["user_nom"] = $row["user_nom"];
                    $output["user_ap"] = $row["user_ap"];
                    $output["user_correo"] = $row["user_correo"];
                    $output["user_password"] = $row["user_password"];
                    $output["id_rol"] = $row["id_rol"];
                }
                echo json_encode($output);
            }
        break;

        case "total":
            $datos = $usuario->obtenerUsuarioTicketId($_POST["user_id"]);
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalabierto":
            $datos = $usuario->obtenerUsuarioTicketAbiertoId($_POST["user_id"]);
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalcerrado":
            $datos = $usuario->obtenerUsuarioTicketCerradoId($_POST["user_id"]);
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "grafico";
            $datos=$usuario->obtenerUsuarioGrafico($_POST["user_id"]);  
            echo json_encode($datos);
        break;

        case "combo"; //para obtener solo los roles de soporte
            $datos = $usuario->obtenerUsuarioPorRol(); 
            if(is_array($datos) == true and count($datos) > 0){
                $html.= "<option label = 'Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['user_id']."'>".$row['user_nom'].' '.$row['user_ap']."</option>";
                }
                echo $html;
            }
        break;

        case "password":
            /* $cifrado = openssl_encrypt($_POST["user_password"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $usuario->actualizarPassUsuario($_POST["user_correo"],$textoCifrado); */
            $usuario->actualizarPassUsuario($_POST["user_password"],$_POST["user_id"]);
        break;

        /* case "correo":
            $datos=$usuario->get_usuario_x_correo($_POST["usu_correo"]);
            if(is_array($datos)==true and count($datos)>0){

                echo "Existe";
            }else{
                echo "Error";
            }
        break; */
    }
?>