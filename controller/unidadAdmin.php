<?php
    require_once("../config/conexion.php");
    require_once("../models/UnidadAdmin.php");
    
    $categoria = new UnidadAdmin();

    switch($_GET["op"]){
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