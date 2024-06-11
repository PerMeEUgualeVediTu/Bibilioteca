<?php

function get_ip ( ) { 
    if ( !empty($_SERVER['HTTP_CLIENT_IP'] ) ) 
	{ $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) 
	{ $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
    } else { $ip = $_SERVER['REMOTE_ADDR']; } 

    return $ip; 
}

// return user infos if present else NULL
// for errors returns a string
function get_session ( $TOKEN, &$connection = NULL ) {
	try {
		include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/config.php";
		if ( $connection == NULL ) { $connection = new PDO($dsn, $username, $password, $options); }

		$sql = "SELECT User_name, User_icon, Session_start, Session_ip FROM Users, Sessions WHERE Logged_user_ID = User_Id and Session_Token='".$TOKEN."'";
		$statement = $connection->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();
	} catch(PDOException $error) 
	{ return $error->getMessage(); }
	
	if ($result && $statement->rowCount() > 0) {
		if (($result[0]['Session_start'] + $session_validity > time()) && $result[0]['Session_ip'] == get_ip() ) 
		{ return $result[0]; }
	}
	
	return NULL;
}

function start_session ( $USR, $PSW, $PAGE = "/index.php", &$connection = NULL ) {
	
	try {
		include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/config.php";
		if ( $connection == NULL ) { $connection = new PDO($dsn, $username, $password, $options); }
		
		// fetch user ID
		$sql = "SELECT User_Id FROM Users WHERE Password_hash = :PSW AND ( User_name = :USR OR E_mail = :MAIL )";
		$statement = $connection->prepare($sql);
		$statement->bindParam(':PSW', $PSW, PDO::PARAM_STR);
		$statement->bindParam(':USR', $USR, PDO::PARAM_STR);
		$statement->bindParam(':MAIL', $USR, PDO::PARAM_STR);
		$statement->execute();
		$result = $statement->fetchAll();

		if ($result && $statement->rowCount() > 0) {
			// insert session
			$sql = "INSERT INTO Sessions ( Session_Token, Session_IP, Logged_user_ID ,Session_Start) VALUES (:TOKEN, :IP, :ID, :TIME)";
			
			$ID = $result[0]['User_Id'];
			$IP = get_ip ( );
			$TIME = time();
			$TOKEN = hash("sha256", $IP . $TIME ."pippobaudo è un eroe nazionale" . $ID);

			$statement = $connection->prepare($sql);
			$statement->bindParam(':IP', $IP, PDO::PARAM_STR);
			$statement->bindParam(':ID', $ID, PDO::PARAM_STR);
			$statement->bindParam(':TIME', $TIME, PDO::PARAM_STR);
			$statement->bindParam(':TOKEN', $TOKEN, PDO::PARAM_STR);
			$statement->execute();


		} else {
			return NULL;
		}
	} catch(PDOException $error) 
	{ return $error->getMessage(); }

	if ( isset($_COOKIE['coockie_usage']) ) {
		echo setcookie( "SESSION_TOKEN", $TOKEN, [
			'path' => '/',
			'samesite' => 'Lax',
		]);
		echo print_r($_COOKIE);
		header("Location: " . $PAGE);
	} else {
		header("Location: " . $PAGE . "?SESSION_TOKEN=" . $TOKEN);
	}
}

function disconnect() {
	echo"cok";
	if ( isset($_COOKIE['coockie_usage']) ) { 
		unset ($_COOKIE['SESSION_TOKEN']);
		setcookie('SESSION_TOKEN', null, -1, '/'); 
		echo " super cok";
	}

	header("Location: index.php");
}
?>