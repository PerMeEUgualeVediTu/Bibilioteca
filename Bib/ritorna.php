<?php
require $_SERVER['DOCUMENT_ROOT'] . "/Bibilioteca/Bib/scripts/php/head.php";
?>

<script defer src="scripts/js/cerca.js"></script>
<script defer src="scripts/js/ritorna.js"></script>

<section id="services">
        <div class="services container">
            <div class="service-top">
                <h1 class="section-title"><span>R</span>estituisci</h1>
                <br>
                <p>Per restituire il tuo libro, selezionalo e riportalo alla libreria corretta. Poi conferma di averlo restituito.</p>
                <br>
                <table id="book-table" class="booktab">
                <tr class="head-table">
                    <th>Titolo</th>
                    <th>Autore</th>
                    <th>Tempo rimasto</th>
                </tr>
                </table>
                <br>
                <p class="lib-prompt"> </p>
                <a type="button" class="cta-return cta" onclick="conferma()">Conferma restituzione</a>

            </div>
        </div>
        
    </section>

<?php
require $_SERVER['DOCUMENT_ROOT'] . "/Bibilioteca/Bib/scripts/php/bot.php";
?>