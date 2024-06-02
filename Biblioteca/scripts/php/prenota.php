<?php
function Prenota ( $book, $persona ) { // book id and person id
    try {
		require "config.php";
		$connection = new PDO($dsn, $username, $password, $options);
		// check
		$sql = "SELECT prestito.onorato as O FROM opere, prestito
				WHERE opere.ID = :BOOKID
				AND opere.ID = prestito.ID_Opera";

		$statement = $connection->prepare($sql);
		$statement->bindParam(':BOOKID', $book, PDO::PARAM_STR);
		$statement->execute ( );
		$Books = $statement->fetchAll();

       // if there are no records you can do the prenotation
		if ( sizeof ( $Books ) == 0 ) {
            // add record
            $sql = "INSERT INTO prestito(ID_persona,ID_opera,data_prestito,fine_prestito,onorato) VALUES (:PID,:BID,:ORA,:DOPO,0)";
            $statement = $connection->prepare($sql);
            $statement->bindParam(':PID', $persona, PDO::PARAM_INT);
            $statement->bindParam(':BID', $book, PDO::PARAM_INT);
            $statement->bindParam(':ORA', $_SERVER['REQUEST_TIME'], PDO::PARAM_INT);
            $returntime =  $_SERVER['REQUEST_TIME'] + $prestito_validity;
            $statement->bindParam(':DOPO', $returntime, PDO::PARAM_INT);
            $statement->execute ( );
            echo "prenotato";

            return;
        }
        // check if the book is available
        foreach ( $Books as $BOOO ) {
            if ( $BOOO[ "O" ] == 0 ) {
                echo "libro non disponibile";
                return;
            }
        }

        $sql = "INSERT INTO prestito(ID_persona,ID_opera,data_prestito,fine_prestito) VALUES (:PID,:BID,:ORA,:DOPO)";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':PID', $persona, PDO::PARAM_INT);
        $statement->bindParam(':BID', $book, PDO::PARAM_INT);
        $statement->bindParam(':ORA', $_SERVER['REQUEST_TIME'], PDO::PARAM_INT);
        $statement->bindParam(':DOPO', $_SERVER['REQUEST_TIME'] + $prestito_validity, PDO::PARAM_INT);
        $statement->execute ( );
        echo "prenotato";

	} catch(PDOException $error) 
	{ echo $error->getMessage(); }
}

if ( isset ( $_POST ) ) 
{ Prenota ( $_POST ["Book"], $_POST ["User"] ); } 
else { echo "get the cok"; }
?>