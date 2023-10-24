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

        public function CrearPrio($prio_descrip){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO prioridad (id_prioridad, prio_descrip, estado) VALUES (NULL,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_descrip);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ActualizarPrio($id_prioridad,$prio_descrip){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE prioridad set
                prio_descrip = ?
                WHERE
                id_prioridad = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_descrip);
            $sql->bindValue(2, $id_prioridad);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function EliminarPrio($id_prioridad){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE prioridad SET
                estado = 0
                WHERE 
                id_prioridad = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_prioridad);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ObtenerPrioID($id_prioridad){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM prioridad WHERE id_prioridad = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_prioridad);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


    }
?>