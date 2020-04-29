<?php
// Prüfen, ob der Befrager auf den Button klickt
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
            // Benutzereingaben beim Anmeldeversuch
            mysqli_stmt_bind_param($statement, "ss", $MNR, $MNR);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($statement);
            // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
            // werden in der Variable $result gespeichert
            $result = mysqli_stmt_get_result($statement);
            // Prüfung, ob $result leer ist oder ein Ergebnis liefert
            if ($row = mysqli_fetch_assoc($result)) {
                // Wenn nein, wird Session aktiviert und Weiterleitung auf Seite Studentenanmeldung
                session_start();
                $_SESSION['session_mnr'] = $row['MNR'];
                header("Location: ../Studenten.php?anmelden=success");
                exit();
            } else {
                // Wenn leer, dann ist Matrikelnummer nicht vorhanden
                header("Location: ../Studentenanmeldung.php?error=matrikelnummernichtvergeben");
                exit();
            }
        }
        // closing of the statements
        mysqli_stmt_close($statement);
        // Beendet die Verbindung
        mysqli_close($conn);
    }
}
