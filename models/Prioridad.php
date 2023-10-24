<?php
    class Prioridad extends Conectar{

        public function ObtenerPrio(){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM prioridad WHERE estado = 1;";
            $sql = $conectar->prepare($sql);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>