<?php
    require_once("../config/conexion.php");
    require_once("../models/Categoria.php");
    
    $categoria = new Categoria();

    switch($_GET["op"]){
        case "combo":
            $datos = $categoria->ObtenerCat();
            if(is_array($datos) == true and count($datos) > 0){
                
                $html = "<option>Selecciona una Categoria</option>";
                foreach($datos as $row)
                {
                    $html.= "<option value ='".$row['cat_id']."'>".$row['cat_descripcion']."</option>";
                }
                echo $html;
            }

        break;
    }

?>