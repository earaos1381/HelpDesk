<?php
    require_once("../config/conexion.php");
    require_once("../models/Email.php");

    $email = new Email();

    $key="yG(E_ZiC3e/=!5)s4MS6CCH4e\Q.l";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    switch ($_GET["op"]) {
        case "ticket_abierto":
            $email->ticket_abierto($_POST["ticket_id"]);
        break;

        case "ticket_cerrado":

            //DECIFRADO NO. TICKET
            $iv_dec = substr(base64_decode($_POST["ticket_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["ticket_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $email->ticket_cerrado($decifrado);
        break;

        case "ticket_asignado":
            $email->ticket_asignado($_POST["ticket_id"]);
        break;

        case "recuperar_contra":
            $email->recuperar_contrasena($_POST["user_correo"]);
        break;
    }
?>