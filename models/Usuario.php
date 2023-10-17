<?php
    class Usuario extends Conectar{

        public function login(){
            $conectar=parent::conexion();
            parent::set_names();
            if(isset($_POST["enviar"])){

                $correo = $_POST["user_correo"];
                $password = $_POST["user_password"];
                $rol = $_POST["id_rol"];

                if(empty($correo) or empty($password)){
                    header("Location:".conectar::ruta()."index.php?m=2");
                    exit();
                }else{
                    $sql = "SELECT * FROM users WHERE user_correo = ? AND user_password = ? AND id_rol = ? AND estado = 1";
                    $stmt = $conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $password);
                    $stmt->bindValue(3, $rol);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    
                    if(is_array($resultado) and count($resultado) > 0){
                        $_SESSION["user_id"] = $resultado["user_id"];
                        $_SESSION["user_nom"] = $resultado["user_nom"];
                        $_SESSION["user_ap"] = $resultado["user_ap"];
                        $_SESSION["id_rol"] = $resultado["id_rol"];
                        header("Location:".Conectar::ruta()."view/Home/");
                        exit();
                    }else{
                        header("Location:".Conectar::ruta()."index.php?m=1");
                        exit();
                    }
                }
                
            }
        }

        public function crearUsuario($user_nom, $user_ap, $user_correo, $user_password, $id_rol){
            
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO mesaayuda.users (
                    user_id,
                    user_nom,
                    user_ap,
                    user_correo,
                    user_password,
                    id_rol,
                    fecha_create,
                    fecha_update,
                    fecha_elim,
                    estado) 
                    VALUES (NULL, ?, ?, ?, ?, ?, now(), NULL, NULL, '1');";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_nom);
            $sql->bindValue(2, $user_ap);
            $sql->bindValue(3, $user_correo);
            $sql->bindValue(4, $user_password);
            $sql->bindValue(5, $id_rol);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function actualizarUsuario($user_id, $user_nom, $user_ap, $user_correo, $user_password, $id_rol){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "UPDATE users SET
                    user_nom = ?,
                    user_ap = ?,
                    user_correo = ?,
                    user_password = ?,
                    id_rol = ?
                    WHERE user_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_nom);
            $sql->bindValue(2, $user_ap);
            $sql->bindValue(3, $user_correo);
            $sql->bindValue(4, $user_password);
            $sql->bindValue(5, $id_rol);
            $sql->bindValue(6, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function eliminarUsuario($user_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "UPDATE mesaayuda.users
                    SET estado = '0',
                        fecha_elim = now()
                    WHERE user_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuario(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT *
                    FROM users
                    WHERE estado = '1'";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioId($user_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT *
                    FROM users
                    WHERE user_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioTicketId($user_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) AS TOTAL
                    FROM tickets
                    WHERE user_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioTicketAbiertoId($user_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) AS TOTAL
                    FROM tickets
                    WHERE user_id = ? 
                    AND estado_ticket = 'Abierto'";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioTicketCerradoId($user_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) AS TOTAL
                    FROM tickets
                    WHERE user_id = ? 
                    AND estado_ticket = 'Cerrado'";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioGrafico($user_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT categorias.cat_descripcion as nom,COUNT(*) AS total
                FROM   tickets  JOIN  
                categorias ON tickets.id_categoria = categorias.cat_id  
                WHERE
                tickets.estado = 1
                AND tickets.user_id = ?
                GROUP BY 
                categorias.cat_descripcion 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }

?>