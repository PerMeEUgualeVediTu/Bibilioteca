<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../stylesheets/login.css">
	<title>Login</title>
</head>
<body>
	<div class="PHP_errors">
<?php
	// error in the registation get
	if (isset($_GET['register_error'])) 
	{ echo "The requested procedure expired or it's incorrect, try again"; }
?>

<?php
// normal activity
include  $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/session.php";

// login
if (isset($_POST['submit_login'])) {
	$PSW = $_POST['PSW'];
	$PSW_H = hash("sha256",$PSW);
	$USR = $_POST['USR'];

	start_session ( $USR, $PSW_H );
}

if (isset($_POST['submit_register'])) {
	echo "Try to Register<br>";

	// send mail
	/*
	$user_mail = $_POST['mail'];

	$subject = 'the subject';
	$message = 'hello';
	$headers = 'From: register@katprojekt.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

	if ( mail($user_mail, $subject, $message, $headers) ) {
		echo "Mail Sent";
	} else {
		echo "Can not Send Mail";	
	}*/

	echo "insert<br>";

	try  {
		include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/config.php";

		$connection = new PDO($dsn, $username, $password, $options);
		$sql = "INSERT INTO Procedures (Procedure_END,Procedure_DESC) VALUES (:END, :DESC)";

		$DESC = $_POST['mail'];
		$END = time();

		$statement = $connection->prepare($sql);
		$statement->bindParam(':END', $END, PDO::PARAM_STR);
		$statement->bindParam(':DESC', $DESC, PDO::PARAM_STR);
		$statement->execute();

		$sql = "SELECT Procedure_ID FROM Procedures WHERE Procedure_END=:END and Procedure_DESC=:DESC";

		$DESC = $_POST['mail'];

		$statement = $connection->prepare($sql);
		$statement->bindParam(':END', $END, PDO::PARAM_STR);
		$statement->bindParam(':DESC', $DESC, PDO::PARAM_STR);
		$statement->execute();
		$result = $statement->fetchAll();
		header("Location: create.php?Procedure_ID=". $result[0]['Procedure_ID']);

	} catch(PDOException $error) {
		// in caso di errori
		echo $sql . "<br>" . $error->getMessage() . "<br> server error";
	}

	// redirect
}
?>
	</div>

	<div class="login center_box">
		<h1>Login</h1>
		<form method="post">
			<input autocomplete="off" oninput="mail_check();" placeholder ="username / e-mail" type="text" name="USR" id="USR">
			<div><h2 class="error"></h2></div>
			<input placeholder ="password" type="password" name="PSW" id="PSW">
			<div><h2 class="_error"></h2></div>
			<input type="submit" name="submit_login" id="submit_login" value="You sure?">
		</form>
		<button onclick="register();" >No account?</button>
	</div>

	<div class="register center_box">
		<h1>Register</h1>

		<form method="post">
			<input autocomplete="off" oninput="mail_check();" placeholder ="email" type="text" name="mail" id="USR">
			<div><h2 class="error"></h2></div>
			<input type="submit" name="submit_register" id="submit_register" value="Just do It">
		</form>

		<button onclick="login();" >Already did It</button>
	</div>

<script src="../scripts/js/account.js"></script>
</body>
</html>

<?php
echo $dsn;
?>