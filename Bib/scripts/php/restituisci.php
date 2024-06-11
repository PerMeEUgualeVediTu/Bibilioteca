<?php
function Get_Books ( $User ) {
	try {
		require "config.php";
		$connection = new PDO($dsn, $username, $password, $options);
		// request books where the name matches
		$sql = "SELECT opere.ID, opere.titolo, CONCAT(autore.nome, ' ', autore.cognome), prestito.fine_prestito
				FROM opere, autore, prestito, persona
				WHERE opere.autore = autore.ID
                AND persona.ID = prestito.ID_persona
                AND prestito.ID_opera = opere.ID
                AND prestito.onorato = 0
                AND persona.ID = :USER"; // chacks if the book is booked

		// echo $sql . "<br>";
		$statement = $connection->prepare($sql);
		$statement->bindParam(':USER', $User, PDO::PARAM_STR);
		$statement->execute ( );
		$Books = $statement->fetchAll();

		// $Books = array ( array ( "cok and balls", "my left testicle", 1969, "available" ), array ( "the left testicle of god", "the owner", 1984, "unfortunaltely not present" ) );

		// if there are no books it stops
		if ( sizeof ( $Books ) == 0 ) { echo "no books"; echo $User; return; }
		// prints table with books
		echo "<table id='book-table' class='booktab'>\n";
		echo "<tr>";
			echo "<th> ID </th>";
			echo "<th> titolo </th>";
			echo "<td> autore </td>";
			echo "<td> tempo rimasto </td>";
		echo "</tr>";

		foreach ( $Books as $BOOO ) {
			echo "<tr id='book_$BOOO[0]' onclick='selected_book($BOOO[0])' " .( ($BOOO[6] == 0) ? ("class='disponibile'") : ("class=''") ). ">\n";
				echo "<th>".$BOOO[0]."</th>";
				echo "<td>".$BOOO[1]."</td>";
				echo "<td>".$BOOO[2]."</td>";
				echo "<td>".$BOOO[3] - time()."</td>";
			echo "</tr>\n";
		}
		echo "</table>";
	} catch(PDOException $error) 
	{ echo $error->getMessage(); }
}

function Restituisci ( $User, $Book ) {
	try {
		require "config.php";
		$connection = new PDO($dsn, $username, $password, $options);
		// request books where the name matches
		$sql = "UPDATE prestito
				SET prestito.onorato = 1
				WHERE prestito.ID_opera = :OP
				AND   prestito.ID_persona = :IP ";

		// echo $sql . "<br>";
		$statement = $connection->prepare($sql);
		$statement->bindParam(':OP', $Book, PDO::PARAM_STR);
		$statement->bindParam(':IP', $User, PDO::PARAM_STR);
		$statement->execute ( );
		$Books = $statement->fetchAll();

		echo "restituito";
	} catch(PDOException $error) 
	{ echo $error->getMessage(); }
}

if ( isset ( $_POST ) ) {
	if ( $_POST['Mode'] == 0 ) {
		Get_Books ( $_POST['User'] );
	} else {
		Restituisci ( $_POST['User'], $_POST['Book'] );
	}
} else {
	echo "get the cok"; 
}
?>