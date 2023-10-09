<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    
    $ticket = new Ticket();

    switch($_GET["op"]){

        case "guardar":
            $ticket->CrearTicket($_POST["user_id"],$_POST["id_categoria"],$_POST["titulo_ticket"],$_POST["descripcion"]);
        break;

        case "listarUser":
            $datos = $ticket->ListarTicketPorUser($_POST["user_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array(); //Columnas
                $sub_array[] = $row["ticket_id"];
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = $row["titulo_ticket"];

                if($row["estado_ticket"] == "Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));
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
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = $row["titulo_ticket"];

                if($row["estado_ticket"] == "Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }
                
                $sub_array[] = date("d/m/Y - H:i:s", strtotime($row["fecha_create"]));
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
                                                <img src="../../public/img/photo-64-2.jpg" alt="">
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
                    $output["cat_descripcion"] = $row["cat_descripcion"];
                }
                echo json_encode($output);
            }
        break;

        case "guardarDetalle":
            $ticket->InsertarTicketDetalle($_POST["ticket_id"],$_POST["user_id"],$_POST["descripcion"]);
        break;

        case "actualizar":
            $ticket->actualizarTicket($_POST["ticket_id"]);
            break;
    }

?>