<?php
include 'functions.php';
?>

<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['befrageranmeldung'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $BName = $_POST['befragername'];
    $Passwort = $_POST['passwort'];

    //Fehlerbehandlungen

    // Prüfung, ob etwas in die Felder eingetragen wurde
    if (empty($BName) || empty($Passwort)) {
        // Anzeige eines Fehlercodes in der URL
        header("Location: ../Befrageranmeldung.php?error=leerefelder");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT * FROM befrager WHERE BName='$BName'";
        anmeldenBefrager($conn, $sql, $BName, $Passwort);
    }
    // Close of the statements
    mysqli_stmt_close($statement);
    // Beendet die Verbindung
    mysqli_close($conn);
}
