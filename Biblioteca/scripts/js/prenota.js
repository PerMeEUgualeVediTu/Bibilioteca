const hamburger = document.querySelector('.header .nav-bar .nav-list .hamburger');
const mobile_menu = document.querySelector('.header .nav-bar .nav-list ul');
const menu_item = document.querySelectorAll('.header .nav-bar .nav-list ul li a');
const header = document.querySelector('.header.container');
const textarea = document.querySelector('.input-box-search');
const selectors = document.querySelectorAll('.service-item');
const search_prompt = document.querySelector('.search-prompt')
let search_mode = "titolo";

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

textarea.addEventListener('keydown', checkEnterPress);
function checkEnterPress(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        alert(textarea.value + "  " + search_mode);
        textarea.value = "";
        textarea.style.height = 'auto';
        //prego elia ecco a te l'input di ricerca
    }
}

selectors.forEach((item, index) => {
    item.addEventListener('click', () => {
        switchSearchMode(index);
        toggleBorder(index);
    });
});

function switchSearchMode(index) {
    switch (index) {
        case 0:
            search_mode = "titolo";
            break;
        case 1:
            search_mode = "autore";
            break;
        case 2:
            search_mode = "genere";
            break;
        default:
            break;
    }
    
    if(search_mode == "autore"){
        textarea.placeholder = "Inserisci l'"+ search_mode + " del libro";
        search_prompt.innerHTML = "Inserisci qui l'" + search_mode +" del libro, e premi invia per cercarlo nella nostra libreria!";
    }else{
        textarea.placeholder = "Inserisci il "+ search_mode + " del libro";
        search_prompt.innerHTML = "Inserisci qui il " + search_mode +" del libro, e premi invia per cercarlo nella nostra libreria!";
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


