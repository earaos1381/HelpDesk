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

    }

?>