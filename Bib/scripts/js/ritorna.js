function configureTable ( ) {
    var formData = new FormData ( );
    formData.append( "User", user_id );
    formData.append( "Mode", 0 );

    postData ( "scripts/php/restituisci.php", formData ).then (
        ( data ) => {
            data.text ( ).then ( 
                ( values ) => {
                    table.innerHTML = values;
                    console.log ( values )
                }
            )
        }
    )
}

function selected_book ( libro ) {
    let risposta = prompt("Vuoi prenotare il libro " + " di " + "?\nScrivi CONFERMO per confermare");
    if ( risposta=="CONFERMO" ) {
        var formData = new FormData ( );
        formData.append( "Book", libro );
        formData.append( "User", user_id );
        formData.append( "Mode", 1 );
        console.log ( formData );
        postData ( "scripts/php/restituisci.php", formData ).then (
            ( data ) => {
                data.text ( ).then ( 
                    ( values ) => {
                        alert ( values );
                        console.log ( values )
                    }
                )
            }
        )
        document.getElementById( "book_" + libro ).style = "display : none;";
    } else if ( risposta == null ) {
        alert("Azione annullata");
    } else {
        alert("Devi scrivere CONFERMO per confermare la restituzione");
    }
}

configureTable ( );

header.style.backgroundColor = '#29323c';