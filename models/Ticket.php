<?php
    class Ticket extends Conectar{

        public function CrearTicket($user_id, $id_categoria, $titulo_ticket, $descripcion){

            $conectar=parent::conexion();
            parent::set_names();

            $sql = "INSERT INTO mesaayuda.tickets (user_id, id_categoria, 
                    titulo_ticket, 
                    descripcion, 
                    estado_ticket, 
                    fecha_create, estado) 
                    VALUES (?, ?, ?, ?, 'Abierto',now(), 1);";

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
                    tickets.ticket_id, 
                    tickets.user_id, 
                    tickets.id_categoria, 
                    tickets.titulo_ticket, 
                    tickets.descripcion,
                    tickets.estado_ticket, 
                    tickets.fecha_create, 
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

        public function ListarTicketPorID($ticket_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT 
                    tickets.ticket_id, 
                    tickets.user_id, 
                    tickets.id_categoria, 
                    tickets.titulo_ticket, 
                    tickets.descripcion,
                    tickets.estado_ticket, 
                    tickets.fecha_create, 
                    users.user_nom, 
                    users.user_ap,
                    categorias.cat_descripcion 
                    FROM tickets  
                    INNER JOIN categorias ON tickets.id_categoria = categorias.cat_id
                    INNER JOIN users ON tickets.user_id = users.user_id
                    WHERE tickets.estado = 1
                    AND tickets.ticket_id = ?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function ListarTicket(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql = "SELECT
                    tickets.ticket_id, 
                    tickets.user_id, 
                    tickets.id_categoria, 
                    tickets.titulo_ticket, 
                    tickets.descripcion,
                    tickets.estado_ticket, 
                    tickets.fecha_create, 
                    users.user_nom, 
                    users.user_ap,
                    categorias.cat_descripcion 
                    FROM tickets
                    INNER JOIN categorias ON tickets.id_categoria = categorias.cat_id
                    INNER JOIN users ON tickets.user_id = users.user_id
                    WHERE tickets.estado = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function DetalleTicket($ticket_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT 
                    detalleticket.detalleticket_id,
                    detalleticket.descripcion,
                    detalleticket.fecha_create,
                    users.user_nom,
                    users.user_ap,
                    users.id_rol
                    FROM detalleticket
                    INNER JOIN users ON  detalleticket.user_id = users.user_id
                    WHERE ticket_id = ?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function InsertarTicketDetalle($detalleticket_id, $user_id, $descripcion){

            $conectar=parent::conexion();
            parent::set_names(); 
            $sql = "INSERT INTO mesaayuda.detalleticket (
                    detalleticket_id,
                    ticket_id, 
                    user_id, 
                    descripcion, 
                    fecha_create, 
                    estado) 
                    VALUES (NULL, ?, ?, ?, now(), '1')";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $detalleticket_id);
            $sql->bindValue(2, $user_id);
            $sql->bindValue(3, $descripcion);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        public function actualizarTicket($ticket_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tickets 
                SET	
                    tickets.estado_ticket = 'Cerrado'
                where
                    tickets.ticket_id = ? ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>