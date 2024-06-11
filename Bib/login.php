<?php
require $_SERVER['DOCUMENT_ROOT'] . "/Bibilioteca/Bib/scripts/php/head.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/style.css">
    <title>Alexandria</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
</head>

<script defer src="scripts/js/login.js"></script>
<section id="services">
    <div class="services container">
        <div class="service-top">
            <textarea class="input-box-search" id="USR" placeholder="Mail" oninput="mail_check( );"></textarea>
            <textarea class="input-box-search" id="PSW" style='margin-top:1vh;' placeholder="Pass"></textarea>
            <button class="input-box-search" style='margin-top:10vh;' id="cok?" onclick="login();">Login</button>    
        </div>
        <h2 class="error"></h2>
    </div>
</section>
