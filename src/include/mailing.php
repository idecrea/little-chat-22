<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviar_correo($from,$to,$to_name,$body,$subject){
    // Load Composer's autoloader
    require 'vendor/autoload.php';
    
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output (2 by default)
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'localhost';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = false;                                   // Enable SMTP authentication
        $mail->Username   = '';        // SMTP username
        $mail->Password   = '';                               // SMTP password
        $mail->SMTPSecure = false;                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 1025;                                    // TCP port to connect to
        $mail->CharSet    = 'UTF-8';
        
        //Recipients
        $mail->setFrom($from, 'Mailer');
        $mail->addAddress($to, $to_name);     // Add a recipient
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        //Enviamos el correo
        $mail->send();
        
        
        return true;
    } catch (Exception $e) {
        return false;
    }
}