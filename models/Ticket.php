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

        public function ListarTicketPorUser($user_id){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT 
            tickets.id_ticket, 
            tickets.user_id, 
            tickets.id_categoria, 
            tickets.titulo_ticket, 
            tickets.descripcion, 
            users.user_nom, 
            users.user_ap, 
            categorias.cat_descripcion 
            FROM tickets  
            INNER JOIN categorias ON tickets.id_categoria = categorias.cat_id
            INNER JOIN users ON tickets.user_id = users.user_id
            WHERE tickets.estado = 1
            AND users.user_id = ?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }
?>