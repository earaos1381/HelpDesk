<?php
    require_once("../config/conexion.php");
    require_once("../models/Documento.php");
    
    $documento = new Documento();

    $key="yG(E_ZiC3e/=!5)s4MS6CCH4e\Q.l";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    switch($_GET["op"]){

        case "listar":    
            //DECIFRADO NO. TICKET
            $iv_dec = substr(base64_decode($_POST["ticket_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["ticket_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);


            $datos=$documento->obtenerDocTicket($decifrado);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = '<a href="../../public/document/'.$decifrado.'/'.$row["doc_nom"].'" target="_blank">'.$row["doc_nom"].'</a>';
                $sub_array[] = '<a type="button" href="../../public/document/'.$decifrado.'/'.$row["doc_nom"].'" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
    }
?>