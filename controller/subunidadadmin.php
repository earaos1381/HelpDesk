<?php
require_once("../config/conexion.php");
require_once("../models/SubUnidadAdmin.php");

$subunidadadmin = new SubUnidadAdmin();

switch($_GET["op"]){
    case "combo":
        $id_uniadmin = $_POST['id_uniadmin'];
        $datos = $subunidadadmin->ObtenerSubuni($id_uniadmin);
        $html="";
        /* $html = "<option value='-1'>Selecciona una SubCategoria</option>" */;

        $html .= "<option label='Seleccionar'></option>";


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
