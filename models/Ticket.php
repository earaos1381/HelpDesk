<?php
    class Ticket extends Conectar{

        public function CrearTicket($user_id, $id_categoria, $titulo_ticket, $descripcion){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "INSERT INTO mesaayuda.tickets (user_id, id_categoria, titulo_ticket, descripcion, estado) 
                    VALUES (?, ?, ?, ?, 1);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->bindValue(2, $id_categoria);
            $sql->bindValue(3, $titulo_ticket);
            $sql->bindValue(4, $descripcion);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>