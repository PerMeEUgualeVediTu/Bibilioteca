<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/style.css">
    <title>Alexandria</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
    <script defer src="scripts/js/head.js"></script>
</head>

<body>
    <section id="header">
        <div class="header container">
            <div class="nav-bar">
                <div class="brand">
                    <a href="#hero">
                        <h1><span>A</span>lexandria</h1>
                    </a>
                </div>
                <div class="nav-list">
                    <div class="hamburger">
                        <div class="bar"></div>
                    </div>
                    <ul>
                        <li><a href="index.php" data-after="Home">Home</a></li>
                        <li><a href="cerca.php" data-after="Cerca">Cerca</a></li>
                        <li><a href="prenota.php" data-after="Prenota">Prenota</a></li>
                        <li><a href="ritorna.php" data-after="Restituisci">Restituisci</a></li>
                        <li><a href="#contact" data-after="Contatti">Contatti</a></li>
                        <li>
<?php

function get_token () {
    $TOKEN = $_COOKIE['SESSION_TOKEN']; 
    
    return $TOKEN;
}

// profile info
$TOKEN = get_token();

$PASS = false;
$INFOS = NULL;
if (! $TOKEN == NULL) {
    // get user infos
    require "session.php";
    $INFOS = get_session( $TOKEN );

    if ( ( ! $INFOS == NULL ) ) {
        if ( is_string ( $INFOS ) ) {
            echo $INFOS;
        } else {
            $PASS = true;
        }
    }
} 

if ($PASS) { 
    echo "<img src='img/Nic.webp' alt='Profile Picuture' id='NIC'>";
    echo "<script>var user_id = $INFOS;</script>";
} else { 
    echo "<a href='login.php' data-after='Accedi'>Accedi</a>"; 
    echo "<script>var user_id = 1;</script>";
}
?>


                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</body>

</html>

