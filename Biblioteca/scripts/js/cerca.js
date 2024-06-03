const hamburger = document.querySelector('.header .nav-bar .nav-list .hamburger');
const mobile_menu = document.querySelector('.header .nav-bar .nav-list ul');
const menu_item = document.querySelectorAll('.header .nav-bar .nav-list ul li a');
const header = document.querySelector('.header.container');
const textarea = document.querySelector('.input-box-search');
const selectors = document.querySelectorAll('.service-item');
const search_prompt = document.querySelector('.search-prompt');
const table = document.getElementById ( "book-table" );
let search_mode = 0;

selectors.item(0).classList.toggle("selected");

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

async function postData(url = "", data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        
        body: data, // body data type must match "Content-Type" header
    });
    return response; // parses JSON response into native JavaScript objects
}

textarea.addEventListener('input', checkEnterPress);
function checkEnterPress() {
    // alert(textarea.value + "  " + search_mode);
    textarea.style.height = 'auto';
    if ( [...textarea.value].length <= 3 ) { return; }
    //prego elia ecco a te l'input di ricerca
    var formData = new FormData ( );
    formData.append( "mode", search_mode );
    formData.append( "query", textarea.value );

    console.log ( formData );

    // if ( textarea.value == "" || textarea.value == "*" ) { return; } 

    postData ( "scripts/php/engine.php", formData ).then (
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

selectors.forEach((item, index) => {
    item.addEventListener('click', () => {
        switchSearchMode(index);
        toggleBorder(index);
    });
});

function switchSearchMode(index) {
    search_mode = index;

    var internal_search_mode;

    switch (index) {
        case 0:
            internal_search_mode = "titolo";
            break;
        case 1:
            internal_search_mode = "autore";
            break;
        case 2:
            internal_search_mode = "genere";
            break;
        default:
            break;
    }
    
    if(internal_search_mode == "autore"){
        textarea.placeholder = "Inserisci l'"+ internal_search_mode + " del libro";
        search_prompt.innerHTML = "Inserisci qui l'" + internal_search_mode +" del libro, e premi invia per cercarlo nella nostra libreria!";
    }else{
        textarea.placeholder = "Inserisci il "+ internal_search_mode + " del libro";
        search_prompt.innerHTML = "Inserisci qui il " + internal_search_mode +" del libro, e premi invia per cercarlo nella nostra libreria!";
    }
}

function toggleBorder(index){
    selectors.forEach((item, i) => {
        if(i == index){
            item.classList.toggle("selected");
        }else{
            item.classList.remove("selected");
        }
    });
}

function selected_book ( book ) {
    // let risposta = prompt("Vuoi prenotare il libro " + " di " + "?\nScrivi CONFERMO per confermare");
    let risposta = "CONFERMO";
    if ( risposta=="CONFERMO" ) {
        var formData = new FormData ( );
        formData.append( "Book", book );
        formData.append( "User", 2 );
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
    } else if ( risposta == null ) {
        alert("Azione annullata");
    } else {
        alert("Devi scrivere CONFERMO per confermare la restituzione");
    }
}