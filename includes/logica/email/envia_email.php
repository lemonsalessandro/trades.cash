<?php
//identificação para a chamada da classe

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

function enviaEmail($email, $mensagem, $assunto, $link){
    // Instanciando a classe
    $mail = new PHPMailer();

    // Habilitando SMTP	
    $mail->isSMTP();

    // Habilitando tranferêcia segura 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    // Pode ser: 0 = não exibe erros, 1 = exibe erros e mensagens, 2 = apenas mensagens	

    $mail->SMTPDebug = 0; // Debug

    // Habilitando autenticação	
    $mail->SMTPAuth = true;

    // Configurações para utilização do SMTP do Gmail 

    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587; // porta gmail
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ]
    ];

    $mail->Username = 'alessandrolemons.dev@gmail.com'; ////Usuário para autenticação 
    $mail->Password = 'mrgpnacpcxtwqjar'; //senha autenticação

    // Remetente da mensagem - sempre usar o mesmo usuário da autenticação  
    $mail->setFrom('alessandrolemons.dev@gmail.com','Trades.Cash');

    // Endereço de destino do email
    $mail->addAddress($email);

    $mail->CharSet = "utf-8";
    
    // Assunto e Corpo do email
    $mail->Subject = $assunto;
    $mail->Body = $mensagem;
    $mail->isHTML(true);

// Enviando o email
    if (!$mail->send()) {
        $retorno=false;
    } else {
        $retorno= $mensagem;
    }
    return $retorno;
}
?>