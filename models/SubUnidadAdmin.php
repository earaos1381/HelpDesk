<?php
    class SubUnidadAdmin extends Conectar{

        public function ObtenerSubuni($id_uniadmin){

            $conectar=parent::conexion();
            parent::set_names();

            /* $sql = "call sp_obtener_subuniAdmin(?)"; */
            $sql = "SELECT * FROM sub_unidadesadmin WHERE id_uniadmin = ? AND estado = 1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_uniadmin);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        public function ObtenerSubuniTodas(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            sub_unidadesadmin.subUni_id,
            sub_unidadesadmin.id_uniadmin,
            sub_unidadesadmin.subDescripcion,
            unidadesadmin.uni_descripcion
            FROM sub_unidadesadmin INNER JOIN
            unidadesadmin on sub_unidadesadmin.id_uniadmin = unidadesadmin.id_uniadmin
            WHERE sub_unidadesadmin.estado=1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function CrearSubuni($id_uniadmin,$subDescripcion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sub_unidadesadmin (subUni_id,id_uniadmin,subDescripcion,estado) VALUES (NULL,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_uniadmin);
            $sql->bindValue(2, $subDescripcion);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ActualizarSubuni($subUni_id,$id_uniadmin,$subDescripcion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sub_unidadesadmin SET
                id_uniadmin = ?,
                subDescripcion = ?
                WHERE
                subUni_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_uniadmin);
            $sql->bindValue(2, $subDescripcion);
            $sql->bindValue(3, $subUni_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function EliminarSubuni($subUni_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sub_unidadesadmin SET
                estado = 0
                WHERE 
                subUni_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $subUni_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ObtenerSubuniID($subUni_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sub_unidadesadmin WHERE subUni_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $subUni_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
    }
?>