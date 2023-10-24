<?php
    require_once("../config/conexion.php");
    require_once("../models/Prioridad.php");
    
    $prioridad = new Prioridad();

    switch($_GET["op"]){
        case "guardaryeditar":
            if(empty($_POST["id_prioridad"])){       
                $prioridad->CrearPrio($_POST["prio_descrip"]);     
            }
            else {
                $prioridad->ActualizarPrio($_POST["id_prioridad"],$_POST["prio_descrip"]);
            }
        break;

        case "listar":
            $datos=$prioridad->ObtenerPrio();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["prio_descrip"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id_prioridad"].');"  id="'.$row["id_prioridad"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_prioridad"].');"  id="'.$row["id_prioridad"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "eliminar":
            $prioridad->EliminarPrio($_POST["id_prioridad"]);
        break;
        
        case "mostrar";
            $datos=$prioridad->ObtenerPrioID($_POST["id_prioridad"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["id_prioridad"] = $row["id_prioridad"];
                    $output["prio_descrip"] = $row["prio_descrip"];
                }
                echo json_encode($output);
            }
        break;

        case "combo":
            $datos = $prioridad->ObtenerPrio();
            $html="";
            /* $html = "<option value='-1'>Selecciona una Prioridad</option>"; */
            $html .= "<option label='Seleccionar'></option>";
            
            if(is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $html.= "<option value ='".$row['id_prioridad']."'>".$row['prio_descrip']."</option>";
                }
                echo $html;
            }

        break;
    }

?>