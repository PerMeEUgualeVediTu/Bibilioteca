const hamburger = document.querySelector('.header .nav-bar .nav-list .hamburger');
const mobile_menu = document.querySelector('.header .nav-bar .nav-list ul');
const menu_item = document.querySelectorAll('.header .nav-bar .nav-list ul li a');
const header = document.querySelector('.header.container');
const textarea = document.querySelector('.input-box-search');

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
        alert(textarea.value);
        textarea.value = "";
        //prego elia ecco a te l'input di ricerca
    }
}
