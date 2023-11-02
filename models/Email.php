<?php

require '../include/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("../config/conexion.php");
require_once("../Models/Ticket.php");
require_once("../Models/Usuario.php");


class Email extends PHPMailer{

    protected $gCorreo = 'cti.soporte.secoes@outlook.com';
    protected $gContrasena = 'Infr4W3b1.';

    public function ticket_abierto($ticket_id){

        $ticket = new Ticket();
        $datos = $ticket->ListarTicketPorID($ticket_id);
        foreach ($datos as $row){
            $id = $row["ticket_id"];
            $usu = $row["user_nom"];
            $ap = $row["user_ap"];
            $titulo = $row["titulo_ticket"];
            $uniadmin = $row["uni_descripcion"];
            $subuni = $row["subDescripcion"];
            $categoria = $row["cat_descripcion"];
            $correo = $row["user_correo"];
        }

                $this->IsSMTP();
                $this->Host = 'smtp.office365.com';//Aqui el server
                $this->Port = 587;//Aqui el puerto 587
                $this->SMTPAuth = true;
                $this->SMTPSecure = 'tls';

                $this->Username = $this->gCorreo;
                $this->Password = $this->gContrasena;
                $this->setFrom($this->gCorreo, "Ticket Abierto #".$id);

                $this->CharSet = 'UTF8';
                $this->addAddress($correo);
                $this->IsHTML(true);
                $this->Subject = "Mesa de Ayuda - Ticket Abierto";
                
                $cuerpo = file_get_contents('../public/NuevoTicket.html'); 
                
                $cuerpo = str_replace("xnroticket", $id, $cuerpo);
                $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
                $cuerpo = str_replace("lblApUsu", $ap, $cuerpo);
                $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
                $cuerpo = str_replace("lblUniAd", $uniadmin, $cuerpo);
                $cuerpo = str_replace("lblSubUni", $subuni, $cuerpo);
                $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        
                $this->Body = $cuerpo;
                $this->AltBody = strip_tags("Ticket Abierto");

                try{
                    $this->Send();
                    /* $usuario->encriptar_nueva_contra($usu_id,$usu_pass); */
                    return true;
                }catch(Exception $e){
                    return false;
                }
    }

    public function ticket_cerrado($ticket_id){

        $ticket = new Ticket();
        $datos = $ticket->ListarTicketPorID($ticket_id);
        foreach ($datos as $row){
            $id = $row["ticket_id"];
            $usu = $row["user_nom"];
            $ap = $row["user_ap"];
            $titulo = $row["titulo_ticket"];
            $uniadmin = $row["uni_descripcion"];
            $subuni = $row["subDescripcion"];
            $categoria = $row["cat_descripcion"];
            $correo = $row["user_correo"];
        }

                $this->IsSMTP();
                $this->Host = 'smtp.office365.com';//Aqui el server
                $this->Port = 587;//Aqui el puerto 587
                $this->SMTPAuth = true;
                $this->SMTPSecure = 'tls';

                $this->Username = $this->gCorreo;
                $this->Password = $this->gContrasena;
                $this->setFrom($this->gCorreo, "Ticket Cerrado #".$id);
                
                $this->CharSet = 'UTF8';
                $this->addAddress($correo);
                $this->IsHTML(true);
                $this->Subject = "Mesa de Ayuda - Ticket Cerrado";
                
                $cuerpo = file_get_contents('../public/CerradoTicket.html'); 
                
                $cuerpo = str_replace("xnroticket", $id, $cuerpo);
                $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
                $cuerpo = str_replace("lblApUsu", $ap, $cuerpo);
                $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
                $cuerpo = str_replace("lblUniAd", $uniadmin, $cuerpo);
                $cuerpo = str_replace("lblSubUni", $subuni, $cuerpo);
                $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        
                $this->Body = $cuerpo;
                $this->AltBody = strip_tags("Ticket Cerrado");
                try{
                    $this->Send();
                    /* $usuario->encriptar_nueva_contra($usu_id,$usu_pass); */
                    return true;
                }catch(Exception $e){
                    return false;
                }
    }

    public function ticket_asignado($ticket_id){

        $ticket = new Ticket();
        $datos = $ticket->ListarTicketPorID($ticket_id);
        foreach ($datos as $row){
            $id = $row["ticket_id"];
            $usu = $row["user_nom"];
            $ap = $row["user_ap"];
            $titulo = $row["titulo_ticket"];
            $uniadmin = $row["uni_descripcion"];
            $subuni = $row["subDescripcion"];
            $categoria = $row["cat_descripcion"];
            $correo = $row["user_correo"];
        }

                $this->IsSMTP();
                $this->Host = 'smtp.office365.com';//Aqui el server
                $this->Port = 587;//Aqui el puerto 587
                $this->SMTPAuth = true;
                $this->SMTPSecure = 'tls';

                $this->Username = $this->gCorreo;
                $this->Password = $this->gContrasena;
                $this->setFrom($this->gCorreo, "Ticket Asignado #".$id);
                
                $this->CharSet = 'UTF8';
                $this->addAddress($correo);
                $this->IsHTML(true);
                $this->Subject = "Mesa de Ayuda - Ticket Asignado";
                
                $cuerpo = file_get_contents('../public/AsignarTicket.html'); 
                
                $cuerpo = str_replace("xnroticket", $id, $cuerpo);
                $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
                $cuerpo = str_replace("lblApUsu", $ap, $cuerpo);
                $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
                $cuerpo = str_replace("lblUniAd", $uniadmin, $cuerpo);
                $cuerpo = str_replace("lblSubUni", $subuni, $cuerpo);
                $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        
                $this->Body = $cuerpo;
                $this->AltBody = strip_tags("Ticket Asignado");
                try{
                    $this->Send();
                    /* $usuario->encriptar_nueva_contra($usu_id,$usu_pass); */
                    return true;
                }catch(Exception $e){
                    return false;
                }
    }

    public function recuperar_contrasena($user_correo){
        $usuario = new Usuario();

        $usuario->cambiarContraRecuperar($user_correo);

        $datos = $usuario->obtenerUsuarioCorreo($user_correo);
        foreach ($datos as $row){
            $user_id = $row["user_id"];
            $user_ap = $row["user_ap"];
            $user_nom = $row["user_nom"];
            $correo = $row["user_correo"];
            $user_password= $row["user_password"];
        }

        $this->IsSMTP();
        $this->Host = 'smtp.office365.com';
        $this->Port = 587;
        $this->SMTPAuth = true;
        $this->SMTPSecure = 'tls';

        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->setFrom($this->gCorreo, "Recuperar Contraseña");

        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->IsHTML(true);
        $this->Subject = "Mesa de Ayuda - Recuperar Contraseña";
        
        $cuerpo = file_get_contents('../public/RecuperarContra.html'); 

        $cuerpo = str_replace("xusunom", $user_nom, $cuerpo);
        $cuerpo = str_replace("xusuape", $user_ap, $cuerpo);
        $cuerpo = str_replace("xnuevopass", $user_password, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Recuperar Contraseña");

        try{
            $this->Send();
            $usuario->encriptarNuevaContra($user_password,$user_id);
            return true;
        }catch(Exception $e){
            return false;
        }
    }

}

?>