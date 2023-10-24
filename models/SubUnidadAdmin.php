<?php
    class SubUnidadAdmin extends Conectar{

        public function ObtenerSubuni($id_uniadmin){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM sub_unidadesadmin WHERE id_uniadmin = ? AND estado = 1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_uniadmin);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>