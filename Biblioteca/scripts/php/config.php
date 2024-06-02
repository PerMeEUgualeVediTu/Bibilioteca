<?php
    $host       = "localhost";
    $username   = "bibmin";
    $password   = "bibcz42DF100*";
    $dbname     = "BIB100";
    $dsn        = "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8";
    $options    = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );

    $session_validity = 3600; // un ora
    $procedure_validity = 3600; // un ora
    $prestito_validity = 3600; // un ora
?>