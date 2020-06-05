<?php
include 'functions.php';
?>

<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['studentanlegen'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $MNR = $_POST['mnr'];
    $Kurskuerzel = $_POST['kurs'];

    //Fehlerbehandlungen

    // Prüfung, ob etwas in die Felder eingetragen wurde
    if (empty($MNR)) {
        // Anzeige eines Fehlercodes in der URL
        header("Location: ../Kurs.php?error=leerefelder");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT * FROM studenten WHERE MNR='$MNR' OR Kurs='$Kurskuerzel'";
        checkStudent($conn, $sql, $MNR, $Kurskuerzel);
        // Wenn größer 0 -> Matrikelnummer schon vergeben
        if ($resultCheck > 0) {
            header("Location: ../Kurs.php?error=matrikelnummerbereitsvergeben");
            exit();
        } else {
            // Eingegebene Daten in Datenbank einfügen
            $sql = "INSERT INTO studenten (MNR, Kurs) VALUES (?, ?)";
            insertStudent($conn, $sql, $MNR, $Kurskuerzel);
        }
    }
    // closing of the statements
    mysqli_stmt_close($statement);
    // Beendet die Verbindung
    mysqli_close($conn);
}
