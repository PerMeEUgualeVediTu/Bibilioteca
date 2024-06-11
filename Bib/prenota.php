<?php
require $_SERVER['DOCUMENT_ROOT'] . "/Bibilioteca/Bib/scripts/php/head.php";
?>

<script defer src="scripts/js/cerca.js"></script>
<script defer src="scripts/js/prenota.js"></script>

<!-- Service Section -->
<section id="services">
    <div class="services container">
        <div class="service-top">
            <h1 class="section-title"><span>P</span>renota</h1>
            <!-- <textarea class="input-box-search" id="searchInput" placeholder="Inserisci il titolo del libro" oninput="autoResize(this)"></textarea>-->
        </div>
        <div class="service-bottom">
            <div class="service-item">
                <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/8832/8832880.png" /></div>
                <h2>Cerca per titolo</h2>                    
            </div>
            <div class="service-item">
                <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/8832/8832880.png" /></div>
                <h2>Cerca per autore</h2>
            </div>
            <div class="service-item">
                <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/8832/8832880.png" /></div>
                <h2>Cerca per genere</h2>
            </div>

        </div>
        <div class="service-top">
            <br>
            <p class="search-prompt">Inserisci qui il titolo del libro, e premi invia per cercarlo nella nostra libreria!</p>
            <br>
            <textarea class="input-box-search" id="searchInput" placeholder="Inserisci il titolo del libro" oninput="autoResize(this)"></textarea>
        </div>

        <table id="book-table" class="booktab"> </table>
    </div>
</section>
<!-- End Service Section -->

<?php
require $_SERVER['DOCUMENT_ROOT'] . "/Bibilioteca/Bib/scripts/php/bot.php";
?>