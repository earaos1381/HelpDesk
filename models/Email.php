<?php
require ('class.phpmailer.php');
include ("class.smtp.php");

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
            $categoria = $row["cat_descripcion"];
            $correo = $row["user_correo"];
        }

                $this->IsSMTP();
                $this->Host = 'smtp.office365.com';//Aqui el server
                $this->Port = 587;//Aqui el puerto 587

                $this->SMTPAuth = true;
                $this->Username = $this->gCorreo;
                $this->Password = $this->gContrasena;
                $this->From = $this->gCorreo;
                $this->SMTPSecure = 'tls';
                $this->FromName = $this->gCorreo = "Ticket Abierto #".$id;
                $this->CharSet = 'UTF8';
                $this->addAddress($correo);
                $this->WordWrap = 50;
                $this->IsHTML(true);
                $this->Subject = "Mesa de Ayuda - Ticket Abierto";
                
                $cuerpo = file_get_contents('../public/NuevoTicket.html'); 
                
                $cuerpo = str_replace("xnroticket", $id, $cuerpo);
                $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
                $cuerpo = str_replace("lblApUsu", $ap, $cuerpo);
                $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
                $cuerpo = str_replace("lblUniAd", $uniadmin, $cuerpo);
                $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        
                $this->Body = $cuerpo;
                $this->AltBody = strip_tags("Ticket Abierto");
                return $this->Send();
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
            $categoria = $row["cat_descripcion"];
            $correo = $row["user_correo"];
        }

                $this->IsSMTP();
                $this->Host = 'smtp.office365.com';//Aqui el server
                $this->Port = 587;//Aqui el puerto 587

                $this->SMTPAuth = true;
                $this->Username = $this->gCorreo;
                $this->Password = $this->gContrasena;
                $this->From = $this->gCorreo;
                $this->SMTPSecure = 'tls';
                $this->FromName = $this->gCorreo = "Ticket Cerrado #".$id;
                $this->CharSet = 'UTF8';
                $this->addAddress($correo);
                $this->WordWrap = 50;
                $this->IsHTML(true);
                $this->Subject = "Ticket Cerrado";
                
                $cuerpo = file_get_contents('../public/CerradoTicket.html'); 
                
                $cuerpo = str_replace("xnroticket", $id, $cuerpo);
                $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
                $cuerpo = str_replace("lblApUsu", $ap, $cuerpo);
                $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
                $cuerpo = str_replace("lblUniAd", $uniadmin, $cuerpo);
                $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        
                $this->Body = $cuerpo;
                $this->AltBody = strip_tags("Ticket Cerrado");
                return $this->Send();
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
            $categoria = $row["cat_descripcion"];
            $correo = $row["user_correo"];
        }

                $this->IsSMTP();
                $this->Host = 'smtp.office365.com';//Aqui el server
                $this->Port = 587;//Aqui el puerto 587

                $this->SMTPAuth = true;
                $this->Username = $this->gCorreo;
                $this->Password = $this->gContrasena;
                $this->From = $this->gCorreo;
                $this->SMTPSecure = 'tls';
                $this->FromName = $this->gCorreo = "Ticket Asignado #".$id;
                $this->CharSet = 'UTF8';
                $this->addAddress($correo);
                $this->WordWrap = 50;
                $this->IsHTML(true);
                $this->Subject = "Ticket Asignado";
                
                $cuerpo = file_get_contents('../public/AsignarTicket.html'); 
                
                $cuerpo = str_replace("xnroticket", $id, $cuerpo);
                $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
                $cuerpo = str_replace("lblApUsu", $ap, $cuerpo);
                $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
                $cuerpo = str_replace("lblUniAd", $uniadmin, $cuerpo);
                $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        
                $this->Body = $cuerpo;
                $this->AltBody = strip_tags("Ticket Asignado");
                return $this->Send();
    }

    /* public function recuperar_contrasena($usu_correo){
        $usuario = new Usuario();

        $usuario->get_cambiar_contra_recuperar($usu_correo);

        $datos = $usuario->get_usuario_x_correo($usu_correo);
        foreach ($datos as $row){
            $usu_id = $row["usu_id"];
            $usu_ape = $row["usu_ape"];
            $usu_nom = $row["usu_nom"];
            $correo = $row["usu_correo"];
            $usu_pass= $row["usu_pass"];
        }

        $this->IsSMTP();
        $this->Host = 'smtp.hostinger.com';
        $this->Port = 587;
        $this->SMTPAuth = true;
        $this->SMTPSecure = 'tls';

        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->setFrom($this->gCorreo, "Recuperar Contraseña");

        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->IsHTML(true);
        $this->Subject = "Recuperar Contraseña";
        
        $cuerpo = file_get_contents('../public/RecuperarContra.html'); 

        $cuerpo = str_replace("xusunom", $usu_nom, $cuerpo);
        $cuerpo = str_replace("xusuape", $usu_ape, $cuerpo);
        $cuerpo = str_replace("xnuevopass", $usu_pass, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Recuperar Contraseña");

        try{
            $this->Send();
            $usuario->encriptar_nueva_contra($usu_id,$usu_pass);
            return true;
        }catch(Exception $e){
            return false;
        }
    } */

}

?>