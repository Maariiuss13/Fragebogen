<?php
include 'functions.php';
?>

<?php
// Prüfen, ob der Student auf den Button klickt
if (isset($_POST['studentenanmeldung'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $MNR = $_POST['mnr'];

    //Fehlerbehandlungen

    // Prüfung, ob etwas in die Felder eingetragen wurde
    if (empty($MNR)) {
        // Anzeige eines Fehlercodes in der URL
        header("Location: ../Studentenanmeldung.php?error=leeresFeld");
        // Stoppt die Ausführung
        exit();
    } else {
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT MNR FROM studenten WHERE MNR='$MNR'";
        // Initialisieren mit der richtigen Verbindung
        $statement = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../Studentenanmeldung.php?error=sqlerror");
            exit();
        } else {
            anmeldenStudent($statement);
        }
        // closing of the statements
        mysqli_stmt_close($statement);
        // Beendet die Verbindung
        mysqli_close($conn);
    }
}
