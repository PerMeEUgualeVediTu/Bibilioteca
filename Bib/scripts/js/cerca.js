const selectors = document.querySelectorAll('.service-item');
const search_prompt = document.querySelector('.search-prompt');
const textarea = document.querySelector('.input-box-search');
const table = document.getElementById ( "book-table" );

let search_mode = 0;

selectors.forEach((item, index) => {
    item.addEventListener('click', () => {
        switchSearchMode(index);
        toggleBorder(index);
    });
});

function toggleBorder(index){
    selectors.forEach((item, i) => {
        if(i == index){
            item.classList.toggle("selected");
        }else{
            item.classList.remove("selected");
        }
    });
}

function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 10 + 'px';
}

async function postData(url = "", data = {}) {
    const response = await fetch(url, { method: "POST", body: data });
    return response;
}

function switchSearchMode(index) {
    search_mode = index;

    var internal_search_mode;

    switch ( index ) {
        case 0: internal_search_mode = "titolo"; break;
        case 1: internal_search_mode = "autore"; break;
        case 2: internal_search_mode = "genere"; break;
    }
    
    if ( internal_search_mode == "autore" ) {
        textarea.placeholder = "Inserisci l'"+ internal_search_mode + " del libro";
        search_prompt.innerHTML = "Inserisci qui l'" + internal_search_mode +" del libro, e premi invia per cercarlo nella nostra libreria!";
    } else {
        textarea.placeholder = "Inserisci il "+ internal_search_mode + " del libro";
        search_prompt.innerHTML = "Inserisci qui il " + internal_search_mode +" del libro, e premi invia per cercarlo nella nostra libreria!";
    }
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

    postData ( "scripts/php/engine.php", formData )
    .then ( ( data ) => { data.text ( )
        .then ( ( values ) => { table.innerHTML = values; } ) } )
}

header.style.backgroundColor = '#29323c';