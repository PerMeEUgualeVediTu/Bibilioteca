<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function is_registred ( $mail ) {
    try {
		require "config.php";
		$connection = new PDO($dsn, $username, $password, $options);
		// check
		$sql = "SELECT * FROM persona
				WHERE persona.E_mail = :MAIL";

		$statement = $connection->prepare($sql);
		$statement->bindParam(':MAIL', $mail, PDO::PARAM_STR);
		$statement->execute ( );
		$Books = $statement->fetchAll();

       // if there are no records you can do the prenotation
		if ( sizeof ( $Books ) == 0 ) { echo "false"; } 
        else { echo "true"; }
	} catch(PDOException $error) 
	{ echo $error->getMessage(); }
}

function register ( $MAIL, $PSWD ) {
    // send otp
    require 'phpmailer/vendor/autoload.php';

    try  {
		require "config.php";
		$connection = new PDO($dsn, $username, $password, $options);
		// $sql = "INSERT INTO Users ( User_name, E_mail, Password_hash, Register_date, User_icon, Access_level ) VALUES ( :USR , :MAIL , :PSW , :REGIS , :ICON , :ACCES )";
        $sql = "INSERT INTO persona ( nome, cognome, E_mail, Password_hash, Password_salt, Register_date, User_icon ) VALUES ( :NOME, :COGNOME, :MAIL, :PSWD, :SALT, :DATE, :ICON )";

		$REGIS = time();

        /*
		$ICON = hash("MD5",$USR . "profile image");
		// creating user folder

		$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/people/" . $USR ."/";
		echo($target_dir . " " . $USR . "<br>");
		mkdir($target_dir);

		// save name in hash MD5
		$target_file = $target_dir . $ICON;
		echo ($target_file);
		$target_temp = $_FILES["Profile_pick"]["tmp_name"];

		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$uploadOk = 1;

		// Check file size
		if ($_FILES["Profile_pick"]["size"] > 500000) {
			echo "<br>Sorry, your file is too large.";
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "<br>Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if ( move_uploaded_file($_FILES["Profile_pick"]["tmp_name"], $target_file)) {
				echo "<br>The file ". htmlspecialchars( basename( $_FILES["Profile_pick"]["name"])). " has been uploaded.";
			} else {
				echo "<br>Sorry, there was an error uploading your file.<br>";
			}
		}*/
        echo"c";
		$statement = $connection->prepare($sql);
		$statement->bindParam(':NOME', $MAIL, PDO::PARAM_STR);
		$statement->bindParam(':COGNOME', $MAIL, PDO::PARAM_STR);
		$statement->bindParam(':MAIL', $MAIL, PDO::PARAM_STR);
        echo"c";
		$statement->bindParam(':PSWD', hash("sha256",$PSWD), PDO::PARAM_STR);
        echo"c";
		$statement->bindParam(':SALT', hash("sha256",$REGIS), PDO::PARAM_STR);
        echo"c";
		$statement->bindParam(':DATE', $REGIS, PDO::PARAM_INT);
        echo"ce";
		// $statement->bindParam(':ICON', $ICON, PDO::PARAM_STR);
        $statement->bindParam(':ICON', hash("MD5",$USR . "profile image"), PDO::PARAM_STR);
        echo"cd";
		$statement->execute();
        echo"cok";

		/*echo "configuring user home <br>";
		file_put_contents($target_dir .  "index.php", $USERFILE_P1 . $USR . $USERFILE_P2 );*/

		echo "creating session\n";

		// start session
		require "session.php";
        echo "creating session\n";
		start_session ( $MAIL, hash("sha256",$PSWD), "/Bibilioteca/Bib/" );

	} catch(PDOException $error) {
		// in caso di errori
		echo $error->getMessage() . "<br>";
	}


    /*// semd confirmation mail
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
        echo "\nsetup";
        
        //Recipients
        $mail->setFrom('provamail772007@gmail.com', 'Biblioteca');
        echo "\nmails" . $maill;
        $mail->addAddress($maill, 'Nuovo Utente1');     // Add a recipient
        echo "\nmails";

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        
        // generate OTP

        $mail->Subject = 'OTP';
        $mail->Body    = '0889';
        $mail->AltBody = '0112';


        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }*/
}

function login ( $mail, $pass ) {
	$PSW = $_POST['PSW'];
	$PSW_H = hash("sha256",$PSW);
	$USR = $_POST['USR'];

	start_session ( $USR, $PSW_H );
}

if ( isset ( $_POST ) ) {
    switch ( $_POST ['mode'] ) {
        case 0: is_registred ( $_POST['mail'] ); break;
        case 1: register ( $_POST['mail'], $_POST['pass'] ); break;
        case 2: login ( $_POST['mail'], $_POST['pass'] ); break;
    }
}

?>