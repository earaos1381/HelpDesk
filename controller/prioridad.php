<?php
    require_once("../config/conexion.php");
    require_once("../models/Prioridad.php");
    
    $prioridad = new Prioridad();

    switch($_GET["op"]){
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