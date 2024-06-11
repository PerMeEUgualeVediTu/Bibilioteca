const hamburger = document.querySelector('.header .nav-bar .nav-list .hamburger');
const mobile_menu = document.querySelector('.header .nav-bar .nav-list ul');
const menu_item = document.querySelectorAll('.header .nav-bar .nav-list ul li a');
const header = document.querySelector('.header.container');
const textarea = document.querySelector('.input-box-search');
const search_prompt = document.querySelector('.search-prompt');

let selected_id = null;

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    mobile_menu.classList.toggle('active');
});

header.style.backgroundColor = '#29323c';

menu_item.forEach((item) => {
    item.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        mobile_menu.classList.toggle('active');
    });
});

function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 10 + 'px';
}


const table = document.getElementById('book-table');
const lib_prompt = document.querySelector(".lib-prompt");

const cta_return = document.querySelector('.cta-return');

async function postData(url = "", data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        
        body: data, // body data type must match "Content-Type" header
    });
    return response; // parses JSON response into native JavaScript objects
}

function configureTable ( ) {

    var formData = new FormData ( );
    formData.append( "User", 2 );
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
    // let risposta = prompt("Vuoi prenotare il libro " + " di " + "?\nScrivi CONFERMO per confermare");
    let risposta = "CONFERMO";
    if ( risposta=="CONFERMO" ) {
        var formData = new FormData ( );
        formData.append( "Book", libro );
        formData.append( "User", 2 );
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