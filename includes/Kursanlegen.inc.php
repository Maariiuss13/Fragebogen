<?php
include 'functions.php';
?>

<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['kursanlegen'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $Kurs = $_POST['kursname'];
    $Kuerzel = $_POST['kurskuerzel'];

    //Fehlerbehandlungen

    // Prüfung, ob etwas in die Felder eingetragen wurde
    if (empty($Kurs) || empty($Kuerzel)) {
        // Anzeige eines Fehlercodes in der URL
        header("Location: ../Kurs.php?error=leerefelder");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT * FROM kurse WHERE Kuerzel='$Kuerzel'";
        checkKurs($conn, $sql, $Kuerzel, $Kurs);
        // Wenn größer 0 -> Kursname schon vergeben
        if ($resultCheck > 0) {
            header("Location: ../Kurs.php?error=kursnamebereitsvergeben");
            exit();
        } else {
            // Eingegebene Daten in Datenbank einfügen
            $sql = "INSERT INTO kurse (Kuerzel, KName) VALUES (?, ?)";
            insertKurs($conn, $sql, $Kuerzel, $Kurs);
        }
    }
    // closing of the statements
    mysqli_stmt_close($statement);
    // Beendet die Verbindung
    mysqli_close($conn);
}
