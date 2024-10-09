<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Certifique-se de que o caminho está correto
include("config.php");

$mail = new PHPMailer(); // Passar `true` habilita exceções

try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = HOSTNAME; 
    $mail->Username = USERNAME; 
    $mail->Password = PASSWORD; 
    $mail->SMTPSecure = SMTPSECURE;
    $mail->Port = PORT;
    $mail->CharSet = 'UTF-8';
   
    // Configurações do remetente e destinatário
    $mail->setFrom('contato@fagner.dev.br', 'Fagner Romão');
    $mail->addAddress($_POST['email'], $_POST['name']); // Destinatário principal
    $mail->AddBCC('contato@fagner.dev.br', 'ReplyTo');
    
    // Conteúdo do email
    $mail->isHTML(true); // Definir formato de email para HTML
    $mail->addEmbeddedImage('assets/img/logoEmail.png', 'image_cid'); 
    $mail->AltBody = 'Este contato foi recebido com sucesso! Irei responder o mais breve possível! Obrigado!';
    $mail->Subject = 'Envio de Contato :: FAGNER.DEV.BR';
    $mail->Body = <<<EOT
    <!DOCTYPE html>
    <html>
    <head>
        <title>Solicitação de Contato</title>
    </head>
    <body>
        <b>::: Solicitação de Contato :::</b><br>
        <br>Olá <b>{$_POST['name']}</b>, estou feliz em receber seu contato.<br>Irei responder o mais breve possível!<br>
        <br>=================================================================</br>
        <br><b>Nome: </b>{$_POST['name']} 
        <br><b>Email: </b>{$_POST['email']}
        <br><b>Assunto: </b>{$_POST['subject']}
        <br><b>Mensagem: </b>{$_POST['message']}
        <br>=================================================================<br>     
        <br><b>Obrigado!!</b><br>
        <br><a href="https://fagner.dev.br"><img src="cid:image_cid"></a>
    </body>
    </html>   
    EOT;
   
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'OK';
    }    
} catch (Exception $e) {
    echo 'A mensagem não pôde ser enviada. Erro do Mailer:' . $mail->ErrorInfo;
}
?>