<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    
    $ticket = new Ticket();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    require_once("../models/Documento.php");
    $documento = new Documento();

    switch($_GET["op"]){

        case "guardar":

            $user_id = $_POST["user_id"];
            $id_uniadmin = $_POST["id_uniadmin"];
            $id_categoria = $_POST["id_categoria"];
            $titulo_ticket = $_POST["titulo_ticket"];
            $descripcion = $_POST["descripcion"];
            $subUni_id = isset($_POST["subUni_id"]) ? $_POST["subUni_id"] : null; // Establecer subUni_id como nulo si no se seleccionó ninguna subcategoría
            $id_prioridad = $_POST["id_prioridad"];

            $data = $ticket->CrearTicket($user_id, $id_uniadmin, $subUni_id, $id_categoria, $titulo_ticket, $descripcion, $id_prioridad);    
            
            if (is_array($data)==true and count($data)>0){
                foreach ($data as $row){
                    $output["ticket_id"] = $row["ticket_id"];

                    if (!empty($_FILES['files']['name'][0])) {
                        // Verificar que al menos un archivo fue proporcionado
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = "../public/document/" . $output["ticket_id"] . "/";
                        $files_arr = array();
            
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }
            
                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta . $_FILES['files']['name'][$index];
            
                            $documento->insertar_documento($output["ticket_id"], $_FILES['files']['name'][$index]);
            
                            move_uploaded_file($doc1, $destino);
                        }
                    }
                }
            }
            echo json_encode($data);
        break;

        case "actualizar":
            $ticket->actualizarTicket($_POST["ticket_id"]);
            $ticket->InsertarTicketDetalleCerrado($_POST["ticket_id"],$_POST["user_id"]);
            
        break;

        case "reabrir":
            $ticket->reabrirTicket($_POST["ticket_id"]);
            $ticket->InsertarTicketDetalleReabrir($_POST["ticket_id"],$_POST["user_id"]);
        break;

        case "asignar":
            $ticket->actualizarTicketAsignacion($_POST["user_asig"] ,$_POST["ticket_id"]);
            
        break;

        case "listarUser": //lista ticker de usuario normal
            $datos = $ticket->ListarTicketPorUser($_POST["user_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array(); //Columnas
                $sub_array[] = $row["ticket_id"];
                $sub_array[] = $row["uni_descripcion"];
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = $row["titulo_ticket"];

                $priority_label = '';
                switch ($row["prio_descrip"]) {
                    case 'Alta':
                        $priority_label = '<span class="label label-pill label-danger">Alta</span>';
                        break;
                    case 'Media':
                        $priority_label = '<span class="label label-pill label-warning">Media</span>';
                        break;
                    case 'Baja':
                        $priority_label = '<span class="label label-pill label-primary">Baja</span>';
                        break;
                    default:
                        $priority_label = $row["prio_descrip"]; 
                }
                $sub_array[] = $priority_label;    

                if($row["estado_ticket"] == "Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["ticket_id"].')"><span class="label label-pill label-danger">Cerrado</span></a>';
                }

                $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));

                if($row["fech_asig"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                } else {
                    $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["fech_cierre"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                } else {
                    $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fech_cierre"]));
                }

                if($row["user_asig"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-warning">Sin asignar</span>';
                } else {
                    $datos1 = $usuario->obtenerUsuarioId($row["user_asig"]);
                    foreach ($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["user_nom"] .' '. $row1["user_ap"] .'</span>';
                    }
                }

                $sub_array[] ='<button type="button" onClick="ver('.$row["ticket_id"].');" id="'.$row["ticket_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "itotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);    
        break;

        /* case "listar": //listar por rol - ESTE FUNCIONA PERO SERA HISTORICO
            $datos = $ticket->ListarTicket($_SESSION["id_rol"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array(); //Columnas
                $sub_array[] = $row["ticket_id"];
                $sub_array[] = $row["uni_descripcion"];
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = $row["titulo_ticket"];

                $priority_label = '';
                switch ($row["prio_descrip"]) {
                    case 'Alta':
                        $priority_label = '<span class="label label-pill label-danger">Alta</span>';
                        break;
                    case 'Media':
                        $priority_label = '<span class="label label-pill label-warning">Media</span>';
                        break;
                    case 'Baja':
                        $priority_label = '<span class="label label-pill label-primary">Baja</span>';
                        break;
                    default:
                        $priority_label = $row["prio_descrip"]; 
                }
                $sub_array[] = $priority_label;

                if($row["estado_ticket"] == "Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["ticket_id"].')"><span class="label label-pill label-danger">Cerrado</span></a>';
                }
                
                $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));

                if($row["fech_asig"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                } else {
                    $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["fech_cierre"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                } else {
                    $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fech_cierre"]));
                }

                if($row["user_asig"] == NULL){
                    $sub_array[] = '<a onClick="asignar('.$row["ticket_id"].');"><span class="label label-pill label-warning">Sin asignar</span></a>';
                } else {
                    $datos1 = $usuario->obtenerUsuarioId($row["user_asig"]);
                    foreach ($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["user_nom"] . ' ' . $row1["user_ap"] .'</span>';
                    }
                }

                $sub_array[] ='<button type="button" onClick="ver('.$row["ticket_id"].');" id="'.$row["ticket_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "itotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);    
        break; */

        case "listar_filtro":

            if (isset($_POST["titulo_ticket"])) {
                $_SESSION["titulo_ticket"] = $_POST["titulo_ticket"];
            } else {
                $_SESSION["titulo_ticket"] = "";
            }
        
            if (isset($_POST["id_categoria"])) {
                $_SESSION["id_categoria"] = $_POST["id_categoria"];
            } else {
                $_SESSION["id_categoria"] = "";
            }
        
            if (isset($_POST["id_prioridad"])) {
                $_SESSION["id_prioridad"] = $_POST["id_prioridad"];
            } else {
                $_SESSION["id_prioridad"] = "";
            }
        
            $datos = $ticket->filtrarTicket(
                $_SESSION["titulo_ticket"],
                $_SESSION["id_categoria"],
                $_SESSION["id_prioridad"],
                $_SESSION["id_rol"],
                $_SESSION["user_id"]
            );
            $data = Array();
        
            foreach($datos as $row){
                $sub_array = array(); //Columnas
                $sub_array[] = $row["ticket_id"];
                $sub_array[] = $row["uni_descripcion"];
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = $row["titulo_ticket"];

                $priority_label = '';
                switch ($row["prio_descrip"]) {
                    case 'Alta':
                        $priority_label = '<span class="label label-pill label-danger">Alta</span>';
                        break;
                    case 'Media':
                        $priority_label = '<span class="label label-pill label-warning">Media</span>';
                        break;
                    case 'Baja':
                        $priority_label = '<span class="label label-pill label-primary">Baja</span>';
                        break;
                    default:
                        $priority_label = $row["prio_descrip"]; 
                }
                $sub_array[] = $priority_label;

                if($row["estado_ticket"] == "Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["ticket_id"].')"><span class="label label-pill label-danger">Cerrado</span></a>';
                }
                
                $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));

                if($row["fech_asig"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                } else {
                    $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["fech_cierre"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                } else {
                    $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fech_cierre"]));
                }

                if($row["user_asig"] == NULL){
                    $sub_array[] = '<a onClick="asignar('.$row["ticket_id"].');"><span class="label label-pill label-warning">Sin asignar</span></a>';
                } else {
                    $datos1 = $usuario->obtenerUsuarioId($row["user_asig"]);
                    foreach ($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["user_nom"] . ' ' . $row1["user_ap"] .'</span>';
                    }
                }

                $sub_array[] ='<button type="button" onClick="ver('.$row["ticket_id"].');" id="'.$row["ticket_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "itotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);    
        break;

        case "listarDetalle":
            $datos = $ticket->DetalleTicket($_POST["ticket_id"]);
            ?>
                <?php
                    foreach($datos as $row){
                        ?>
                            <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                    <?php echo date("d/m/Y", strtotime($row["fecha_create"]));;?>
                                </div>
                                <header class="activity-line-item-header">
                                    <div class="activity-line-item-user">
                                        <div class="activity-line-item-user-photo">
                                            <a href="#">
                                                <img src="../../public/img/<?php echo $row['id_rol']?>.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"><?php echo $row['user_nom'].' '.$row['user_ap'];?></div>
                                        <div class="activity-line-item-user-status">
                                            <?php 
                                                if($row['id_rol'] == 1){
                                                    echo 'Usuario';
                                                } else {
                                                    echo 'Soporte';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                        <div class="time"><?php echo date("H:i:s", strtotime($row["fecha_create"]));;?></div>
                                        <div class="cont">
                                            <div class="cont-in">
                                                <p><?php echo $row['descripcion'];?></p>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </article>
                        <?php
                    }
                ?>
            <?php
        break;

        case "mostrar":
            
            $datos = $ticket->ListarTicketPorID($_POST["ticket_id"]);
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["ticket_id"] = $row["ticket_id"];
                    $output["user_id"] = $row["user_id"];
                    $output["id_uniadmin"] = $row["id_uniadmin"];
                    $output["subUni_id"] = $row["subUni_id"];
                    $output["id_categoria"] = $row["id_categoria"];
                    $output["titulo_ticket"] = $row["titulo_ticket"];
                    $output["descripcion"] = $row["descripcion"];
                    $output["prio_descrip"] = $row["prio_descrip"];
                    /* $priority_mapping = array(
                        'Alta' => '<span class="label label-pill label-danger">Alta</span>',
                        'Media' => '<span class="label label-pill label-warning">Media</span>',
                        'Baja' => '<span class="label label-pill label-primary">Baja</span>'
                    );
                    $output["priority_label"] = $priority_mapping[$row["prio_descrip"]] ?? $row["prio_descrip"]; */

                                



                    if ($row["estado_ticket"]=="Abierto"){
                        $output["estado_ticket"] = '<span class="label label-pill label-success">Abierto</span>';
                    } else{
                        $output["estado_ticket"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["estado_ticket_texto"] = $row["estado_ticket"];
                    $output["fecha_create"] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));
                    $output["fecha_create"] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));
                    $output["user_nom"] = $row["user_nom"];
                    $output["user_ap"] = $row["user_ap"];                 
                    $output["uni_descripcion"] = $row["uni_descripcion"];
                    $output["subDescripcion"] = $row["subDescripcion"];
                    $output["cat_descripcion"] = $row["cat_descripcion"];
                }
                echo json_encode($output);
            }
        break;

        case "guardarDetalle":
            $ticket->InsertarTicketDetalle($_POST["ticket_id"],$_POST["user_id"],$_POST["descripcion"]);
        break;

        case "total":
            $datos = $ticket->obtenerTicket();
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalabierto":
            $datos = $ticket->obtenerTicketAbierto();
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalcerrado":
            $datos = $ticket->obtenerTicketCerrado();
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "grafico";
            $datos=$ticket->obtenerTicketGrafico();  
            echo json_encode($datos);
        break;

        case "totalsoporteporusuario":
            $user_id = $_POST['user_id'];
            $datos = $ticket->obtenerTotalSoportePorUsuario($user_id);
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;
        
        case "totalabiertosoporteporusuario":
            $user_id = $_POST['user_id'];
            $datos = $ticket->obtenerTotalAbiertoSoportePorUsuario($user_id);
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;
        
        case "totalcerradosoporteporusuario":
            $user_id = $_POST['user_id'];
            $datos = $ticket->obtenerTotalCerradoSoportePorUsuario($user_id);
            if (is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;
        
        case "graficosoporteporusuario":
            $user_id = $_POST['user_id'];
            $datos = $ticket->obtenerGraficoSoportePorUsuario($user_id);
            echo json_encode($datos);
        break;
        

    }

?>