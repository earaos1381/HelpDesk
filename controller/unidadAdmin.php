<?php
    require_once("../config/conexion.php");
    require_once("../models/UnidadAdmin.php");
    
    $categoria = new UnidadAdmin();

    switch($_GET["op"]){

        case "guardaryeditar":
            if(empty($_POST["id_uniadmin"])){       
                $categoria->CrearUni($_POST["uni_descripcion"]);     
            }
            else {
                $categoria->ActualizarUni($_POST["id_uniadmin"],$_POST["uni_descripcion"]);
            }
        break;

        case "listar":
            $datos=$categoria->ObtenerUni();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["uni_descripcion"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id_uniadmin"].');"  id="'.$row["id_uniadmin"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_uniadmin"].');"  id="'.$row["id_uniadmin"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $categoria->EliminarUni($_POST["id_uniadmin"]);
        break;
        
        case "mostrar";
            $datos=$categoria->ObtenerUniID($_POST["id_uniadmin"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["id_uniadmin"] = $row["id_uniadmin"];
                    $output["uni_descripcion"] = $row["uni_descripcion"];
                }
                echo json_encode($output);
            }
        break;

        case "combo":
            $datos = $categoria->ObtenerUni();
            $html="";
            /* $html = "<option value='-1'>Selecciona una Unidad Administrativa</option>"; */
            $html .= "<option label='Seleccionar'></option>";
            if(is_array($datos) == true and count($datos) > 0){
                
                foreach($datos as $row)
                {
                    $html.= "<option value ='".$row['id_uniadmin']."'>".$row['uni_descripcion']."</option>";
                }
                echo $html;
            }

        break;
    }

?>