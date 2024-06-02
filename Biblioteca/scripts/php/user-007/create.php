<?php
include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/newuser_page.php";
?>

<?php
$FREE_ACCOUNT = true;
$USED = NULL;
if(isset($_POST["submit"])) {
	try  {
		$connection = new PDO($dsn, $username, $password, $options);

		// control for Reusage
		$sql = "SELECT User_name, Password_hash FROM Users WHERE E_mail=:MAIL or User_name=:USR or Password_hash=:PSW";

		$USR = $_POST['USR'];
		$MAIL = $_POST['MAIL'];
		$PSW = hash("sha256",$_POST['PSW']);

		$statement = $connection->prepare($sql);
		$statement->bindParam(':USR', $USR, PDO::PARAM_STR);
		$statement->bindParam(':MAIL', $MAIL, PDO::PARAM_STR);
		$statement->bindParam(':PSW', $PSW, PDO::PARAM_STR);
		$statement->execute();
		$result = $statement->fetchAll();


		if ($result && $statement->rowCount() > 0) {
			if ( $PSW == $result[0]['Password_hash']) {
				$USED = array ( 'PSW' => $result[0]['User_name'], );
			} elseif ( $result[0]['User_name'] == $USR ) {
				$USED = array ( 'USR' => $result[0]['User_name'], );
			} else {
				$USED = array ( 'MAIL' => $result[0]['User_name'], );
			}
			$FREE_ACCOUNT = false;
		}
	} catch(PDOException $error) {
		// in caso di errori
		echo $error->getMessage() . "<br>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../stylesheets/login.css">
	<title>Account creation</title>
</head>
<body class="create_body">
	<?php
		if (! isset($_GET['Procedure_ID'])) {
			header("Location: index.php?register_error=1");
		}
	?>
	<div class="center_box">
		<h1>Create Account</h1>
		<form method="post" enctype="multipart/form-data">
			<input placeholder = "username" type="text" name="USR" id="USR"> <!-- required minlength="3"-->
			<?php if (isset($USED['USR'])) { echo "<h2>Username used</h2>"; } ?>
			<input placeholder = "e-mail" type="text" name="MAIL" id="MAIL" value=
			<?php 
				try  {
					$connection = new PDO($dsn, $username, $password, $options);
					$sql = "SELECT Procedure_DESC FROM Procedures WHERE  Procedure_ID=:ID";

					$ID = $_GET['Procedure_ID'];

					$statement = $connection->prepare($sql);
					$statement->bindParam(':ID', $ID, PDO::PARAM_STR);
					$statement->execute();
					$result = $statement->fetchAll();

					echo $result[0]['Procedure_DESC'];

				} catch(PDOException $error) {
					// in caso di errori
					echo $sql . "<br>" . $error->getMessage() . "<br> server error";
				}
			?> readonly>
			<?php if (isset($USED['MAIL'])) { echo "<h2> password used by: " . $USED['MAIL'] . "</h2>"; }?>
			<input placeholder = "password" type="password" name="PSW" id="PSW">
			<?php if (isset($USED['PSW'])) { echo "<h2> password used by: " . $USED['PSW'] . "</h2>"; } ?>
			<input oninput="psw_check();" placeholder = "confirm password" type="password" name="PSW1" id="PSW1">
			<h2 id="PSW_ERROR"></h2>
			<textarea oninput="description_check();" placeholder = "who are you?" type="text" name="description" rows="1" autocorrect="on" id="description"> </textarea>
			<label for="Profile_pick">Chose a profile pick<img id="preview"></label>
			<input accept="image/*" type="file" name="Profile_pick" id="Profile_pick" onchange="imgPreview(event);">
			
			<input class="register_b" type="submit" name="submit" value="Give it to ME">
		</form>
	</div>

	<script src="../scripts/js/account.js"></script>
</body>

<?php
if(isset($_POST["submit"]) && $FREE_ACCOUNT) {
	echo "creating account<br>";
	try  {
		$sql = "INSERT INTO Users (User_name, E_mail, Password_hash, Description, Register_date, User_icon, Access_level) VALUES ( :USR , :MAIL , :PSW , :DESC , :REGIS , :ICON , :ACCES )";

		$DESC = $_POST['description'];
		$REGIS = time();
		$ACCES = 1;

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
		}

		$statement = $connection->prepare($sql);
		$statement->bindParam(':USR', $USR, PDO::PARAM_STR);
		$statement->bindParam(':MAIL', $MAIL, PDO::PARAM_STR);
		$statement->bindParam(':PSW', $PSW, PDO::PARAM_STR);
		$statement->bindParam(':DESC', $DESC, PDO::PARAM_STR);
		$statement->bindParam(':REGIS', $REGIS, PDO::PARAM_STR);
		$statement->bindParam(':ICON', $ICON, PDO::PARAM_STR);
		$statement->bindParam(':ACCES', $ACCES, PDO::PARAM_STR);
		$statement->execute();

		echo "configuring user home <br>";
		file_put_contents($target_dir .  "index.php", $USERFILE_P1 . $USR . $USERFILE_P2 );

		echo "creating session<br>";

		// start session
		include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/session.php";
		start_session($USR,$PSW, "/", $connection);

	} catch(PDOException $error) {
		// in caso di errori
		echo $error->getMessage() . "<br>";
	}

	echo "account created";
}
?>
