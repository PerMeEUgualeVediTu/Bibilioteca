<!--this script creats a table and prints where it is called-->

<?php
function Find_Book ( $book ) {
	try {
		require "config.php";
		$connection = new PDO($dsn, $username, $password, $options);
		// request books where the name matches
		$mode = [1,"Esattamente"]; // 0 mode = sort by author, 1 = sort by title, 2 = sort by genere
		$sql = "SELECT opere.titolo, CONCAT(autore.nome, ' ', autore.cognome), opere.anno, biblioteca.luogo_biblioteca, genere.genere 
				FROM opere, autore, biblioteca, genere 
				WHERE opere.genere = genere.ID 
				AND opere.autore = autore.ID 
				AND opere.biblio = biblioteca.ID ";
		switch ( $mode[0] ) {
			case 0: $sql .= "AND autore.nome = '" . $mode[1] . "'"; break;
			case 1: $sql .= "AND opere.titolo = '" . $mode[1] . "'"; break;
			case 2: $sql .= "AND genere.genere = \"" . $mode[1] . "\""; break;
		}

		echo $sql . "<br>";
		$statement = $connection->prepare($sql);
		// $statement->bindParam(':END', $END, PDO::PARAM_STR);
		$statement->execute ( );
		$Books = $statement->fetchAll();

		// $Books = array ( array ( "cok and balls", "my left testicle", 1969, "available" ), array ( "the left testicle of god", "the owner", 1984, "unfortunaltely not present" ) );

		// if there are no books it stops
		if ( sizeof ( $Books ) == 0 ) { echo "no books"; return; }
		// prints table with books
		echo "<table>\n";
		echo "<tr>";
			echo "<th> titolo </th>";
			echo "<td> autore </td>";
			echo "<td> anno </td>";
			echo "<td> bib </td>";
			echo "<td> genere </td>";
		echo "</tr>";

		foreach ( $Books as $BOOO ) {
			echo "<tr>";
				echo "<th>".$BOOO[0]."</th>";
				echo "<td>".$BOOO[1]."</td>";
				echo "<td>".$BOOO[2]."</td>";
				echo "<td>".$BOOO[3]."</td>";
				echo "<td>".$BOOO[4]."</td>";
			echo "</tr>";
		}
		echo "</table>";
	} catch(PDOException $error) 
	{ echo $error->getMessage(); }
}
?>