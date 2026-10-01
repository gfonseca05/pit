<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

function sendEmail($address, $name, $code)
{
    $arquivoConfig = __DIR__ . '/mail_config.php';
    if (!file_exists($arquivoConfig)) {
        echo 'Envio de email não configurado: crie database/PHPMailer/mail_config.php a partir do mail_config.example.php';
        return;
    }
    $config = require $arquivoConfig;

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = $config['host']; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = $config['username']; //SMTP username
        $mail->Password = $config['password']; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
        $mail->Port = $config['port']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($address, $name); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Mensagem Equipe Pool Care';
        $mail->Body = 'Informe este código na tela de recuperar senha, não o compartilhe com ninguém: ' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8');

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        echo "Não foi possível enviar o email.";
    }
}