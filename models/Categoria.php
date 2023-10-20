<?php
    class Categoria extends Conectar{

        public function ObtenerCat(){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "call sp_obtener_categorias";
            $sql = $conectar->prepare($sql);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>