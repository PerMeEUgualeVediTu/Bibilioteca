<?php
session_start(); // Assicurati di avviare la sessione

// Controlla se l'utente è autenticato
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
    header('Location: login-user.php'); // Reindirizza se non autenticato
    exit();
}
?>





