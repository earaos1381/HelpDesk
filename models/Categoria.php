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

        public function CrearCat($cat_descripcion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO categorias (cat_id, cat_descripcion, estado) VALUES (NULL,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_descripcion);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ActualizarCat($cat_id,$cat_descripcion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE categorias set
                cat_descripcion = ?
                WHERE
                cat_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_descripcion);
            $sql->bindValue(2, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function EliminarCat($cat_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE categorias SET
                estado = 0
                WHERE 
                cat_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ObtenerCatID($cat_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM categorias WHERE cat_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>