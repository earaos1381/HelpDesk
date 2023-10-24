<?php
    require_once("../config/conexion.php");
    require_once("../models/UnidadAdmin.php");
    
    $categoria = new UnidadAdmin();

    switch($_GET["op"]){
        case "combo":
            $datos = $categoria->ObtenerUni();
            $html="";
            if(is_array($datos) == true and count($datos) > 0){
                
                $html = "<option>Selecciona una Unidad Administrativa</option>";
                foreach($datos as $row)
                {
                    $html.= "<option value ='".$row['id_uniadmin']."'>".$row['uni_descripcion']."</option>";
                }
                echo $html;
            }

        break;
    }

?>