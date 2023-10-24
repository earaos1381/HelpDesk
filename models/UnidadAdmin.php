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
        
        public function CrearUni($uni_descripcion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO unidadesadmin (id_uniadmin, uni_descripcion, fecha_create,estado) VALUES (NULL,?, now(), '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $uni_descripcion);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ActualizarUni($id_uniadmin,$uni_descripcion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE unidadesadmin set
                uni_descripcion = ?
                WHERE
                id_uniadmin = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $uni_descripcion);
            $sql->bindValue(2, $id_uniadmin);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function EliminarUni($id_uniadmin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE unidadesadmin SET
                estado = 0
                WHERE 
                id_uniadmin = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_uniadmin);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ObtenerUniID($id_uniadmin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM unidadesadmin WHERE id_uniadmin = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_uniadmin);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>