<?php
    class Documento extends Conectar{
        public function insertar_documento($ticket_id, $doc_nom){
            $conectar=parent::conexion();
            $sql="INSERT INTO documento (id_documento, ticket_id, doc_nom, fecha_crea, estado)
                  VALUES (NULL,?,?, now(),1)";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$ticket_id);
            $sql->bindParam(2,$doc_nom);
            $sql->execute();
        }

        public function obtenerDocTicket($ticket_id){
            $conectar= parent::conexion();
            $sql="SELECT * FROM documento WHERE ticket_id=?";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$ticket_id);
            $sql->execute();
            return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
        }

    }
?>