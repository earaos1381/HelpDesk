<?php
require_once("../config/conexion.php");
require_once("../models/SubUnidadAdmin.php");

$subunidadadmin = new SubUnidadAdmin();

switch($_GET["op"]){
    case "combo":
        $id_uniadmin = $_POST['id_uniadmin'];
        $datos = $subunidadadmin->ObtenerSubuni($id_uniadmin);
        $html = "";

        if(is_array($datos) == true and count($datos) > 0){
            $html = "<option>Selecciona una Subcategoria</option>";
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
