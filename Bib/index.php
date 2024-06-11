<?php
require $_SERVER['DOCUMENT_ROOT'] . "/Bibilioteca/Bib/scripts/php/head.php";
?>

<!-- Hero Section  -->
<section id="hero">
    <div class="hero container">
        <div>
            <h1>Benvenuti su <span></span></h1>
            <h1>Alexandria<span></span></h1>
            <h1>La libreria autogestita <span></span></h1>
            <a href="cerca.html" type="button" class="cta">Vedi i libri</a>
        </div>
    </div>
</section>
<!-- End Hero Section  -->

<!-- Service Section -->
<section id="services">
    <div class="services container">
        <div class="service-top">
            <h1 class="section-title">Cos'è <span>Alexandria</span>?</h1>
            <p>Alexandria è la biblioteca diffusa e autogestita del Liceo M. Grigoletti. Si tratta di un progetto innovativo, realizzato per rendere i numerosi libri in possesso della scuola facilmente accessibili e disponibili a tutti.<br><br>Ecco i servizi che Alexandria mette a disposizione:</p>
        </div>
        <div class="service-bottom">
            <div class="service-item">
            <a href="cerca.php" data-after="Cerca">
                <h2>Ricerca</h2>
                <p>È possibile effettuare una ricerca dei libri presenti nella biblioteca diffusa, in base al titolo, all'autore o al genere. </p></a>
            </div>
            <div class="service-item">
            <a href="prenota.php" data-after="Cerca">
                <h2>Prestito</h2>
                <p>Accedendo all'area riservata con la mail istituzionale, è possibile richiedere in prestito i libri desiderati.</p>
            </a></div>
            <div class="service-item">
            <a href="ritorna.php" data-after="Cerca">
                <h2>Reso</h2>
                <p>Accedendo all'area riservata con la mail istituzionale, è possibile confermare l'avvenuta restituzione dei libri.</p>
            </a></div>
        </div>
    </div>
</section>

<?php
require $_SERVER['DOCUMENT_ROOT'] . "/Bibilioteca/Bib/scripts/php/bot.php";
?>

<script>
    document.addEventListener('scroll', () => {
    var scroll_position = window.scrollY;
    if (scroll_position > 250) {
        header.style.backgroundColor = '#29323c';
    } else {
        header.style.backgroundColor = 'transparent';
    }
});
</script>