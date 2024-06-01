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

function createRow(id, titolo, autore, tempoConsegnare, libreria) {
    const row = document.createElement('tr');
    row.addEventListener('click', () => {
        if(row.classList.contains('selected')){
            row.classList.remove('selected');
            selected_id = null;
        }else{
            changeSelection(id);
            row.classList.toggle('selected');
        }
        showLibrary(libreria);
        onBookUpdate();
    });

    //const idCell = document.createElement('td');
    //idCell.textContent = id;
    //row.appendChild(idCell);

    const titoloCell = document.createElement('td');
    titoloCell.textContent = titolo;
    row.appendChild(titoloCell);

    const autoreCell = document.createElement('td');
    autoreCell.textContent = autore;
    row.appendChild(autoreCell);

    const tempoCell = document.createElement('td');
    tempoCell.textContent = tempoConsegnare;
    row.appendChild(tempoCell);

    return row;
}

//qua verranno prese dal db con le info di login
const dataRows = [
    [1, 'Enders Game', 'Orson Scott Card', '14 giorni', 'Atrio A'],
    [2, 'To Kill a Mockingbird', 'Harper Lee', '10 giorni', 'Biblioteca'],
    [3, '1984', 'George Orwell', '31 giorni', 'Aula 27']
];

dataRows.forEach(rowData => {
    const row = createRow(...rowData);
    table.appendChild(row);
});

document.getElementById('books-table').appendChild(table);

function changeSelection(id){
    selected_id = id;
    //alert(table.querySelectorAll("tr").length);
    table.querySelectorAll("tr").forEach(row => {
        row.classList.remove("selected");
    });
}

function showLibrary(libreria){
    if(selected_id)
        lib_prompt.innerHTML = "Il libro è da consegnare alla libreria: <span>" + libreria + "</span>.";
    else
        lib_prompt.innerHTML = "";
}

function onBookUpdate(){
    if(selected_id == null){
        cta_return.style.display = "none";
    }else{
        cta_return.style.display = "inline-block";
    }
}

function conferma(){
    let index = dataRows.findIndex(row => row[0] == selected_id);
    let title = dataRows[index][1];
    let author = dataRows[index][2];
    let days = dataRows[index][3];
    let library = dataRows[index][4];
    let risposta = prompt("Vuoi confermare di aver restituito il libro " + title + " di " + author + " alla libreria " + library + "?\nTi rimangono ancora " + days + " per consegnarlo.\nScrivi CONFERMO per confermare");
    if(selected_id && risposta=="CONFERMO"){
        //alert(selected_id);
        //alert(table.querySelectorAll("tr").length);
        table.querySelectorAll("tr").forEach(row => {
            if(row.classList.contains("selected")){
                row.remove();
            }
        });
        selected_id = null;
        lib_prompt.innerHTML = "";
        cta_return.style.display = "none";
    }else if(risposta == null){
        alert("Azione annullata");
    }else{
        alert("Devi scrivere CONFERMO per confermare la restituzione");
    }
}