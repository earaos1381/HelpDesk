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
                    $sql = "call sp_login(?,?,?)";
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
            $sql = "call sp_insertar_usuario(?,?,?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_nom);
            $sql->bindValue(2, $user_ap);
            $sql->bindValue(3, $user_correo);
            $sql->bindValue(4, $user_password);
            $sql->bindValue(5, $id_rol);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function actualizarUsuario($user_nom, $user_ap, $user_correo, $user_password, $id_rol, $user_id,){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_actualizar_usuario(?,?,?,?,?,?)";
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
            $sql = "call sp_eliminar_usuario(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuario(){
            $conectar=parent::conexion();
            parent::set_names();
                $sql = "call sp_listar_usuario";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioPorRol(){//para obtener solo los roles de soporte
            $conectar=parent::conexion();
            parent::set_names();
                $sql = "call sp_listar_usuario_roll";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioId($user_id){
            $conectar=parent::conexion();
            parent::set_names();
                $sql = "call sp_listar_usuarioID(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioTicketId($user_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_obtener_usuario_ticketID(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioTicketAbiertoId($user_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_obtener_usuario_ticketID_abierto(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioTicketCerradoId($user_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "call sp_obtener_usuario_ticketID_cerrado(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function obtenerUsuarioGrafico($user_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_obtener_usuario_grafico(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $user_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }

?>