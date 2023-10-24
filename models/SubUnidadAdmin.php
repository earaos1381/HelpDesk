<?php
    class SubUnidadAdmin extends Conectar{

        public function ObtenerSubuni($id_uniadmin){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "call sp_obtener_subuniAdmin(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_uniadmin);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>