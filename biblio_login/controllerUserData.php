<?php 
session_start();
require "connection.php";
$email = "";
$name = "";
$errors = array();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

//if user signup button
if(isset($_POST['signup'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    if($password !== $cpassword){
        $errors['password'] = "La password di conferma non corrisponde!";
    }
    $email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);

    // Controllo se l'email finisce con @didattica.liceogrigoletti.edu.it
    if (!preg_match('/@didattica\.liceogrigoletti\.edu\.it$/', $email)) {
        $errors['email'] = "È consentita la registrazione solo con il proprio account istituzionale @didattica.liceogrigoletti.edu.it";
    }
    

    if(mysqli_num_rows($res) > 0){
        $errors['email'] = "Un account con questa email esiste già. Vai alla sezione Login.";
    }

    if(count($errors) === 0){
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(1111, 9999);
        $status = "notverified";
        $insert_data = "INSERT INTO usertable (name, email, password, code, status)
                        values('$name', '$email', '$encpass', '$code', '$status')";
        $data_check = mysqli_query($con, $insert_data);
        if($data_check){
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'biblioteca@didattica.liceogrigoletti.edu.it';                 // SMTP username
                $mail->Password   = 'sajvjdwvhohsfskx';                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable SSL encryption
                $mail->Port       = 465;                                    // TCP port to connect to
            
                //Recipients
                $mail->setFrom('biblioteca@didattica.liceogrigoletti.edu.it', 'Biblioteca Liceo Grigoletti');
                $mail->addAddress($email);     // Add a recipient
            
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            
                // Content
                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = 'Attivazione Account';
                $mail->Body = "
                    <!DOCTYPE html>
                    <html lang='it'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                line-height: 1.6;
                                color: #333;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                border: 1px solid #ddd;
                                border-radius: 10px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            }
                            .header {
                                text-align: center;
                                padding-bottom: 20px;
                            }
                            .header h1 {
                                margin: 0;
                                color: red;
                            }
                            .content {
                                padding: 20px;
                            }
                            .code {
                                font-size: 1.3em;
                                color: red;
                                font-weight: bold;
                            }
                            .footer {
                                margin-top: 20px;
                                font-size: 0.9em;
                                color: #777;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h1>Biblioteca Grigoletti</h1>
                                </br>
                                <h1>Attivazione Account</h1>
                            </div>
                            <div class='content'>
                                <p>Salve <strong>$email</strong>,</p>
                                <p>Abbiamo ricevuto la tua richiesta di un codice monouso per <strong>attivare il tuo account</strong>.</p>
                                <p class='code'>Il tuo codice monouso è: $code</p>
                                <p>Se non sei stato tu a richiedere questo codice, ignora semplicemente questa e-mail. Un altro utente potrebbe avere digitato il tuo indirizzo e-mail per errore.</p>
                                <p>Attivando il tuo account potrai accedere a tutte le funzionalità del sito riservate agli utenti iscritti: potrai sfogliare il catalogo, prendere in prestito dei libri, restituirli e molto altro!</p>
                                <p>A presto,</p>
                                <p>Il team di biblioteca_grigoletti</p>
                            </div>
                            <div class='footer'>
                                <p>Per qualsiasi problema o domanda, non esitare a contattarci.</p>
                            </div>
                        </div>
                    </body>
                    </html>";

                $mail->AltBody = "Salve $email,\n\nAbbiamo ricevuto la tua richiesta di un codice monouso per attivare il tuo account.\n\nIl tuo codice monouso è: $code\n\nSe non sei stato tu a richiedere questo codice, ignora semplicemente questa e-mail. Un altro utente potrebbe avere digitato il tuo indirizzo e-mail per errore.\n\nAttivando il tuo account potrai accedere a tutte le funzionalità del sito riservate agli utenti iscritti: potrai sfogliare il catalogo, prendere in prestito dei libri, restituirli e molto altro!\n\nA presto,\nIl team di biblioteca_grigoletti\n\nPer qualsiasi problema o domanda, non esitare a contattarci.";
                $mail->send();

                $info = "Abbiamo inviato un codice di verifica alla tua email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            }catch (Exception $e){
                $errors['otp-error'] = "Errore durante l'invio del codice!";
                echo "Impossibile inviare il messaggio. Mailer Error: {$mail->ErrorInfo}";
            }

        }else{
            $errors['db-error'] = "Errore durante l'inserimento dei dati nel database!";
        }
    }
}

    //if user click verification code submit button
    if(isset($_POST['check'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $code = 0;
            $status = 'verified';
            $update_otp = "UPDATE usertable SET code = $code, status = '$status' WHERE code = $fetch_code";
            $update_res = mysqli_query($con, $update_otp);
            if($update_res){
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                header('location: home.php');
                exit();
            }else{
                $errors['otp-error'] = "Errore durante il caricamento del codice!";
            }
        }else{
            $errors['otp-error'] = "Hai inserito un codice errato!";
        }
    }

    //if user click login button
    if(isset($_POST['login'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $check_email = "SELECT * FROM usertable WHERE email = '$email'";
        $res = mysqli_query($con, $check_email);
        if(mysqli_num_rows($res) > 0){
            $fetch = mysqli_fetch_assoc($res);
            $fetch_pass = $fetch['password'];
            if(password_verify($password, $fetch_pass)){
                $_SESSION['email'] = $email;
                $status = $fetch['status'];
                if($status == 'verified'){
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    header('location: home.php');
                }else{
                    $info = "Sembra che tu non abbia ancora verificato la tua email - $email";
                    $_SESSION['info'] = $info;
                    header('location: user-otp.php');
                }
            }else{
                $errors['email'] = "Email o password errati!";
            }
        }else{
            $errors['email'] = "Sembra che tu non sia ancora membro! Clicca sul link in basso per iscriverti.";
        }
    }

    //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $check_email = "SELECT * FROM usertable WHERE email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(1111, 9999);
            $insert_code = "UPDATE usertable SET code = $code WHERE email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'biblioteca@didattica.liceogrigoletti.edu.it';                  // SMTP username
                    $mail->Password   = 'sajvjdwvhohsfskx';                     // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable SSL encryption
                    $mail->Port       = 465;                                    // TCP port to connect to
                
                    //Recipients
                    $mail->setFrom('biblioteca@didattica.liceogrigoletti.edu.it', 'Biblioteca Liceo Grigoletti');
                    $mail->addAddress($email);     // Add a recipient
                
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                
                    // Content
                    $mail->isHTML(true);                                        // Set email format to HTML
                    $mail->Subject = 'Reset della Password';
                    $mail->Body = "
                        <!DOCTYPE html>
                        <html lang='it'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    line-height: 1.6;
                                    color: #333;
                                }
                                .container {
                                    max-width: 600px;
                                    margin: 0 auto;
                                    padding: 20px;
                                    border: 1px solid #ddd;
                                    border-radius: 10px;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                }
                                .header {
                                    text-align: center;
                                    padding-bottom: 20px;
                                }
                                .header h1 {
                                    margin: 0;
                                    color: red;
                                }
                                .content {
                                    padding: 20px;
                                }
                                .code {
                                    font-size: 1.3em;
                                    color: red;
                                    font-weight: bold;
                                }
                                .footer {
                                    margin-top: 20px;
                                    font-size: 0.9em;
                                    color: #777;
                                }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <div class='header'>
                                    <h1>Biblioteca Grigoletti</h1>
                                    </br>
                                    <h1>Reset della Password</h1>
                                </div>
                                <div class='content'>
                                    <p>Salve <strong>$email</strong>,</p>
                                    <p>Abbiamo ricevuto la tua richiesta di <strong>reset della password</strong> per il tuo account.</p>
                                    <p class='code'>Il tuo codice per resettare la password è: $code</p>
                                    <p>Se non sei stato tu a richiedere questo reset, ignora semplicemente questa e-mail. Un altro utente potrebbe avere digitato il tuo indirizzo e-mail per errore.</p>
                                    <p>Utilizza questo codice per resettare la tua password e poter nuovamente accedere a tutte le funzionalità del sito riservate agli utenti iscritti: potrai sfogliare il catalogo, prendere in prestito dei libri, restituirli e molto altro!</p>
                                    <p>A presto,</p>
                                    <p>Il team di biblioteca_grigoletti</p>
                                </div>
                                <div class='footer'>
                                    <p>Per qualsiasi problema o domanda, non esitare a contattarci.</p>
                                </div>
                            </div>
                        </body>
                        </html>";
                    
                    $mail->AltBody = "Salve $email,\n\nAbbiamo ricevuto la tua richiesta di reset della password per il tuo account.\n\nIl tuo codice per resettare la password è: $code\n\nSe non sei stato tu a richiedere questo reset, ignora semplicemente questa e-mail. Un altro utente potrebbe avere digitato il tuo indirizzo e-mail per errore.\n\nUtilizza questo codice per resettare la tua password e poter nuovamente accedere a tutte le funzionalità del sito riservate agli utenti iscritti: potrai sfogliare il catalogo, prendere in prestito dei libri, restituirli e molto altro!\n\nA presto,\nIl team di biblioteca_grigoletti\n\nPer qualsiasi problema o domanda, non esitare a contattarci.";
                    $mail->send();
                    

                    $info = "Abbiamo inviato un codice per reimpostare la password alla tua email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }catch (Exception $e){
                    $errors['otp-error'] = "Errore durante l'invio del codice!";
                    echo "Impossibile inviare il messaggio. Mailer Error: {$mail->ErrorInfo}";
                }

            }else{
                $errors['db-error'] = "Qualcosa è andato storto!";
            }
        }else{
            $errors['email'] = "Questo indirizzo email non esiste!";
        }
    }

    //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Crea una nuova password che non utilizzerai su nessun altro sito.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "Hai inserito un codice errato!";
        }
    }

    //if user click change password button
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Confirm password not matched!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $update_pass = "UPDATE usertable SET code = $code, password = '$encpass' WHERE email = '$email'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
                $info = "La tua password è cambiata. Ora puoi accedere con la tua nuova password.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
            }else{
                $errors['db-error'] = "Impossibile modificare la password!";
            }
        }
    }
    
    //if login now button click
    if(isset($_POST['login-now'])){
        header('Location: login-user.php');
    }
?>