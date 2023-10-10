<?php
    class UnidadAdmin extends Conectar{

        public function ObtenerUni(){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM unidadesadmin WHERE estado = 1";
            $sql = $conectar->prepare($sql);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>