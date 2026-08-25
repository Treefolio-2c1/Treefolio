<?php

require_once __DIR__ . "/../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviar_email($destinatario, $nome, $assunto, $mensagem)
{
    $mail = new PHPMailer(true);

    try {
        
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
        $mail->Host       = "smtp.gmail.com";       
        $mail->SMTPAuth   = true;
        $mail->Username   = "treefolio0@gmail.com";  
        $mail->Password   = "";    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->CharSet = "UTF-8";

        $mail->setFrom("treefolio0@gmail.com", "Treefolio");
        $mail->addAddress($destinatario, $nome);

        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem;
        $mail->AltBody = strip_tags($mensagem);

        $mail->send();

        return "OK";

    } catch (Exception $e) {
        return "Erro: " . $mail->ErrorInfo;
    }
}