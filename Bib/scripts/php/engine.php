<?php
function Find_Book ( $mode ) {
	try {
		require "config.php";
		$connection = new PDO($dsn, $username, $password, $options);
		// request books where the name matches
		$sql = "SELECT opere.ID, opere.titolo, CONCAT(autore.nome, ' ', autore.cognome), opere.anno, biblioteca.luogo_biblioteca, genere.genere, NOT opere.ID IN (
					SELECT prestito.ID_opera
					FROM prestito
					WHERE prestito.onorato = 0
				) as disponibilita
				FROM opere, autore, biblioteca, genere
				WHERE opere.genere = genere.ID 
				AND opere.autore = autore.ID 
				AND opere.biblio = biblioteca.ID "; // chacks if the book is booked
		if ( ! ( $mode[1] == "" || $mode[1] == "*" ) ) {
			switch ( $mode[0] ) {
				case 1: $sql .= "AND CONCAT(autore.nome, ' ', autore.cognome) REGEXP :VALUE"; break;
				case 0: $sql .= "AND opere.titolo REGEXP :VALUE"; break;
				case 2: $sql .= "AND genere.genere REGEXP :VALUE"; break;
			}
		}
		$sql .= " ORDER BY disponibilita DESC";

		// echo $sql . "<br>";
		$statement = $connection->prepare($sql);
		if ( ! ( $mode[1] == "" || $mode[1] == "*" ) ) 
		{ $statement->bindParam(':VALUE', $mode[1], PDO::PARAM_STR); }
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