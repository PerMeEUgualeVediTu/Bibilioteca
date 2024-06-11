<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 4;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'provamail772007@gmail.com';                 // SMTP username
    $mail->Password   = 'yvkj yihl bmvc zuss';                        // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable SSL encryption
    $mail->Port       = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('provamail772007@gmail.com', 'Biblioteca');
    $mail->addAddress('gatti8758@gmail.com', 'Nuovo Utente');     // Add a recipient

    //$mail->SMTPOptions = array(
    //    'ssl' => array(
    //        'verify_peer' => false,
    //        'verify_peer_name' => false,
    //        'allow_self_signed' => true
    //    )
    //);

    // Content
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'OTP';
    $mail->Body    = '0889';
    $mail->AltBody = '0112';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
