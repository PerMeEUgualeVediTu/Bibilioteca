<?php
function get_procedure_ID () {
    $P_ID = NULL;
    if ( isset($_COOKIE['coockie_usage']) && isset($_COOKIE['PROCEDURE_ID']) ) 
	{ $P_ID = $_COOKIE['PROCEDURE_ID']; 
	} elseif ( isset($_GET['PROCEDURE_ID']) ) 
	{ $P_ID = $_GET['PROCEDURE_ID']; }

    if ( isset($_COOKIE['coockie_usage']) && $P_ID != NULL ) 
    { setcookie ( "PROCEDURE_ID", $P_ID, [
        'path' => '/',
        'samesite' => 'Lax',
    ]); }
    
    return $P_ID;
}

function get_procedure ( ) {

}

function start_procedure ( $content, $PAGE, $adds = NULL, &$connection = NULL  ) {
    try  {
		include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/config.php";

		if ( $connection == NULL ) { $connection = new PDO($dsn, $username, $password, $options); }
		
		$sql = "INSERT INTO Procedures (Procedure_END,Procedure_DESC) VALUES (:END, :DESC)";

		$END = time() + $procedure_validity;

		$statement = $connection->prepare($sql);
		$statement->bindParam(':END', $END, PDO::PARAM_STR);
		$statement->bindParam(':DESC', $content, PDO::PARAM_STR);
		$statement->execute();

		$sql = "SELECT Procedure_ID FROM Procedures WHERE Procedure_END=:END and Procedure_DESC=:DESC";

		$statement = $connection->prepare($sql);
		$statement->bindParam(':END', $END, PDO::PARAM_STR);
		$statement->bindParam(':DESC', $content, PDO::PARAM_STR);
		$statement->execute();
		$result = $statement->fetchAll();


		if ( isset($_COOKIE['coockie_usage']) ) {
			echo setcookie( "PROCEDURE_ID", $$result[0]['Procedure_ID'], [
				'path' => '/',
				'samesite' => 'Lax',
			]);
			echo print_r($_COOKIE);
			header("Location: " . $PAGE);
		} else {
			header("Location: " . $PAGE . "?Procedure_ID=". $result[0]['Procedure_ID'] . 
			( $adds != NULL ? $adds : "" ));
		}

	} catch(PDOException $error) 
	{ return $error->getMessage(); }
}

?>