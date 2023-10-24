<?php
    require_once("../config/conexion.php");
    require_once("../models/Documento.php");
    
    $documento = new Documento();

    switch($_GET["op"]){
        case "listar":
            $datos=$documento->obtenerDocTicket($_POST["ticket_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = '<a href="../../public/document/'.$_POST["ticket_id"].'/'.$row["doc_nom"].'" target="_blank">'.$row["doc_nom"].'</a>';
                /* TODO: Formato HTML para abrir el documento o descargarlo en una nueva ventana */
                $sub_array[] = '<a type="button" href="../../public/document/'.$_POST["ticket_id"].'/'.$row["doc_nom"].'" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
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