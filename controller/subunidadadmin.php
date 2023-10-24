<?php
require_once("../config/conexion.php");
require_once("../models/SubUnidadAdmin.php");

$subunidadadmin = new SubUnidadAdmin();

switch($_GET["op"]){

    case "guardaryeditar":
        if(empty($_POST["subUni_id"])){
            $subunidadadmin->CrearSubuni($_POST["id_uniadmin"],$_POST["subDescripcion"]);     
        }else {
            $subunidadadmin->ActualizarSubuni($_POST["subUni_id"],$_POST["id_uniadmin"],$_POST["subDescripcion"]);
        }
        break;

    case "listar":
        $datos=$subunidadadmin->ObtenerSubuniTodas();
        $data= Array();
        foreach($datos as $row){
            $sub_array = array();
            $sub_array[] = $row["uni_descripcion"];
            $sub_array[] = $row["subDescripcion"];
            $sub_array[] = '<button type="button" onClick="editar('.$row["subUni_id"].');"  id="'.$row["subUni_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["subUni_id"].');"  id="'.$row["subUni_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
        $subunidadadmin->EliminarSubuni($_POST["subUni_id"]);
        break;

    case "mostrar";
        $datos=$subunidadadmin->ObtenerSubuniID($_POST["subUni_id"]);  
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["subUni_id"] = $row["subUni_id"];
                $output["id_uniadmin"] = $row["id_uniadmin"];
                $output["subDescripcion"] = $row["subDescripcion"];
            }
            echo json_encode($output);
        }
        break;
        

    case "combo":
        $id_uniadmin = $_POST['id_uniadmin'];
        $datos = $subunidadadmin->ObtenerSubuni($id_uniadmin);
        $html="";
        $html = "<option value='-1'>Selecciona una SubCategoria</option>";

/*         $html .= "<option label='Seleccionar'></option>"; */


        if(is_array($datos) == true and count($datos) > 0){
            foreach($datos as $row) {
                $html .= "<option value='".$row['subUni_id']."'>".$row['subDescripcion']."</option>";
            }
        } else {
            $html = "<option value=''>No hay subcategorías disponibles</option>";
        }

        echo $html;
    break;
}
?>
