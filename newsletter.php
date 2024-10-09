<?php
/* Configuração de envio do formulário de Inscrição
  Create: 29/09/2024
  Author: Fagner Romão
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 
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
    $mail->addAddress($_POST['email']); // Destinatário principal
    $mail->AddBCC('contato@fagner.dev.br', 'ReplyTo');
    
    // Conteúdo do email
    $mail->isHTML(true); // Definir formato de email para HTML
    $mail->addEmbeddedImage('assets/img/logoEmail.png', 'image_cid'); 
    $mail->AltBody = 'Este contato foi recebido com sucesso! Irei responder o mais breve possível! Obrigado!';
    $mail->Subject = 'Envio de Inscrição :: FAGNER.DEV.BR';
    $mail->Body = <<<EOT
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Solicitação de Inscrição</title>
                    </head>
                    <body>
                        <b>::: Solicitação de Inscrição :::</b><br>
                        <br>Olá, estou feliz em receber sua inscrição.<br>
                        <br>Irei notificar este email <b>{$_POST['email']}</b> sobre as novidades do site o mais breve possível!<br>
                        <br>    
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
    echo 'A mensagem não pôde ser enviada. Erro do Mailer:';// {$mail->ErrorInfo}";
   // $msg = 'A mensagem não pôde ser enviada. Erro do Mailer:  ' . $mail->ErrorInfo;
}
?>


