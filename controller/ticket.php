<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    
    $ticket = new Ticket();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    switch($_GET["op"]){

        case "guardar":
            $ticket->CrearTicket($_POST["user_id"],$_POST["id_uniadmin"],$_POST["id_categoria"],$_POST["titulo_ticket"],$_POST["descripcion"]);
        break;

        case "actualizar":
            $ticket->actualizarTicket($_POST["ticket_id"]);
            $ticket->InsertarTicketDetalleCerrado($_POST["ticket_id"],$_POST["user_id"]);
            
        break;

        case "asignar":
            $ticket->actualizarTicketAsignacion($_POST["user_asig"] ,$_POST["ticket_id"]);
            
        break;

        case "listarUser":
            $datos = $ticket->ListarTicketPorUser($_POST["user_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array(); //Columnas
                $sub_array[] = $row["ticket_id"];
                $sub_array[] = $row["uni_descripcion"];
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = $row["titulo_ticket"];

                if($row["estado_ticket"] == "Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));

                if($row["fech_asig"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                } else {
                    $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["user_asig"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-warning">Sin asignar</span>';
                } else {
                    $datos1 = $usuario->obtenerUsuarioId($row["user_asig"]);
                    foreach ($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["user_nom"] .'</span>';
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

        case "listar":
            $datos = $ticket->ListarTicket();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array(); //Columnas
                $sub_array[] = $row["ticket_id"];
                $sub_array[] = $row["uni_descripcion"];
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = $row["titulo_ticket"];

                if($row["estado_ticket"] == "Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }
                
                $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));

                if($row["fech_asig"] == NULL){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                } else {
                    $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fech_asig"]));
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
                    $output["id_categoria"] = $row["id_categoria"];
                    $output["titulo_ticket"] = $row["titulo_ticket"];
                    $output["descripcion"] = $row["descripcion"];
                    if ($row["estado_ticket"]=="Abierto"){
                        $output["estado_ticket"] = '<span class="label label-pill label-success">Abierto</span>';
                    } else{
                        $output["estado_ticket"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["estado_ticket_texto"] = $row["estado_ticket"];
                    $output["fecha_create"] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));
                    $output["user_nom"] = $row["user_nom"];
                    $output["user_ap"] = $row["user_ap"];
                    $output["uni_descripcion"] = $row["uni_descripcion"];
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

    }

?>