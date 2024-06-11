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
		require "config.php";
		if ( $connection == NULL ) { $connection = new PDO($dsn, $username, $password, $options); }

		$sql = "SELECT persona.ID as ID, Session_start, Session_ip FROM persona, Sessions WHERE Logged_user_ID = persona.ID and Session_token='".$TOKEN."'";
		$statement = $connection->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();
	} catch(PDOException $error) 
	{ return $error->getMessage(); }
	
	if ($result && $statement->rowCount() > 0) {
		if (($result[0]['Session_start'] + $session_validity > time()) && $result[0]['Session_ip'] == get_ip() ) 
		{ return $result[0]['ID']; }
	}
	
	return -1;
}

function start_session ( $USR, $PSW, $PAGE = "/index.php", &$connection = NULL ) {
	echo "\nstarting ession\n";
	try {
		require "config.php";
		if ( $connection == NULL ) { $connection = new PDO($dsn, $username, $password, $options); }
		
		// fetch user ID
		$sql = "SELECT ID FROM persona WHERE Password_hash = :PSW AND E_mail = :MAIL";
		$statement = $connection->prepare($sql);
		$statement->bindParam(':PSW', $PSW, PDO::PARAM_STR);
		$statement->bindParam(':MAIL', $USR, PDO::PARAM_STR);
		$statement->execute();
		$result = $statement->fetchAll();

		echo "select\n";

		if ($result && $statement->rowCount() > 0) {
			// insert session
			$sql = "INSERT INTO Sessions ( Session_token, Session_ip, Logged_user_id ,Session_start) VALUES (:TOKEN, :IP, :ID, :TIME)";
			
			$ID = $result[0]['ID'];
			echo "ID: ". $ID .'\n';
			$IP = get_ip ( );
			$TIME = time();
			$TOKEN = hash("sha256", $IP . $TIME ."pippobaudo è un eroe nazionale" . $ID);

			$statement = $connection->prepare($sql);
			$statement->bindParam(':IP', $IP, PDO::PARAM_STR);
			$statement->bindParam(':ID', $ID, PDO::PARAM_INT);
			$statement->bindParam(':TIME', $TIME, PDO::PARAM_INT);
			$statement->bindParam(':TOKEN', $TOKEN, PDO::PARAM_STR);
			echo "pre execute\n";
			echo $sql;
			$statement->execute();
			echo "select2\n";


		} else {
			return NULL;
		}
	} catch(PDOException $error) 
	{ return $error->getMessage(); }

	echo "creating cokie\n";
	echo setcookie( "SESSION_TOKEN", $TOKEN, [
		'path' => '/',
		'samesite' => 'Lax',
	]);
	echo print_r($_COOKIE);
	header("Location: " . $PAGE);

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