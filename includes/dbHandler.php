<?php
$dbServername="localhost";
$dbUsername="root";
$dbPassword="";
$dbName="fragebogen_projekt";

// Verbindung ausführen
$conn= mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

// Fehlermeldung, falls die Verbindung fehlschlägt
if (!$conn) {
    // Verbindung beenden
    die("Verbindung fehlgeschlagen: ".mysqli_connect_error());
}
