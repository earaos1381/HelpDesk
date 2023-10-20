<?php
    class Ticket extends Conectar{

        public function CrearTicket($user_id, $id_uniadmin, $id_categoria, $titulo_ticket, $descripcion){

            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_insertar_ticket(?,?,?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->bindValue(2, $id_uniadmin);
            $sql->bindValue(3, $id_categoria);
            $sql->bindValue(4, $titulo_ticket);
            $sql->bindValue(5, $descripcion);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        public function ListarTicketPorUser($user_id){

            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_listar_ticket_usuario(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        public function ListarTicketPorID($ticket_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_listar_ticketID(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function ListarTicket(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql = "call sp_listar_ticket";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function DetalleTicket($ticket_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_detalle_ticket(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function InsertarTicketDetalle($ticket_id, $user_id, $descripcion){

            $conectar=parent::conexion();
            parent::set_names(); 
            $sql = "call sp_insertar_ticketDetalle(?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->bindValue(2, $user_id);
            $sql->bindValue(3, $descripcion);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        public function InsertarTicketDetalleCerrado($ticket_id, $user_id){

            $conectar=parent::conexion();
            parent::set_names(); 
            $sql = "call sp_insertar_ticketDetalle_cerrado(?,?)";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->bindValue(2, $user_id);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        public function actualizarTicket($ticket_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_actualizar_ticket(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function actualizarTicketAsignacion($user_asig ,$ticket_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_actualizar_ticket_asignacion(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $user_asig);
            $sql->bindValue(2, $ticket_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function obtenerTicket(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_obtener_ticket";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerTicketAbierto(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_obtener_ticket_abierto";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerTicketCerrado(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_obtener_ticket_cerrado";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerTicketGrafico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_obtener_ticket_grafico";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>