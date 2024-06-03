<?php
function Get_Books ( $User ) {
	try {
		require "config.php";
		$connection = new PDO($dsn, $username, $password, $options);
		// request books where the name matches
		$sql = "SELECT opere.ID, opere.titolo, CONCAT(autore.nome, ' ', autore.cognome), prestito.fine_prestito
				FROM opere, autore, prestito, persona
				WHERE opere.autore = autore.ID
                AND presona.ID = prestito.ID_persona
                AND prestito.ID_opera = opera.ID
                AND prestito.onorato = 0
                AND persona.ID = :USER
                "; // chacks if the book is booked

		// echo $sql . "<br>";
		$statement = $connection->prepare($sql);
		$statement->bindParam(':USER', $User, PDO::PARAM_STR);
		$statement->execute ( );
		$Books = $statement->fetchAll();

		// $Books = array ( array ( "cok and balls", "my left testicle", 1969, "available" ), array ( "the left testicle of god", "the owner", 1984, "unfortunaltely not present" ) );

		// if there are no books it stops
		if ( sizeof ( $Books ) == 0 ) { echo "no books"; return; }
		// prints table with books
		echo "<table id='book-table' class='booktab'>\n";
		echo "<tr>";
			echo "<th> ID </th>";
			echo "<th> titolo </th>";
			echo "<td> autore </td>";
			echo "<td> anno </td>";
			echo "<td> bib </td>";
			echo "<td> genere </td>";
			echo "<td> disponibilità </td>";
		echo "</tr>";

		foreach ( $Books as $BOOO ) {
			echo "<tr id='book_$BOOO[0]' onclick='selected_book($BOOO[0])' " .( ($BOOO[6] == 0) ? ("class='disponibile'") : ("class=''") ). ">\n";
				echo "<th>".$BOOO[0]."</th>";
				echo "<td>".$BOOO[1]."</td>";
				echo "<td>".$BOOO[2]."</td>";
				echo "<td>".$BOOO[3]."</td>";
				echo "<td>".$BOOO[4]."</td>";
				echo "<td>".$BOOO[5]."</td>";
				echo "<td>".( ($BOOO[6] == 1) ? ('disponibile') : ('non disponibile') )."</td>\n";
			echo "</tr>\n";
		}
		echo "</table>";
	} catch(PDOException $error) 
	{ echo $error->getMessage(); }
}

if ( isset ( $_POST ) ) {
	Find_Book ( [ $_POST ["mode"], $_POST ["query"] ] );
} else {
	echo "get the cok"; 
}
?>
