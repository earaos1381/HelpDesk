<?php
    class Notificacion extends Conectar{

        public function ObtenerNotificacionPorUsuario($user_id){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM notificacion WHERE user_id = ? AND estado = 2 LIMIT 1;";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        public function ObtenerNotificacionPorUsuario2($user_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM notificacion WHERE user_id = ? AND estado != 0";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ContarNotificacionPorUsuario2($user_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) FROM notificacion WHERE user_id = ? AND estado != 0;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ActualizarNotificacionEstado($not_id){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "UPDATE notificacion SET estado = 1 WHERE not_id = ?;";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $not_id);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        public function ActualizarNotificacionEstadoLeido($not_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE notificacion SET estado = 0 WHERE not_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $not_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        

    }
?>