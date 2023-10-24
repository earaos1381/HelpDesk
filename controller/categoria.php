<?php
    require_once("../config/conexion.php");
    require_once("../models/Categoria.php");
    
    $categoria = new Categoria();

    switch($_GET["op"]){

        case "guardaryeditar":
            if(empty($_POST["cat_id"])){       
                $categoria->CrearCat($_POST["cat_descripcion"]);     
            }
            else {
                $categoria->ActualizarCat($_POST["cat_id"],$_POST["cat_descripcion"]);
            }
        break;

        case "listar":
            $datos=$categoria->ObtenerCat();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["cat_descripcion"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["cat_id"].');"  id="'.$row["cat_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["cat_id"].');"  id="'.$row["cat_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $categoria->EliminarCat($_POST["cat_id"]);
        break;
        
        case "mostrar";
            $datos=$categoria->ObtenerCatID($_POST["cat_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["cat_id"] = $row["cat_id"];
                    $output["cat_descripcion"] = $row["cat_descripcion"];
                }
                echo json_encode($output);
            }
        break;

        case "combo":
            $datos = $categoria->ObtenerCat();
            $html="";
            /* $html .= "<option value='-1' label='Seleccionar'></option>"; */
            $html .= "<option label='Seleccionar'></option>";


            if(is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row)
                {
                    $html.= "<option value ='".$row['cat_id']."'>".$row['cat_descripcion']."</option>";
                }
                echo $html;
            }

        break;
    }

?>