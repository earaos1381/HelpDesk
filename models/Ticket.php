<?php
    class Ticket extends Conectar{

        public function CrearTicket($user_id, $id_uniadmin, $subUni_id, $id_categoria, $titulo_ticket, $descripcion, $id_prioridad){

            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_insertar_ticket(?,?,?,?,?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->bindValue(2, $id_uniadmin);
            $sql->bindValue(3, $subUni_id ? $subUni_id : null);
            $sql->bindValue(4, $id_categoria);
            $sql->bindValue(5, $titulo_ticket);
            $sql->bindValue(6, $descripcion);
            $sql->bindValue(7, $id_prioridad);
            $sql->execute();
            
            $sql1 = "SELECT last_insert_id() AS 'ticket_id'";
            $sql1 = $conectar->prepare($sql1);
            $sql1->execute();
            return $resultado = $sql1->fetchAll(pdo::FETCH_ASSOC);
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

        public function ListarTicket($id_rol){
            $conectar= parent::conexion();
            parent::set_names();
            $sql = "SELECT
            tickets.ticket_id, 
            tickets.user_id,
            tickets.id_uniadmin,
            tickets.subUni_id,
            tickets.id_categoria, 
            tickets.titulo_ticket, 
            tickets.descripcion,
            tickets.estado_ticket, 
            tickets.fecha_create,
            tickets.user_asig,
            tickets.fech_asig, 
            tickets.fech_cierre,
            tickets.id_prioridad,
            users.user_nom, 
            users.user_ap, 
            categorias.cat_descripcion,
            unidadesadmin.uni_descripcion,
            sub_unidadesadmin.subDescripcion,
            prioridad.prio_descrip
            FROM tickets
            INNER JOIN unidadesadmin ON tickets.id_uniadmin = unidadesadmin.id_uniadmin
            LEFT JOIN sub_unidadesadmin ON tickets.subUni_id = sub_unidadesadmin.subUni_id
            INNER JOIN categorias ON tickets.id_categoria = categorias.cat_id
            INNER JOIN prioridad ON tickets.id_prioridad = prioridad.id_prioridad
            INNER JOIN users ON tickets.user_id = users.user_id
            WHERE tickets.estado = 1";

            if ($id_rol == 2) {
                $sql .= " AND tickets.user_asig = :user_id";
            }

            $sql = $conectar->prepare($sql);

            if ($id_rol == 2) {
                $sql->bindParam(":user_id", $_SESSION["user_id"], PDO::PARAM_INT);
            }

            $sql->execute();
            return $resultado = $sql->fetchAll();
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

        public function InsertarTicketDetalleReabrir($ticket_id,$user_id){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="call sp_insertar_ticketDetalle_reabrir(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->bindValue(2, $user_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
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

        public function reabrirTicket($ticket_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_reabrir_ticket(?)";
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

        public function obtenerTotalSoportePorUsuario($user_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) AS TOTAL
                    FROM tickets
                    WHERE user_asig = :user_id";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
        
        public function obtenerTotalAbiertoSoportePorUsuario($user_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) AS TOTAL
                    FROM tickets
                    WHERE estado_ticket = 'Abierto' AND user_asig = :user_id";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
        
        public function obtenerTotalCerradoSoportePorUsuario($user_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) AS TOTAL
                    FROM tickets
                    WHERE estado_ticket = 'Cerrado' AND user_asig = :user_id";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
        
        public function obtenerGraficoSoportePorUsuario($user_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT categorias.cat_descripcion as nom, COUNT(*) AS total
                    FROM tickets
                    JOIN categorias ON tickets.id_categoria = categorias.cat_id
                    WHERE tickets.estado = 1 AND tickets.user_asig = :user_id
                    GROUP BY categorias.cat_descripcion 
                    ORDER BY total DESC";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function filtrarTicket($titulo_ticket, $id_categoria, $id_prioridad, $id_rol, $user_id) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT 
                    tickets.ticket_id, 
                    tickets.user_id,
                    tickets.id_uniadmin,
                    tickets.subUni_id,
                    tickets.id_categoria, 
                    tickets.titulo_ticket, 
                    tickets.descripcion,
                    tickets.estado_ticket, 
                    tickets.fecha_create,
                    tickets.user_asig,
                    tickets.fech_asig,
                    tickets.fech_cierre,
                    tickets.id_prioridad,
                    users.user_nom, 
                    users.user_ap, 
                    categorias.cat_descripcion,
                    unidadesadmin.uni_descripcion,
                    sub_unidadesadmin.subDescripcion,
                    prioridad.prio_descrip
                    FROM tickets
                    INNER JOIN unidadesadmin ON tickets.id_uniadmin = unidadesadmin.id_uniadmin
                    LEFT JOIN sub_unidadesadmin ON tickets.subUni_id = sub_unidadesadmin.subUni_id
                    INNER JOIN categorias ON tickets.id_categoria = categorias.cat_id
                    INNER JOIN prioridad ON tickets.id_prioridad = prioridad.id_prioridad
                    INNER JOIN users ON tickets.user_id = users.user_id
                    WHERE tickets.estado = 1";
        
            $params = array();
        
            if (!empty($titulo_ticket)) {
                $sql .= " AND tickets.titulo_ticket LIKE :titulo_ticket";
                $params[":titulo_ticket"] = "%$titulo_ticket%";
            }
            if (!empty($id_categoria)) {
                $sql .= " AND tickets.id_categoria = :id_categoria";
                $params[":id_categoria"] = $id_categoria;
            }
            if (!empty($id_prioridad)) {
                $sql .= " AND tickets.id_prioridad = :id_prioridad";
                $params[":id_prioridad"] = $id_prioridad;
            }
        
            if ($id_rol == 2) {
                $sql .= " AND tickets.user_asig = :user_id";
                $params[":user_id"] = $user_id;
            }
        
            $sql = $conectar->prepare($sql);
        
            $sql->execute($params);
        
            return $resultado = $sql->fetchAll();
        }
        
        
        
    }
?>