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
                    $sql = "SELECT * FROM users WHERE user_correo = ? AND id_rol = ? AND estado = 1;";
                    $stmt = $conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $rol);
                    $stmt->execute();
                    $resultado = $stmt->fetch();

                    if($resultado){
                        $textocifrado = $resultado["user_password"];

                        $key="mi_key_secret";
                        $cipher="aes-256-cbc";
                        $iv_dec = substr(base64_decode( $textocifrado), 0, openssl_cipher_iv_length($cipher));
                        $cifradoSinIV = substr(base64_decode( $textocifrado), openssl_cipher_iv_length($cipher));
                        $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
                        
                        if($decifrado==$password){
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
                
            }
        }

        public function crearUsuario($user_nom, $user_ap, $user_correo, $user_password, $id_rol){

            $key="mi_key_secret";
            $cipher="aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($user_password, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

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
            $sql->bindValue(4, $textoCifrado);
            $sql->bindValue(5, $id_rol);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        public function actualizarUsuario($user_nom, $user_ap, $user_correo, $user_password, $id_rol, $user_id,){

            $key="mi_key_secret";
            $cipher="aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($user_password, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $conectar=parent::conexion();
            parent::set_names();
            $sql = "UPDATE users SET
            user_nom = ?,
            user_ap = ?,
            user_correo = ?,
            user_password = ?,
            id_rol = ?
            WHERE user_id = ?;";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_nom);
            $sql->bindValue(2, $user_ap);
            $sql->bindValue(3, $user_correo);
            $sql->bindValue(4, $textoCifrado);
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

        public function actualizarPassUsuario($user_password, $user_id){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_actualizar_contraseña_user(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $user_password);
            $sql->bindValue(2, $user_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

/*         public function get_usuario_x_correo($usu_correo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario WHERE usu_correo=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_correo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_cambiar_contra_recuperar($usu_correo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE
                tm_usuario
                    SET
                usu_pass=CONCAT(SUBSTRING(MD5(RAND()),1,3),LPAD(FLOOR(RAND()*1000),3,'0'))
                    WHERE
                usu_correo=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_correo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function encriptar_nueva_contra($usu_id,$usu_pass){

            $key="mi_key_secret";
            $cipher="aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($usu_pass, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario set
                usu_pass = ?
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $textoCifrado);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } */
    }

?>