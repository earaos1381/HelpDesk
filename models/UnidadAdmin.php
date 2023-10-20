<?php
    class UnidadAdmin extends Conectar{

        public function ObtenerUni(){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "call sp_obtener_uniAdmin";
            $sql = $conectar->prepare($sql);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>