function selected_book ( book ) {
    if ( user_id == -1 ) {
        alert ( "non sei registrato" );
        return;
    }
    let risposta = prompt("Vuoi prenotare il libro " + " di " + "?\nScrivi CONFERMO per confermare");

    if ( risposta=="CONFERMO" ) {
        var formData = new FormData ( );
        formData.append( "Book", book );
        formData.append( "User", user_id );
        console.log ( formData );
        postData ( "scripts/php/prenota.php", formData ).then (
            ( data ) => {
                data.text ( ).then ( 
                    ( values ) => {
                        alert ( values );
                        console.log ( values )
                    }
                )
            }
        )
        document.getElementById( "book_" + book ).classList.add ( "disponibile" );
    } else if ( risposta == null ) {
        alert("Azione annullata");
    } else {
        alert("Devi scrivere CONFERMO per confermare la restituzione");
    }
}

header.style.backgroundColor = '#29323c';