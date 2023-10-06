<?php
    class Categoria extends Conectar{

        public function ObtenerCat(){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM categorias WHERE estado = 1";
            $sql = $conectar->prepare($sql);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>